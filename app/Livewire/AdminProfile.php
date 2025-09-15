<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AdminProfile extends Component
{
    public $admin;

    public function mount()
    {
        $this->admin = Auth::guard('admin')->user();
    }

    public function render()
    {
        return view('livewire.admin-profile');
    }
}
