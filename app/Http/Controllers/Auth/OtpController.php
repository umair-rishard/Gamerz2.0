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
     * ========================
     * 🌐 WEB FLOW
     * ========================
     */

    // Show OTP verification form (web)
    public function showVerifyForm(Request $request)
    {
        if (Auth::check() && Auth::user()->is_verified) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp', [
            'user_id' => $request->query('user_id'),   // present for Google flow
            'is_new'  => $request->query('new') == 1,  // present for Google-first-login
        ]);
    }

    // Verify OTP (web)
    public function verify(Request $request)
    {
        // Register flow: NO user_id (use Auth::user())
        // Google flow: HAS user_id (use that)
        $rules = ['otp_code' => 'required|string|size:6'];
        if ($request->filled('user_id')) {
            $rules['user_id'] = 'integer';
        }
        $request->validate($rules);

        $user = $request->filled('user_id')
            ? User::find($request->input('user_id'))
            : Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $otpOk = hash_equals((string) $user->otp_code, (string) $request->input('otp_code'));
        $notExpired = $user->otp_expires_at && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at);

        if ($otpOk && $notExpired) {
            $user->forceFill([
                'is_verified'       => true,
                'email_verified_at' => $user->email_verified_at ?? now(), 
                'otp_code'          => null,
                'otp_expires_at'    => null,
            ])->save();

            // Ensure they are logged in
            Auth::login($user);
            $request->session()->regenerate();

            // First-time Google login? (POST hidden input or query param)
            $isNewGoogle = $request->boolean('new') || $request->query('new') == 1;

            if ($isNewGoogle) {
                return redirect()
                    ->route('password.setup', $user->id)
                    ->with('status', 'OTP verified! Please set your password.');
            }

            // Normal register flow → straight to dashboard
            return redirect()
                ->route('dashboard')
                ->with('status', 'Email verified successfully!');
        }

        return back()->withErrors(['otp_code' => 'Invalid or expired OTP, please try again.']);
    }

    // Resend OTP (web) — supports both flows
    public function resend(Request $request)
    {
        $user = $request->filled('user_id')
            ? User::find($request->input('user_id'))
            : Auth::user();

        if (!$user) {
            return back()->withErrors(['otp_code' => 'User not found. Please login again.']);
        }

        self::sendOtp($user);

        return back()->with('status', 'A new OTP has been sent to your email. It will expire in 5 minutes.');
    }

    /**
     * ========================
     * 📱 API FLOW
     * ========================
     */

    public function verifyApi(Request $request)
    {
        $request->validate(['otp_code' => 'required|string|size:6']);

        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $otpOk = hash_equals((string) $user->otp_code, (string) $request->input('otp_code'));
        $notExpired = $user->otp_expires_at && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at);

        if ($otpOk && $notExpired) {
            $user->forceFill([
                'is_verified'       => true,
                'email_verified_at' => $user->email_verified_at ?? now(), 
                'otp_expires_at'    => null,
            ])->save();

            return response()->json(['message' => 'Email verified successfully!']);
        }

        return response()->json(['error' => 'Invalid or expired OTP'], 422);
    }

    public function resendApi(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        self::sendOtp($user);

        return response()->json(['message' => 'A new OTP has been sent to your email. It will expire in 5 minutes.']);
    }

    /**
     * ========================
     * 🔐 COMMON FUNCTION
     * ========================
     */
    public static function sendOtp(User $user): void
    {
        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'otp_code'       => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ])->save();

        Mail::raw(
            "Your GAMERZ2.0 OTP is: {$otp}\n\nNote: This code will expire in 5 minutes.",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('GAMERZ2.0 Email Verification OTP');
            }
        );
    }
}
