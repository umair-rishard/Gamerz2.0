<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminAuthController;    // Admin API login
use App\Http\Controllers\Api\AdminProfileController; // Admin Profile API
use App\Http\Controllers\Api\AdminTwoFactorController; // 2FA controller
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are for mobile apps / API clients.
| Authenticated routes use Sanctum tokens.
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
Route::post('/admin/login', [AdminAuthController::class, 'login']);          // login
Route::post('/admin/verify-2fa', [AdminAuthController::class, 'verify2fa']); // 2FA verify

// ----------------------
// Public Endpoints
// ----------------------
Route::get('/products', [ProductController::class, 'index']);     // list
Route::get('/products/{id}', [ProductController::class, 'show']); // details

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

    // Admin logout (Token revoke)
    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

    // ========================
    // Orders (user-side)
    // ========================
    Route::get('/orders',  [OrderController::class, 'index']);  // current user's orders
    Route::post('/orders', [OrderController::class, 'store']);  // place order from cart

    // ========================
    // Cart
    // ========================
    Route::get('/cart', [CartController::class, 'index']);    // view cart
    Route::post('/cart', [CartController::class, 'store']);   // add item
    Route::delete('/cart/{id}', [CartController::class, 'destroy']); // remove item

    // ========================
    // Wishlist
    // ========================
    Route::get('/wishlist', [WishlistController::class, 'index']);    // get wishlist items
    Route::post('/wishlist', [WishlistController::class, 'store']);   // add item
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']); // remove item

    // ========================
    // Admin Profile
    // ========================
    Route::middleware('is_admin')->group(function () {
        // Profile CRUD
        Route::get('/admin/profile', [AdminProfileController::class, 'show']);                 // fetch profile
        Route::put('/admin/profile', [AdminProfileController::class, 'update']);               // update name/email
        Route::post('/admin/change-password', [AdminProfileController::class, 'changePassword']); // update password
        Route::post('/admin/delete', [AdminProfileController::class, 'destroy']);              // delete account

        // 2FA actions (used by your Blade)
        Route::get('/admin/2fa/recovery-codes', [AdminTwoFactorController::class, 'recoveryCodes']);
        Route::post('/admin/2fa/regenerate',     [AdminTwoFactorController::class, 'regenerateRecoveryCodes']);
        Route::post('/admin/2fa/disable',        [AdminTwoFactorController::class, 'disable']);
    });

    // ========================
    // Admin-only (CRUD)
    // ========================
    Route::middleware('is_admin')->group(function () {
        // Categories
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // Products (Admin CRUD)
        Route::get('/admin-products', [ProductController::class, 'index']);               // list
        Route::get('/admin-products/{product}', [ProductController::class, 'show']);      // single
        Route::post('/admin-products', [ProductController::class, 'store']);              // create
        Route::patch('/admin-products/{product}', [ProductController::class, 'update']);  // update
        Route::delete('/admin-products/{product}', [ProductController::class, 'destroy']); // delete
    });
});
