<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

/**
 * Controller Utama untuk Navigasi Halaman (View).
 * Mengatur tampilan dari Home hingga Checkout.
 */
class PageController extends Controller
{
    // ============ SECTION 1: HALAMAN UMUM ============
    protected function currentUser()
    {
        // Mendukung session 'user_id' atau 'currentUser' dari turn sebelumnya
        $userId = session('user_id') ?? (session('currentUser') ? session('currentUser')->id : null);
        return $userId ? User::find($userId) : null;
    }

    protected function cartCount(): int
    {
        $user = $this->currentUser();
        return $user ? CartItem::where('user_id', $user->id)->sum('quantity') : 0;
    }

    public function home()
    {
        return view('pages.home', [
            'user' => $this->currentUser(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function login()
    {
        if ($this->currentUser()) return redirect('/home');
        return view('pages.login');
    }

    public function register()
    {
        if ($this->currentUser()) return redirect('/home');
        return view('pages.register');
    }

    public function checkout()
    {
        $user = $this->currentUser();
        $cartItems = $user ? CartItem::where('user_id', $user->id)->get() : [];
        $addresses = $user ? Address::where('user_id', $user->id)->get() : collect([]);
        
        return view('pages.checkout', [
            'user' => $user,
            'cartItems' => $cartItems,
            'addresses' => $addresses,
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function customizeLemari()
    {
        return view('pages.customize', [
            'user' => $this->currentUser(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    // ============ SECTION 3: PRODUK & KUSTOMISASI ============
    public function productDetail($id)
    {
        $product = Product::find($id);
        if (!$product) {
            // Dummy product for testing if not found
            $product = new Product([
                'id' => $id,
                'name' => 'Produk FurniNest',
                'price' => 5000000,
                'description' => 'Deskripsi produk premium FurniNest.',
                'img' => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=500',
                'stock' => 10,
                'rating' => 4.5
            ]);
        }

        return view('pages.product-detail', [
            'product' => $product,
            'user' => $this->currentUser(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function manageAddresses()
    {
        $user = $this->currentUser();
        if (!$user) return redirect('/login');

        return view('pages.addresses', [
            'user' => $user,
            'addresses' => Address::where('user_id', $user->id)->get(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function profile(Request $request)
    {
        $user = $this->currentUser();
        if (!$user) return redirect('/login');

        $tab = $request->query('tab', 'profile');
        
        return view('pages.profile', [
            'user' => $user,
            'tab' => $tab,
            'addresses' => Address::where('user_id', $user->id)->get(),
            'orders' => OrderHistory::where('user_id', $user->id)->get(),
            'wishlists' => \App\Models\Wishlist::where('user_id', $user->id)->get(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function paymentSuccess()
    {
        return view('pages.payment-success', [
            'user' => $this->currentUser(),
            'cartCount' => $this->cartCount(),
        ]);
    }

    public function paymentFailed()
    {
        return view('pages.payment-failed', [
            'user' => $this->currentUser(),
            'cartCount' => $this->cartCount(),
        ]);
    }
}