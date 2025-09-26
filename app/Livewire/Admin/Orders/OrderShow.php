<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use App\Models\Order;

class OrderShow extends Component
{
    public $order;

    public function mount($orderId)
    {
        // Load the current order with its items + product + user
        $this->order = Order::with(['items.product', 'user'])
            ->findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.admin.orders.order-show');
    }
}
