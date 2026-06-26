<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    protected function currentUser(Request $request): ?User
    {
        $userId = $request->session()->get('user_id');
        return $userId ? User::find($userId) : null;
    }

    public function index(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (!$user) return response()->json(['loggedIn' => false, 'items' => []]);

        $items = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->get();

        return response()->json([
            'loggedIn' => true,
            'items' => $items
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (!$user) return response()->json(['error' => 'Login required'], 401);

        $request->validate(['product_id' => 'required|integer']);

        $product = \App\Models\Product::find($request->product_id);
        if (!$product) return response()->json(['error' => 'Product not found'], 404);

        Wishlist::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $request->product_id],
            [
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_img' => $product->img
            ]
        );

        return response()->json(['success' => true]);
    }

    public function remove(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (!$user) return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate(['product_id' => 'required|integer']);

        Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json(['success' => true]);
    }
}
