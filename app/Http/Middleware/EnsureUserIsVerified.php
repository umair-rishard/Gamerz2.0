<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            return redirect()->route('verify.otp')
                ->withErrors(['otp_code' => 'Please verify your email using the OTP we sent.']);
        }

        return $next($request);
    }
}
