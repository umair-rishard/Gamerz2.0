<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\GoogleWebController;

// Laravel Fortify (User login)
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Livewire – Admin
use App\Livewire\AdminLogin;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminProfile;

// Livewire – Products
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\ProductForm;

// Livewire – Categories
use App\Livewire\Admin\Categories\CategoryList;
use App\Livewire\Admin\Categories\CategoryForm;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| User Login (Fortify default)
|--------------------------------------------------------------------------
*/
// ✅ This restores the normal user login page
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
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin (Livewire pages) — GET only
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', AdminLogin::class)->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');

    // Products (Livewire pages)
    Route::get('/admin/products', ProductList::class)->name('admin.products.index');
    Route::get('/admin/products/create', ProductForm::class)->name('admin.products.create');
    Route::get('/admin/products/{product}/edit', ProductForm::class)->name('admin.products.edit');

    // Categories (Livewire pages)
    Route::get('/admin/categories', CategoryList::class)->name('admin.categories.index');
    Route::get('/admin/categories/create', CategoryForm::class)->name('admin.categories.create');
    Route::get('/admin/categories/{category}/edit', CategoryForm::class)->name('admin.categories.edit');
});

/*
|--------------------------------------------------------------------------
| Form POSTs (web)
|--------------------------------------------------------------------------
*/
// OTP (web form submits)
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend');

// Password setup
Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store'])->name('password.setup.store');

// Admin logout
Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');
