<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected function currentUser(Request $request): ?User
    {
        return $request->session()->has('user_id') ? User::find($request->session()->get('user_id')) : null;
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'items' => 'required|array',
            'customerName' => 'required|string',
            'customerEmail' => 'required|email',
            'customerPhone' => 'nullable|string',
            'addressId' => 'required',
        ]);

        // Check stock availability
        foreach ($data['items'] as $item) {
            $product = \App\Models\Product::find($item['id']);
            if (!$product) {
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'Barang ' . ($item['name'] ?? 'tidak diketahui') . ' sudah tidak tersedia atau telah dihapus.'
                ], 400);
            }
            if ($product->stock < ($item['quantity'] ?? 1)) {
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'Stok produk ' . $product->name . ' tidak mencukupi (tersedia: ' . $product->stock . ').'
                ], 400);
            }
        }

        $orderId = 'ORDER-' . strtoupper(Str::random(8));
        $totalAmount = collect($data['items'])->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }) + 15000;

        // Use real DOKU Service
        $dokuService = new \App\Services\DokuService();
        $result = $dokuService->createTransaction(
            $orderId, 
            $totalAmount, 
            $data['customerName'], 
            $data['customerEmail'], 
            $data['customerPhone']
        );

        if ($result['success']) {
            $itemString = collect($data['items'])->map(function ($item) {
                return ($item['quantity'] ?? 1) . ' x ' . ($item['name'] ?? '');
            })->join(', ');

            $transaction = Transaction::create([
                'user_id' => $this->currentUser($request)?->id,
                'order_id' => $orderId,
                'amount' => $totalAmount,
                'status' => 'PENDING',
                'transaction_id' => $result['paymentId'] ?? null,
                'customer_name' => $data['customerName'],
                'customer_email' => $data['customerEmail'],
                'customer_phone' => $data['customerPhone'] ?? '',
                'items' => $data['items'], // Store as JSON (array)
                'message' => 'DOKU transaction created',
            ]);

            if ($user = $this->currentUser($request)) {
                OrderHistory::create([
                    'user_id' => $user->id,
                    'order_id' => $orderId,
                    'total_amount' => $totalAmount,
                    'status' => 'Menunggu pembayaran (DOKU)',
                    'estimated_arrival' => now()->addDays(3),
                    'order_date' => now(),
                    'items' => $data['items'],
                ]);
            }

            return response()->json([
                'status' => 'SUCCESS',
                'redirectUrl' => $result['redirectUrl'],
                'orderId' => $orderId,
            ]);
        }

        // DOKU failed but order was saved — return orderId so front-end can still redirect
        return response()->json([
            'status' => 'FAILED',
            'orderId' => $orderId,
            'message' => $result['message']
        ], 200); // 200 so JS receives the body
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $data = $request->validate([
            'orderId' => 'required|string',
            'status' => 'required|string',
            'transactionId' => 'nullable|string',
        ]);

        $transaction = Transaction::where('order_id', $data['orderId'])->first();
        if (! $transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        $transaction->update([
            'status' => $data['status'],
            'transaction_id' => $data['transactionId'] ?? $transaction->transaction_id,
            'message' => 'Status updated from API',
        ]);

        $orderHistory = OrderHistory::where('order_id', $transaction->order_id)->first();
        if ($orderHistory) {
            $orderHistory->status = $data['status'] === 'SUCCESS' ? 'Sedang dikemas' : $orderHistory->status;
            $orderHistory->estimated_arrival = now()->addDays(2);
            $orderHistory->save();
        }

        return response()->json(['success' => true]);
    }

    public function checkStatus(string $orderId): JsonResponse
    {
        $transaction = Transaction::where('order_id', $orderId)->first();
        if (! $transaction) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json([
            'success' => true,
            'status' => $transaction->status,
            'amount' => $transaction->amount,
            'orderId' => $transaction->order_id,
            'date' => $transaction->created_at->format('d F Y'),
        ]);
    }

    public function verifyPayment(Request $request): JsonResponse
    {
        $orderId = $request->input('orderId');
        $status = $request->input('status');
        
        Log::info("Verification attempt for Order: $orderId, Status: $status");

        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Order ID required'], 400);
        }

        // Find transaction
        $transaction = Transaction::where('order_id', $orderId)->first();
        if (!$transaction) {
            Log::error("Transaction not found for Order: $orderId");
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }

        Log::info("Found transaction $orderId with current status: " . $transaction->status);

        // Update status if it's not already SUCCESS
        if ($transaction->status !== 'SUCCESS') {
            $transaction->update([
                'status' => 'SUCCESS',
                'message' => 'Verified via callback/redirect'
            ]);
            $this->reduceStock($transaction);
            Log::info("Transaction $orderId updated to SUCCESS and stock reduced");
        }

        // Always try to update OrderHistory to be safe
        $orderHistory = OrderHistory::where('order_id', $orderId)->first();
        if ($orderHistory) {
            $orderHistory->update([
                'status' => 'Sedang dikemas',
                'estimated_arrival' => now()->addDays(2),
            ]);
            Log::info("OrderHistory $orderId updated to 'Sedang dikemas'");
        } else {
            Log::warning("OrderHistory not found for Order: $orderId");
        }

        return response()->json(['success' => true]);
    }

    public function webhook(Request $request): JsonResponse
    {
        Log::info('Payment webhook received', $request->all());

        $payload = $request->all();
        $orderId = $payload['invoice_number'] ?? $payload['order']['invoice_number'] ?? null;
        $status = $payload['status'] ?? $payload['transaction_status'] ?? null;

        if ($orderId && (in_array(strtoupper($status), ['PAID', 'SUCCESS', 'DONE', '0000']))) {
            $transaction = Transaction::where('order_id', $orderId)->first();
            if ($transaction && $transaction->status !== 'SUCCESS') {
                $transaction->update(['status' => 'SUCCESS', 'message' => 'Updated via Webhook']);
                $this->reduceStock($transaction);
                Log::info("Webhook: Transaction $orderId updated to SUCCESS and stock reduced");
            }

            $orderHistory = OrderHistory::where('order_id', $orderId)->first();
            if ($orderHistory) {
                $orderHistory->update([
                    'status' => 'Sedang dikemas',
                    'estimated_arrival' => now()->addDays(2),
                ]);
                Log::info("Webhook: OrderHistory $orderId updated to 'Sedang dikemas'");
            }
        }

        return response()->json(['message' => 'OK']);
    }

    protected function reduceStock(Transaction $transaction)
    {
        $items = $transaction->items;
        if (!is_array($items)) return;

        foreach ($items as $item) {
            $productId = $item['id'] ?? null;
            $quantity = $item['quantity'] ?? 1;

            if ($productId) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $quantity);
                }
            }
        }
    }
}
