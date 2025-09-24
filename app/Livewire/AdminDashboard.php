<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboard extends Component
{
    // Real KPIs
    public int $totalProducts = 0;
    public int $totalOrders   = 0;   
    public int $totalUsers    = 0;   
    public float $totalRevenue = 0.0; 
    public function mount(): void
    {
        $this->totalProducts = Product::count();
        $this->totalOrders   = Order::count();
        $this->totalUsers    = User::count();
        $this->totalRevenue  = (float) Order::sum('total');
    }

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
