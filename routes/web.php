<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\GoogleWebController;
use App\Http\Controllers\Api\OrderController; 

// Laravel Fortify (User login)
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Livewire – Admin
use App\Livewire\AdminDashboard;
use App\Livewire\AdminProfile;

// Livewire – Products
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\ProductForm;

// Livewire – Categories
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\CategoryForm;

// Livewire – Orders page
use App\Livewire\Admin\Orders\OrderList;

// Livewire – Orders show page
use App\Livewire\Admin\Orders\OrderShow;

// Livewire – User page
use App\Livewire\Admin\Users\UserList;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| User Login (Fortify default)
|--------------------------------------------------------------------------
*/
// User login (Fortify’s own login)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

/*
|--------------------------------------------------------------------------
| OTP / Auth helper pages
|--------------------------------------------------------------------------
*/
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');
Route::get('/google/finish', [GoogleWebController::class, 'finish'])
    ->name('google.finish')
    ->middleware('signed');
Route::get('/set-password/{user_id}', [PasswordSetupController::class, 'show'])
    ->name('password.setup');

/*
|--------------------------------------------------------------------------
| User (Jetstream) – Protected
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'otp.verified',
])->group(function () {
    // New Modern User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.main'); // new modern dashboard.blade.php
    })->name('dashboard');

    //  Checkout Page
    Route::view('/checkout', 'checkout.index')->name('checkout.index');

    //  Order Confirmation Page
    Route::get('/orders/{id}/confirm', function ($id) {
        return view('orders.confirm', compact('id'));
    })->name('orders.confirm');

    //  Download Receipt (PDF) from Api\OrderController
    Route::get('/orders/{order}/receipt', [OrderController::class, 'downloadReceipt'])
        ->name('orders.receipt');

    //  Cart & Wishlist
    Route::view('/cart', 'cart.index')->name('cart.index');
    Route::view('/wishlist', 'wishlist.index')->name('wishlist.index');

    //  User Dashboard Orders
    Route::view('/dashboard/orders', 'dashboard.orders.order')->name('dashboard.orders.index');
    Route::get('/dashboard/orders/{id}', function ($id) {
        return view('dashboard.orders.show', compact('id'));
    })->name('dashboard.orders.show');

    //  User Reviews (only for delivered orders)
    Route::get('/dashboard/orders/{id}/review', function ($id) {
        return view('dashboard.orders.review', compact('id'));
    })->name('dashboard.orders.review');
});

/*
|--------------------------------------------------------------------------
| Admin Pages (Axios Token Auth handled in frontend)
|--------------------------------------------------------------------------
*/
// Admin login (Blade page that uses Axios)
Route::view('/admin/login', 'livewire.admin.admin-login')->name('admin.login');

// Dashboard & Profile
Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');

// Products (Admin)
Route::get('/admin/products', ProductList::class)->name('admin.products.index');
Route::get('/admin/products/create', ProductForm::class)->name('admin.products.create');
Route::get('/admin/products/{product}/edit', ProductForm::class)->name('admin.products.edit');

// Categories (Admin)
Route::get('/admin/categories', CategoryList::class)->name('admin.categories.index');
Route::get('/admin/categories/create', CategoryForm::class)->name('admin.categories.create');
Route::get('/admin/categories/{category}/edit', CategoryForm::class)->name('admin.categories.edit');

/*
|--------------------------------------------------------------------------
| Form POSTs (web)
|--------------------------------------------------------------------------
*/
// OTP
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend');

// Password setup
Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store'])->name('password.setup.store');

// Admin logout (fallback only; frontend clears token)
Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Public Product Pages (Blade + Axios)
|--------------------------------------------------------------------------
*/
// Shop products
Route::get('/products', function () {
    return view('products.index');   // Blade view
})->name('products.index');

// Product details
Route::get('/products/{id}', function ($id) {
    return view('products.show', compact('id'));
})->name('products.show');

/*
|--------------------------------------------------------------------------
| Admin Orders + Users
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders', OrderList::class)->name('admin.orders.index');
Route::get('/admin/orders/{orderId}', OrderShow::class)->name('admin.orders.show');
Route::get('/admin/users', UserList::class)->name('admin.users.index');
