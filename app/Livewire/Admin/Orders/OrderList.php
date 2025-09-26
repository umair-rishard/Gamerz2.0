<?php

namespace App\Livewire\Admin\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusMail;

class OrderList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;
    public string $statusFilter = '';  // '', pending, confirmed, shipped, delivered, cancelled  (no 'completed' if DB doesn't allow)

    // Cancel modal
    public bool $showCancelModal = false;
    public ?int $selectedOrderId = null;
    public string $cancelReason = '';

    protected $queryString = [
        'search'       => ['except' => ''],
        'page'         => ['except' => 1],
        'perPage'      => ['except' => 10],
        'statusFilter' => ['except' => ''],
    ];

    /* ---------- Helpers ---------- */
    private function notify(string $message, string $type = 'success'): void
    {
        $this->dispatch('notify', ['type' => $type, 'message' => $message]);
    }

    private function swal(string $title, string $icon = 'success', ?string $text = null): void
    {
        $this->dispatch('swal', detail: ['icon' => $icon, 'title' => $title, 'text' => $text]);
    }

    private function sendStatusMail(Order $order, ?string $reason = null): void
    {
        if (!$order->relationLoaded('user')) $order->load('user');
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusMail($order, $reason));
        }
    }

    /* ---------- Pagination resets ---------- */
    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingPerPage(): void      { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    /* ---------- Actions ---------- */
    public function confirmOrder(int $orderId): void
    {
        try {
            $order = Order::with('user')->findOrFail($orderId);
            $order->update(['status' => 'confirmed']);
            $this->sendStatusMail($order);

            $this->resetPage();
            $this->notify("Order #{$order->id} confirmed.");
            $this->swal('Order Confirmed ✅', 'success', "Order #{$order->id} has been confirmed.");
        } catch (\Throwable $e) {
            Log::error('ConfirmOrder failed', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            $this->notify('Failed to confirm order.', 'error');
            $this->swal('Failed to Confirm ❌', 'error', 'Please try again.');
        }
    }

    public function shipOrder(int $orderId): void
    {
        try {
            $order = Order::with('user')->findOrFail($orderId);
            $order->update(['status' => 'shipped']);
            $this->sendStatusMail($order);

            $this->resetPage();
            $this->notify("Order #{$order->id} marked as shipped.");
            $this->swal('Order Shipped 📦', 'success', "Order #{$order->id} is on the way.");
        } catch (\Throwable $e) {
            Log::error('ShipOrder failed', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            $this->notify('Failed to mark as shipped.', 'error');
            $this->swal('Failed to Ship ❌', 'error', 'Please try again.');
        }
    }

    /** ✅ Finalize as DELIVERED (since DB enum doesn't allow 'completed') */
    public function deliverOrder(int $orderId): void
    {
        try {
            $order = Order::with('user')->findOrFail($orderId);

            // Set final allowed status
            $order->update(['status' => 'delivered']);

            // Try mail (don’t fail the status if mail breaks)
            try {
                $this->sendStatusMail($order);
            } catch (\Throwable $mailError) {
                Log::warning('DeliverOrder mail failed', [
                    'order_id' => $orderId,
                    'error'    => $mailError->getMessage(),
                ]);
            }

            $this->resetPage();
            $this->notify("Order #{$order->id} marked as delivered.");
            $this->swal('Order Delivered ✅', 'success', "Order #{$order->id} has been delivered.");
        } catch (\Throwable $e) {
            Log::error('DeliverOrder failed', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            $this->notify('Failed to complete order.', 'error');
            $this->swal('Failed to Complete ❌', 'error', 'Please try again.');
        }
    }

    public function openCancelModal(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->cancelReason = '';
        $this->showCancelModal = true;
    }

    public function confirmCancel(): void
    {
        try {
            $order = Order::with('user')->findOrFail($this->selectedOrderId);
            $order->update(['status' => 'cancelled']);

            try {
                $this->sendStatusMail($order, $this->cancelReason);
            } catch (\Throwable $mailError) {
                Log::warning('CancelOrder mail failed', [
                    'order_id' => $this->selectedOrderId,
                    'error'    => $mailError->getMessage(),
                ]);
            }

            $this->showCancelModal = false;
            $this->resetPage();
            $this->notify("Order #{$order->id} cancelled.");
            $this->swal('Order Cancelled 🚫', 'error',
                $this->cancelReason ? "Reason: {$this->cancelReason}" : "Order #{$order->id} was cancelled."
            );
        } catch (\Throwable $e) {
            Log::error('CancelOrder failed', ['order_id' => $this->selectedOrderId, 'error' => $e->getMessage()]);
            $this->notify('Failed to cancel order.', 'error');
            $this->swal('Failed to Cancel ❌', 'error', 'Please try again.');
        }
    }

    /* ---------- Render ---------- */
    public function render()
    {
        $q = trim($this->search);
        $status = trim($this->statusFilter);

        $orders = Order::with('user')
            ->when($q !== '', function ($query) use ($q) {
                $query->whereHas('user', function ($u) use ($q) {
                    $u->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($status !== '', fn($q2) => $q2->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.orders.order-list', compact('orders'));
    }
}
