<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;

Route::get('/', function () {
    return view('welcome');
});

// OTP verification routes
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend'); // ✅ new

// Protected routes (only for verified + OTP-checked users)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'otp.verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
