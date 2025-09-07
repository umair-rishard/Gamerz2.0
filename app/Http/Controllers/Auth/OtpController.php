<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showVerifyForm()
    {
        // If already verified, go to dashboard
        if (Auth::check() && Auth::user()->is_verified) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP entered by the user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'min:6', 'max:6'],
        ]);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ check OTP matches and not expired
        if (
            (string)$user->otp_code === (string)$request->otp_code &&
            $user->otp_expires_at &&
            Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)
        ) {
            $user->is_verified = true;
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            return redirect()->route('dashboard')->with('status', 'Email verified successfully!');
        }

        return back()->withErrors(['otp_code' => 'Invalid or expired OTP, please try again.']);
    }

    /**
     * Resend a fresh OTP to the user's email.
     */
    public function resend()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        self::sendOtp($user);

        return back()->with('status', 'A new OTP has been sent to your email. It will expire in 5 minutes.');
    }

    /**
     * Generate and send a new OTP to the user's email.
     */
    public static function sendOtp(User $user): void
    {
        $otp = (string)random_int(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5); // ✅ expires in 5 mins
        $user->save();

        Mail::raw("Your GAMERZ2.0 OTP is: {$otp}\n\nNote: This code will expire in 5 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('GAMERZ2.0 Email Verification OTP');
        });
    }
}
