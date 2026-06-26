<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::post('/products/filter', [ProductController::class, 'filter']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/remove', [CartController::class, 'remove']);
Route::post('/cart/clear', [CartController::class, 'clear']);
Route::post('/cart/sync', [CartController::class, 'sync']);

Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
Route::post('/wishlist/add', [ProfileController::class, 'addToWishlist']);
Route::post('/wishlist/remove', [ProfileController::class, 'removeFromWishlist']);
Route::get('/wishlist', [ProfileController::class, 'getWishlist']);
Route::get('/addresses', [ProfileController::class, 'getAddresses']);

Route::post('/payments/create', [PaymentController::class, 'create']);
Route::post('/payments/update-status', [PaymentController::class, 'updateStatus']);
Route::post('/payments/webhook', [PaymentController::class, 'webhook']);
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
