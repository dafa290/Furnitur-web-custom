<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', [PageController::class, 'home']);
Route::get('/test', [TestController::class, 'test']);
Route::get('/home', [PageController::class, 'home']);
Route::get('/checkout', [PageController::class, 'checkout']);
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/custom', [PageController::class, 'customizeLemari']);
Route::get('/customize/lemari', [PageController::class, 'customizeLemari']);
Route::get('/product/{id}', [PageController::class, 'productDetail']);
Route::get('/alamat/manage', [PageController::class, 'manageAddresses']);
Route::post('/alamat/add', [AddressController::class, 'add']);
Route::get('/alamat/edit/{id}', [AddressController::class, 'edit']);
Route::post('/alamat/update/{id}', [AddressController::class, 'update']);
Route::delete('/alamat/delete/{id}', [AddressController::class, 'delete']);
Route::post('/alamat/set-default/{id}', [AddressController::class, 'setDefault']);
Route::get('/payment-success', [PageController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-failed', [PageController::class, 'paymentFailed']);
Route::get('/profile', [PageController::class, 'profile']);

// API style routes with Session Support
Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::post('/products/filter', [ProductController::class, 'filter']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
    Route::post('/cart/sync', [CartController::class, 'sync']);

    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/add', [WishlistController::class, 'add']);
    Route::post('/wishlist/remove', [WishlistController::class, 'remove']);

    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
    Route::get('/addresses', [ProfileController::class, 'getAddresses']);

    Route::post('/payments/create', [PaymentController::class, 'create']);
    Route::post('/payments/update-status', [PaymentController::class, 'updateStatus']);
    Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
    Route::get('/orders/status/{orderId}', [PaymentController::class, 'checkStatus']);
    Route::post('/payments/verify', [PaymentController::class, 'verifyPayment']);
});

// Admin Routes (Grup rute untuk manajemen dashboard oleh Admin)
Route::middleware(['admin'])->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Manajemen Produk
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/edit/{id}', [AdminProductController::class, 'edit']);
    Route::post('/products/update/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);
    
    // Manajemen Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy']);

    // Manajemen Pelanggan
    Route::get('/users', [AdminUserController::class, 'index']);
    Route::post('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive']);
});
