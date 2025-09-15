<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\GoogleWebController;
use App\Livewire\AdminLogin;
use App\Livewire\AdminDashboard;
use App\Livewire\AdminProfile; // ✅ Admin Profile Livewire

// ================================
// Public welcome page
// ================================
Route::get('/', function () {
    return view('welcome');
});

// ================================
// OTP verification (user flow)
// ================================
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend');

// ================================
// Google login finish
// ================================
Route::get('/google/finish', [GoogleWebController::class, 'finish'])
    ->name('google.finish')
    ->middleware('signed');

// ================================
// Password setup for Google users
// ================================
Route::get('/set-password/{user_id}', [PasswordSetupController::class, 'show'])->name('password.setup');
Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store'])->name('password.setup.store');

// ================================
// User Routes
// ================================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'otp.verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ================================
// Admin Routes
// ================================
Route::get('/admin/login', AdminLogin::class)->name('admin.login'); // ✅ Admin login

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard'); // ✅ Admin dashboard
    Route::get('/admin/profile', AdminProfile::class)->name('admin.profile');       // ✅ Admin profile
});
