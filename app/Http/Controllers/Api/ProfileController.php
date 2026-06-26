<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected function currentUser(Request $request): ?User
    {
        return $request->session()->has('user_id') ? User::find($request->session()->get('user_id')) : null;
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:32',
        ]);

        $user->update($data);
        return response()->json(['status' => 'SUCCESS']);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:6',
        ]);

        if (! Hash::check($data['oldPassword'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah']);
        }

        $user->password = Hash::make($data['newPassword']);
        $user->save();

        return response()->json(['status' => 'SUCCESS']);
    }

    public function addToWishlist(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Silakan login'], 401);
        }

        $data = $request->validate([
            'productId' => 'required|integer',
            'productName' => 'required|string',
            'productPrice' => 'required|integer',
            'productImg' => 'nullable|string',
        ]);

        $exists = Wishlist::where('user_id', $user->id)->where('product_id', $data['productId'])->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Sudah ada di wishlist']);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $data['productId'],
            'product_name' => $data['productName'],
            'product_price' => $data['productPrice'],
            'product_img' => $data['productImg'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Ditambahkan ke wishlist']);
    }

    public function removeFromWishlist(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate(['productId' => 'required|integer']);
        Wishlist::where('user_id', $user->id)->where('product_id', $data['productId'])->delete();
        return response()->json(['success' => true]);
    }

    public function getAddresses(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(Address::where('user_id', $user->id)->get());
    }

    public function getWishlist(Request $request): JsonResponse
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(Wishlist::where('user_id', $user->id)->get());
    }
}
