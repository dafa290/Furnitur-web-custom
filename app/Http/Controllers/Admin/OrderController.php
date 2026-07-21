<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Manajemen Pesanan: Update status pengiriman dan pembayaran.
     */
    public function index()
    {
        $orders = OrderHistory::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = OrderHistory::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function show($id)
    {
        $order = OrderHistory::with('user')->findOrFail($id);
        
        $transaction = Transaction::where('order_id', $order->order_id)->first();
        $items = null;
        if ($transaction && !empty($transaction->items)) {
            $items = is_string($transaction->items) ? json_decode($transaction->items, true) : $transaction->items;
        } elseif (!empty($order->items)) {
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
        }
        
        $itemList = [];
        if (is_array($items)) {
            foreach ($items as $itm) {
                if (is_array($itm)) {
                    $pId = $itm['id'] ?? null;
                    $img = $itm['img'] ?? null;
                    if (!$img && $pId) {
                        $prod = \App\Models\Product::find($pId);
                        $img = $prod ? $prod->img : null;
                    }
                    if ($img && !str_starts_with($img, 'http') && !str_starts_with($img, '/')) {
                        $img = '/images/products/' . $img;
                    }
                    $itemList[] = [
                        'id' => $pId ?? '-',
                        'name' => $itm['name'] ?? ($itm['product_name'] ?? 'Produk FurniNest'),
                        'price' => $itm['price'] ?? 0,
                        'quantity' => $itm['quantity'] ?? 1,
                        'img' => $img ?: '/images/placeholder.jpg',
                    ];
                }
            }
        }
        $order->items_list = $itemList;

        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = OrderHistory::findOrFail($id);
        
        // Hapus juga dari tabel transaksi agar tidak muncul kembali
        Transaction::where('order_id', $order->order_id)->delete();
        
        $order->delete();

        return redirect('/admin/orders')->with('success', 'Pesanan berhasil dihapus secara permanen.');
    }
}
