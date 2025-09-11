<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Controllers\Auth\GoogleWebController; 

/*
|--------------------------------------------------------------------------
| Web Routes (Blade/Fortify)
|--------------------------------------------------------------------------
| Browser flow: Register → OTP → Dashboard
| Google flow: Google → OTP (if you keep it) → Set Password → Dashboard
*/

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// ----------------------
// OTP Verification (Web flow)
// ----------------------
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('verify.otp');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');
Route::post('/verify-otp/resend', [OtpController::class, 'resend'])->name('verify.otp.resend');

// ----------------------
// Google web-session finisher (signed URL from backend)
// ----------------------
Route::get('/google/finish', [GoogleWebController::class, 'finish'])
    ->name('google.finish')
    ->middleware('signed');

// ----------------------
// Password Setup (for new Google users after OTP)
// ----------------------
Route::get('/set-password/{user_id}', [PasswordSetupController::class, 'show'])->name('password.setup');
Route::post('/set-password/{user_id}', [PasswordSetupController::class, 'store'])->name('password.setup.store');

// ----------------------
// Protected routes → user must be logged in + verified via OTP
// ----------------------
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',        // Jetstream's email verification (if used)
    'otp.verified',    // your custom OTP gate
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
