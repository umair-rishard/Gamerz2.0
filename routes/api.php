<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Api\GoogleLoginController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are for mobile apps / API clients.
| Authenticated routes use Sanctum tokens.
*/

// ----------------------
// Auth (Public)
// ----------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/google-login', [GoogleLoginController::class, 'login']); 
// You may also add: Route::post('/register', [AuthController::class, 'register']); if using API register

// ----------------------
// Public Endpoints
// ----------------------
Route::get('/categories', function () {
    return Category::all();
});

Route::get('/products', function () {
    return Product::all();
});

Route::get('/products/{id}', function ($id) {
    return Product::findOrFail($id);
});

// ----------------------
// Authenticated Endpoints
// ----------------------
Route::middleware('auth:sanctum')->group(function () {

    // ----------------------
    // Current User
    // ----------------------
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth profile + token management
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // ----------------------
    // OTP Verification (API flow)
    // ----------------------
    Route::post('/register/verify-otp', [OtpController::class, 'verifyApi']);
    Route::post('/register/resend-otp', [OtpController::class, 'resendApi']);

    // ----------------------
    // Cart
    // ----------------------
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::put('/cart/{item}', [CartController::class, 'update']);
    Route::delete('/cart/{item}', [CartController::class, 'destroy']);

    // ----------------------
    // Wishlist
    // ----------------------
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy']);

    // ----------------------
    // Orders
    // ----------------------
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
});
