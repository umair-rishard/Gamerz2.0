<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirectRoute('admin.login', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
