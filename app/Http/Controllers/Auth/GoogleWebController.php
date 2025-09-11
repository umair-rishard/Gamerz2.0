<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleWebController extends Controller
{
    /**
     * This is called via the signed URL returned from /api/google-login.
     * It logs the user in (web session) and redirects appropriately.
     */
    public function finish(Request $request)
    {
        // Security: only allow signed URL
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $userId = (int) $request->query('user');
        $isNew  = $request->boolean('new'); // 1 means first-time Google login

        $user = User::findOrFail($userId);

        // Make sure OTP middleware won't block Google users
        if (!$user->is_verified) {
            $user->is_verified = true;
            $user->save();
        }

        // Create the normal web session
        Auth::login($user);

        // New Google user → set password first
        if ($isNew) {
            return redirect()
                ->route('password.setup', $user->id)
                ->with('status', 'Welcome! Please set your password.');
        }

        // Existing user → straight to dashboard
        return redirect()->route('dashboard');
    }
}
