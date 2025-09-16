<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\GoogleWebController;

use App\Livewire\AdminLogin;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminProfile;

// ================================
// Public welcome page
// ================================
Route::get('/', fn () => view('welcome'));

// ================================
// OTP verification page (form only)
// ================================
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');

// ================================
// Google login finish (page redirect)
// ================================
Route::get('/google/finish', [GoogleWebController::class, 'finish'])
    ->name('google.finish')
    ->middleware('signed');

// ================================
// Password setup form (Google users)
// ================================
Route::get('/set-password/{user_id}', [PasswordSetupController::class, 'show'])
    ->name('password.setup');

// ================================
// User Routes (protected dashboard)
// ================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'otp.verified',
])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

// ================================
// Admin Routes (all Livewire pages)
// ================================
Route::get('/admin/login', AdminLogin::class)->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');
});

//  Web form posts (needed by your Blade view)
Route::post('/verify-otp', [\App\Http\Controllers\Auth\OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [\App\Http\Controllers\Auth\OtpController::class, 'resend'])->name('verify.otp.resend');


// Set Password (form submit)
Route::post('/set-password/{user_id}', [\App\Http\Controllers\Auth\PasswordSetupController::class, 'store'])
    ->name('password.setup.store');


Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');
