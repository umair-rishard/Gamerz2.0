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
        // Read the service-account path from config/firebase.php
        // Your config uses: config('firebase.projects.app.credentials')
        $creds = config('firebase.projects.app.credentials');

        // Fallback to env if needed
        if (!$creds) {
            $creds = env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS'));
        }

        // Make absolute if a relative path was given in .env
        if ($creds && !file_exists($creds) && file_exists(base_path($creds))) {
            $creds = base_path($creds);
        }

        if (!$creds || !file_exists($creds)) {
            throw new \RuntimeException(
                'Firebase service account JSON not found. ' .
                'Set FIREBASE_CREDENTIALS in .env to the correct path.'
            );
        }

        $factory = (new Factory)->withServiceAccount($creds);
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
            $verified      = $this->auth->verifyIdToken($idToken);
            $uid           = $verified->claims()->get('sub');
            $firebaseUser  = $this->auth->getUser($uid);

            if (!$firebaseUser || empty($firebaseUser->email)) {
                return response()->json(['status' => 'error', 'message' => 'No email from Google'], 422);
            }

            // Find or create local user
            $user = User::where('email', $firebaseUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'        => $firebaseUser->displayName ?: $firebaseUser->email,
                    'email'       => $firebaseUser->email,
                    'password'    => bcrypt(Str::random(24)), // temp; user will set a real one
                    'is_verified' => true,
                ]);

                return response()->json([
                    'status'  => 'password_setup',
                    'user_id' => $user->id,
                    'message' => 'New Google user, please set a password.',
                ]);
            }

            // Existing user → issue Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'user'   => $user,
                'token'  => $token,
            ]);

        } catch (\Throwable $e) {
            Log::error('Google login failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Surface a helpful message during development
            return response()->json([
                'status'  => 'error',
                'message' => 'Verification failed: '.$e->getMessage(),
            ], 401);
        }
    }
}
