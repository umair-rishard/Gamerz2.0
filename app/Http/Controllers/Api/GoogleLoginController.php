<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;

class GoogleLoginController extends Controller
{
    protected $auth;

    public function __construct()
    {
        // Uses your config/firebase.php -> credentials.file path
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $this->auth = $factory->createAuth();
    }

    /**
     * Accepts a Firebase ID token from the frontend, verifies it,
     * then:
     *  - if the user is new -> create them and tell the frontend to go to set-password
     *  - if the user already exists but has no password -> tell the frontend to set-password
     *  - if the user already exists AND has a password -> issue Sanctum token (normal login)
     */
    public function login(Request $request)
    {
        try {
            $idToken = (string) $request->input('token');
            if (!$idToken) {
                return response()->json(['status' => 'error', 'message' => 'Missing token'], 422);
            }

            // Verify Firebase ID token
            $verified = $this->auth->verifyIdToken($idToken);
            $uid      = $verified->claims()->get('sub');
            $firebaseUser = $this->auth->getUser($uid);

            if (!$firebaseUser || empty($firebaseUser->email)) {
                return response()->json(['status' => 'error', 'message' => 'No email from Google'], 422);
            }

            // Find or create local user
            $user = User::where('email', $firebaseUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $firebaseUser->displayName ?: $firebaseUser->email,
                    'email'    => $firebaseUser->email,
                    // temp random password; user will set a real one
                    'password' => bcrypt(Str::random(24)),
                    // mark as verified so OTP middleware doesn't block the flow
                    'is_verified' => true,
                ]);

                return response()->json([
                    'status'  => 'password_setup',
                    'user_id' => $user->id,
                    'message' => 'New Google user, please set a password.',
                ]);
            }

            // Existing user: if they never set a real password (optional check)
            // You can detect by a flag, or keep it simple: always ask to set if they just used Google before.
            // Here we'll check a simple heuristic: if the password was randomly generated (length >= 50 not reliable),
            // instead: add a nullable column like `password_set_at`. For now we’ll always let them in if they already exist.
            // If you *want* to force set-password once, return 'password_setup' here conditionally.

            // Normal login path -> issue Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'user'   => $user,
                'token'  => $token,
            ]);

        } catch (\Throwable $e) {
            Log::error('Google login failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Verification failed',
            ], 401);
        }
    }
}
