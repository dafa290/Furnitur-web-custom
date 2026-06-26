<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;

/**
 * API Controller untuk Manajemen Keranjang (Cart).
 * Menangani penambahan, penghapusan, dan sinkronisasi barang belanjaan.
 */
class CartController extends Controller
{
    protected function currentUser(Request $request): ?User
    {
        return $request->session()->has('user_id') ? User::find($request->session()->get('user_id')) : null;
    }

    public function index(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['loggedIn' => false]);
        }

        $hasImageColumn = Schema::hasColumn('cart_items', 'product_image');
        $items = CartItem::where('user_id', $user->id)->get()->map(function ($item) use ($hasImageColumn) {
            // Fallback: if cart_item doesn't have image, try to get from Product model
            $img = $hasImageColumn ? $item->product_image : null;
            if (!$img) {
                $product = \App\Models\Product::find($item->product_id);
                $img = $product ? $product->img : null;
            }

            return [
                'id' => $item->product_id,
                'name' => $item->product_name,
                'price' => $item->product_price,
                'img' => $img,
                'quantity' => $item->quantity,
            ];
        });

        return response()->json([
            'loggedIn' => true,
            'items' => $items,
            'count' => $items->sum('quantity'),
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $data = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|integer',
            'img' => 'nullable|string',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);
        $item = CartItem::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $data['id'],
        ]);
        $item->product_name = $data['name'];
        $item->product_price = $data['price'];
        if (Schema::hasColumn('cart_items', 'product_image')) {
            $item->product_image = $data['img'] ?? null;
        }
        $item->quantity = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->save();

        $count = CartItem::where('user_id', $user->id)->sum('quantity');
        return response()->json(['success' => true, 'count' => $count]);
    }

    public function remove(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate(['id' => 'required|integer']);
        CartItem::where('user_id', $user->id)->where('product_id', $data['id'])->delete();
        $count = CartItem::where('user_id', $user->id)->sum('quantity');

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function clear(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if ($user) {
            $ids = $request->input('ids');
            if ($ids && is_array($ids)) {
                // Remove specific items (useful for selective checkout)
                CartItem::where('user_id', $user->id)->whereIn('product_id', $ids)->delete();
            } else {
                // Remove all items
                CartItem::where('user_id', $user->id)->delete();
            }
        }
        return response()->json(['success' => true]);
    }

    public function sync(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $items = $request->input('items', []);
        foreach ($items as $data) {
            if (! isset($data['id'], $data['name'], $data['price'], $data['quantity'])) {
                continue;
            }

            $item = CartItem::firstOrNew([
                'user_id' => $user->id,
                'product_id' => $data['id'],
            ]);
            $item->product_name = $data['name'];
            $item->product_price = (int) $data['price'];
            if (Schema::hasColumn('cart_items', 'product_image')) {
                $item->product_image = $data['img'] ?? null;
            }
            $item->quantity = max(1, $item->exists ? $item->quantity + (int)$data['quantity'] : (int)$data['quantity']);
            $item->save();
        }

        $count = CartItem::where('user_id', $user->id)->sum('quantity');
        return response()->json(['success' => true, 'count' => $count]);
    }
}
