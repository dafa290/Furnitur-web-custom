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

        $productId = $request->input('product_id') ?? $request->input('productId');
        if (!$productId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }

        $productName = $request->input('productName') ?? $request->input('product_name') ?? 'Produk FurniNest';
        $productPrice = $request->input('productPrice') ?? $request->input('product_price') ?? 0;
        $productImg = $request->input('productImg') ?? $request->input('product_img');

        Wishlist::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $productId],
            [
                'product_name' => $productName,
                'product_price' => $productPrice,
                'product_img' => $productImg
            ]
        );

        return response()->json(['success' => true]);
    }

    public function remove(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (!$user) return response()->json(['error' => 'Unauthorized'], 401);

        $productId = $request->input('product_id') ?? $request->input('productId');
        if (!$productId) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }

        Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        return response()->json(['success' => true]);
    }
}
