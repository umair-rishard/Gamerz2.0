<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    // POST /api/admin/login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid admin credentials'], 401);
        }

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // ✅ If admin has 2FA enabled → don’t give token yet
        if (!empty($admin->two_factor_secret)) {
            // logout immediately so token/session is not active
            Auth::guard('admin')->logout();

            return response()->json([
                'requires_2fa' => true,
                'admin_id'     => $admin->id,
                'message'      => 'Two-factor authentication required'
            ]);
        }

        // ✅ If no 2FA → issue Sanctum token directly
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Admin login successful',
            'token'   => $token,
        ]);
    }

    // POST /api/admin/verify-2fa
    public function verify2fa(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'code'     => 'required|string',
        ]);

        $admin = Admin::find($request->admin_id);

        if (!$admin || empty($admin->two_factor_secret)) {
            return response()->json(['message' => 'Invalid request'], 400);
        }

        $provider = app(TwoFactorAuthenticationProvider::class);

        $valid = false;
        try {
            $valid = $provider->verify(
                decrypt($admin->two_factor_secret),
                $request->code
            );
        } catch (\Throwable $e) {
            $valid = false;
        }

        if (!$valid) {
            return response()->json(['message' => 'Invalid 2FA code'], 401);
        }

        // ✅ Success → issue Sanctum token
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json([
            'message' => '2FA verified successfully',
            'token'   => $token,
        ]);
    }

    // POST /api/admin/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();
        return response()->json(['message' => 'Admin logged out']);
    }
}
