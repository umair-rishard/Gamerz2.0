<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Show admin profile
     */
    public function show(Request $request)
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::user();

        if (! $admin) {
            return response()->json(['message' => 'Not logged in as admin'], 403);
        }

        return response()->json($admin);
    }

    /**
     * Update admin profile (name/email)
     */
    public function update(Request $request)
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::user();

        if (! $admin) {
            return response()->json(['message' => 'Not logged in as admin'], 403);
        }

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:admins,email,{$admin->id}"],
        ]);

        $admin->update($data);

        return response()->json(['message' => 'Profile updated ✅']);
    }

    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::user();

        if (! $admin) {
            return response()->json(['message' => 'Not logged in as admin'], 403);
        }

        $data = $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($data['current_password'], $admin->password)) {
            return response()->json(['message' => 'Current password incorrect ❌'], 422);
        }

        $admin->update([
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(['message' => 'Password changed ✅']);
    }

    /**
     * Delete admin account
     */
    public function destroy(Request $request)
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::user();

        if (! $admin) {
            return response()->json(['message' => 'Not logged in as admin'], 403);
        }

        $request->validate([
            'confirm_password_for_delete' => ['required'],
        ]);

        if (! Hash::check($request->confirm_password_for_delete, $admin->password)) {
            return response()->json(['message' => 'Incorrect password ❌'], 422);
        }

        $adminId = $admin->id;
        $admin->delete();

        return response()->json(['message' => "Admin account #{$adminId} deleted ✅"]);
    }
}
