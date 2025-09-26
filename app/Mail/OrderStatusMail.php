<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;

    public function __construct(Order $order, $reason = null)
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject("Order #{$this->order->id} - Status Update")
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->markdown('emails.orders.status', [
                'order'  => $this->order,
                'reason' => $this->reason,
            ]);
    }
}
