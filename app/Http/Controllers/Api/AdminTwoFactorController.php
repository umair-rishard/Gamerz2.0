<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminTwoFactorController extends Controller
{
    // Return current recovery codes
    public function recoveryCodes(): JsonResponse
    {
        /** @var Admin|null $admin */
        $admin = Auth::user(); // sanctum + is_admin

        if (! $admin || ! $admin->two_factor_secret) {
            return response()->json(['message' => '2FA not enabled'], 400);
        }

        $codes = $admin->two_factor_recovery_codes
            ? json_decode(decrypt($admin->two_factor_recovery_codes), true)
            : [];

        return response()->json(['codes' => $codes]);
    }

    // Regenerate and return fresh recovery codes
    public function regenerateRecoveryCodes(): JsonResponse
    {
        /** @var Admin|null $admin */
        $admin = Auth::user();
        if (! $admin) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $codes = collect(range(1, 8))->map(
            fn () => Str::random(10) . '-' . Str::random(10)
        )->all();

        $admin->two_factor_recovery_codes = encrypt(json_encode($codes));
        $admin->save(); // <-- IDE now knows this is an Admin (Eloquent) model

        return response()->json(['codes' => $codes]);
    }

    // Disable 2FA entirely
    public function disable(): JsonResponse
    {
        /** @var Admin|null $admin */
        $admin = Auth::user();
        if (! $admin) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $admin->two_factor_secret         = null;
        $admin->two_factor_recovery_codes = null;
        $admin->two_factor_confirmed_at   = null;
        $admin->save(); 

        return response()->json(['message' => '2FA disabled']);
    }
}
