<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PasswordSetupController extends Controller
{
    // Show the set password form
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('auth.set-password', [
            'user' => $user
        ]);
    }

    // Handle password submission
    public function store(Request $request, $user_id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($user_id);

        // Save new password
        $user->password = Hash::make($request->password);
        $user->save();

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Password set successfully! Welcome to Gamerz2.0.');
    }
}
