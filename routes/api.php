<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All API endpoints are defined here.
| Public endpoints = no middleware
| Authenticated endpoints = require auth:sanctum
*/

// ----------------------
// Auth (Public)
// ----------------------
Route::post('/login', [AuthController::class, 'login']);

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

    // Current user (kept exactly as you had)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth profile + token management (ADDED)
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

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
});
