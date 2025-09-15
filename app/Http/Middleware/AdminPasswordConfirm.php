<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPasswordConfirm
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user('admin')) {
            return redirect()->route('admin.login');
        }

        // Force the password confirmation to use the admin guard
        if ($request->user('admin')->hasConfirmedPassword()) {
            return $next($request);
        }

        return redirect()->route($redirectToRoute ?: 'password.confirm');
    }
}
