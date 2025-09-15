<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use App\Models\Admin;

class AdminLogin extends Component
{
    public string $email = '';
    public string $password = '';
    public string $code = '';
    public bool $requiresTwoFactor = false;

    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required|string',
    ];

    /**
     * Handle the admin login attempt
     */
    public function login()
    {
        $this->validate();

        // Try to login with admin guard
        if (!Auth::guard('admin')->attempt(
            ['email' => $this->email, 'password' => $this->password],
            true // remember me
        )) {
            $this->addError('email', 'Invalid admin credentials.');
            return null;
        }

        $admin = Auth::guard('admin')->user();

        // ✅ Check if admin has 2FA enabled
        if (!empty($admin->two_factor_secret)) {
            // Logout and force code input
            Auth::guard('admin')->logout();
            Session::put('admin.2fa.id', $admin->id);
            $this->requiresTwoFactor = true;
            return null;
        }

        // If no 2FA → straight to dashboard
        request()->session()->regenerate();
        return $this->redirect(route('admin.dashboard'));
    }

    /**
     * Verify the 2FA code if required
     */
    public function verifyCode()
    {
        $adminId = Session::get('admin.2fa.id');
        $admin   = Admin::find($adminId);

        if (!$admin) {
            $this->addError('code', 'Session expired. Please login again.');
            $this->requiresTwoFactor = false;
            return $this->redirect(route('admin.login'));
        }

        $provider = app(TwoFactorAuthenticationProvider::class);

        $valid = false;
        try {
            $valid = $provider->verify(
                decrypt($admin->two_factor_secret),
                $this->code
            );
        } catch (\Throwable $e) {
            $valid = false;
        }

        if (!$valid) {
            $this->addError('code', 'Invalid authenticator code.');
            return null;
        }

        // ✅ Success → log in admin
        Session::forget('admin.2fa.id');
        Auth::guard('admin')->login($admin);
        request()->session()->regenerate();

        return $this->redirect(route('admin.dashboard'));
    }

    public function render()
    {
        return view('livewire.admin-login');
    }
}
