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
| ADMIN AREA (Blade + Livewire)
| Axios token auth is handled on the frontend for admin pages.
| Order: Login, Dashboard/Profile, Products, Categories, Orders, Users, Logout.
|--------------------------------------------------------------------------
*/

// Admin login (Blade page that uses Axios)
Route::view('/admin/login', 'livewire.admin.admin-login')->name('admin.login');

// Admin dashboard and profile
Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');

// Admin products: list, create, edit
Route::get('/admin/products', ProductList::class)->name('admin.products.index');
Route::get('/admin/products/create', ProductForm::class)->name('admin.products.create');
Route::get('/admin/products/{product}/edit', ProductForm::class)->name('admin.products.edit');

// Admin categories: list, create, edit
Route::get('/admin/categories', CategoryList::class)->name('admin.categories.index');
Route::get('/admin/categories/create', CategoryForm::class)->name('admin.categories.create');
Route::get('/admin/categories/{category}/edit', CategoryForm::class)->name('admin.categories.edit');

// Admin orders and users
Route::get('/admin/orders', OrderList::class)->name('admin.orders.index');
Route::get('/admin/orders/{orderId}', OrderShow::class)->name('admin.orders.show');
Route::get('/admin/users', UserList::class)->name('admin.users.index');

// Admin logout (fallback only; frontend clears token)
Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');


/*
|--------------------------------------------------------------------------
| USER AREA (Jetstream Protected)
| Middleware: auth:sanctum + jetstream session + verified + otp.verified
| Includes: user dashboard, checkout, orders, receipt, cart, wishlist, reviews.
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'otp.verified',
])->group(function () {
    // Modern user dashboard (Blade view entry)
    Route::get('/dashboard', function () {
        return view('dashboard.main'); 
    })->name('dashboard');

    // Checkout page
    Route::view('/checkout', 'checkout.index')->name('checkout.index');

    // Order confirmation page (view by order id)
    Route::get('/orders/{id}/confirm', function ($id) {
        return view('orders.confirm', compact('id'));
    })->name('orders.confirm');

    // Download receipt (PDF) via Api\OrderController
    Route::get('/orders/{order}', [OrderController::class, 'downloadReceipt'])
        ->name('orders.receipt');

    // Cart and wishlist
    Route::view('/cart', 'cart.index')->name('cart.index');
    Route::view('/wishlist', 'wishlist.index')->name('wishlist.index');

    // User dashboard orders list and show
    Route::view('/dashboard/orders', 'dashboard.orders.order')->name('dashboard.orders.index');
    Route::get('/dashboard/orders/{id}', function ($id) {
        return view('dashboard.orders.show', compact('id'));
    })->name('dashboard.orders.show');

    // User reviews (only for delivered orders)
    Route::get('/dashboard/orders/{id}/review', function ($id) {
        return view('dashboard.orders.review', compact('id'));
    })->name('dashboard.orders.review');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION & OTP HELPERS (Public Endpoints)
| Fortify login page, OTP verify/resend, Google sign-in finish, password setup.
| Post routes are grouped here for easy reference during viva.
|--------------------------------------------------------------------------
*/

// Fortify default login page (public)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');

// OTP verification pages
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend');

// Google OAuth finish (signed URL)
Route::get('/google/finish', [GoogleWebController::class, 'finish'])
    ->name('google.finish')
    ->middleware('signed');

// Password setup pages
Route::get('/set-password/{user_id}', [PasswordSetupController::class, 'show'])
    ->name('password.setup');
Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store'])
    ->name('password.setup.store');


/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (Blade + Axios)
| Home, contact, product listing and product details.
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Public contact page
Route::view('/contact', 'contact')->name('contact');

// Public product pages
Route::get('/products', function () {
    return view('products.index');   // Blade view for shop listing
})->name('products.index');

Route::get('/products/{id}', function ($id) {
    return view('products.show', compact('id')); // Blade view for product details
})->name('products.show');
