<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Product;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\CategoryController; // ← NEW

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful; 

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

// Google login (no CSRF/stateful)
Route::post('/google-login', [GoogleLoginController::class, 'login'])
    ->withoutMiddleware([EnsureFrontendRequestsAreStateful::class]);

// ----------------------
// Public Endpoints (data)
// ----------------------
// ❌ Removed Category GETs from API (your rule: GETs belong in web.php)
Route::get('/products', fn () => Product::all());
Route::get('/products/{id}', fn ($id) => Product::findOrFail($id));

// ----------------------
// Authenticated Endpoints (Sanctum Protected)
// ----------------------
Route::middleware('auth:sanctum')->group(function () {

    // Current User
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // OTP Verification (API flow)
    Route::post('/verify-otp', [OtpController::class, 'verify']); // API version
    Route::post('/verify-otp/resend', [OtpController::class, 'resend']);
    Route::post('/register/verify-otp', [OtpController::class, 'verifyApi']);
    Route::post('/register/resend-otp', [OtpController::class, 'resendApi']);

    // Password setup (Google users)
    Route::post('/set-password/{user_id}', [\App\Http\Controllers\Auth\PasswordSetupController::class, 'store']);

    // Admin logout (API style, returns JSON)
    Route::post('/admin/logout', function (Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Admin logged out']);
    });

    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::put('/cart/{item}', [CartController::class, 'update']);
    Route::delete('/cart/{item}', [CartController::class, 'destroy']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);

    //  Categories CRUD (Admin via API; no GETs here)
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});
