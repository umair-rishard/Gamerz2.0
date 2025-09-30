<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminProfileController;
use App\Http\Controllers\Api\AdminTwoFactorController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CheckoutController; 
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ----------------------
// Public Auth
// ----------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/google-login', [GoogleLoginController::class, 'login'])
    ->withoutMiddleware([EnsureFrontendRequestsAreStateful::class]);

// ----------------------
// Admin Auth (Public)
// ----------------------
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/verify-2fa', [AdminAuthController::class, 'verify2fa']);

// ----------------------
// Public Endpoints (User)
// ----------------------
Route::get('/products', [ProductController::class, 'userIndex']);   // ✅ new user list
Route::get('/products/{id}', [ProductController::class, 'userShow']); // ✅ new user detail

// ----------------------
// Authenticated Endpoints (Sanctum Protected)
// ----------------------
Route::middleware('auth:sanctum')->group(function () {

    // Current User
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/me', [AuthController::class, 'me']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // OTP Verification
    Route::post('/verify-otp', [OtpController::class, 'verify']);
    Route::post('/verify-otp/resend', [OtpController::class, 'resend']);
    Route::post('/register/verify-otp', [OtpController::class, 'verifyApi']);
    Route::post('/register/resend-otp', [OtpController::class, 'resendApi']);

    // Password setup (Google users)
    Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store']);

    // Admin logout
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    // ========================
    // Checkout Summary
    // ========================
    Route::get('/checkout', [CheckoutController::class, 'summary']); // ✅ NEW: neat summary for UI

    // ========================
    // Orders
    // ========================
    Route::get('/orders',  [OrderController::class, 'index']);   // list user orders
    Route::post('/orders', [OrderController::class, 'store']);   // place order
    Route::get('/orders/{id}', [OrderController::class, 'show']); // fetch single order

    // ========================
    // Cart (Protected)
    // ========================
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);             // add (always positive)
    Route::patch('/cart/{item}', [CartController::class, 'update']);    // set exact quantity
    Route::delete('/cart/{item}', [CartController::class, 'destroy']);  // remove item

    // ========================
    // Wishlist (Protected)
    // ========================
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    // ========================
    // Admin Profile (Protected)
    // ========================
    Route::middleware('is_admin')->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class, 'show']);
        Route::put('/admin/profile', [AdminProfileController::class, 'update']);
        Route::post('/admin/change-password', [AdminProfileController::class, 'changePassword']);
        Route::post('/admin/delete', [AdminProfileController::class, 'destroy']);

        // 2FA
        Route::get('/admin/2fa/recovery-codes', [AdminTwoFactorController::class, 'recoveryCodes']);
        Route::post('/admin/2fa/regenerate', [AdminTwoFactorController::class, 'regenerateRecoveryCodes']);
        Route::post('/admin/2fa/disable', [AdminTwoFactorController::class, 'disable']);
    });

    // ========================
    // Admin CRUD (Protected)
    // ========================
    Route::middleware('is_admin')->group(function () {
        // Categories
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Products
        Route::get('/admin-products', [ProductController::class, 'index']);        // admin list
        Route::get('/admin-products/{product}', [ProductController::class, 'show']); // admin detail
        Route::post('/admin-products', [ProductController::class, 'store']);
        Route::patch('/admin-products/{product}', [ProductController::class, 'update']);
        Route::delete('/admin-products/{product}', [ProductController::class, 'destroy']);
    });
});
