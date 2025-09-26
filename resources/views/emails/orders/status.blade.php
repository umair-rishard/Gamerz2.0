@component('mail::message')

{{-- Small embedded logo at top --}}
<p style="text-align:center; margin-bottom:16px;">
    <img src="{{ $message->embed(storage_path('app/public/logo1.png')) }}"
         alt="GAMERZ2.0 Logo"
         style="max-width:140px; height:auto;">
</p>

# Hello {{ $order->user->name }},

We have an update regarding your order **#{{ $order->id }}**.

@php
    $status = $order->status;
@endphp

{{-- Status box --}}
@if($status === 'confirmed')
<div style="background:#dcfce7; padding:14px; border-radius:8px; margin:14px 0; color:#166534;">
    ✅ <strong>Good news!</strong> Your order has been <strong>confirmed</strong> and we are preparing it for shipment.
</div>

@elseif($status === 'shipped')
<div style="background:#dbeafe; padding:14px; border-radius:8px; margin:14px 0; color:#1e3a8a;">
    📦 <strong>Update!</strong> Your order has been <strong>shipped</strong> and it’s on the way to you.
</div>

@elseif($status === 'delivered' || $status === 'completed')
<div style="background:#d1fae5; padding:14px; border-radius:8px; margin:14px 0; color:#065f46;">
    🎉 <strong>Great!</strong> Your order has been delivered and completed.
    We hope you enjoy your items.
</div>

@elseif($status === 'cancelled')
<div style="background:#fee2e2; padding:14px; border-radius:8px; margin:14px 0; color:#991b1b;">
    ❌ <strong>Unfortunately, your order was cancelled.</strong><br><br>
    @if(!empty($reason))
        <strong>Reason provided:</strong><br>
        {{ $reason }}
    @else
        <em>No reason was specified by the admin.</em>
    @endif
</div>

@else
<div style="background:#f3f4f6; padding:14px; border-radius:8px; margin:14px 0; color:#374151;">
    ℹ️ Your order status has been updated to <strong>{{ ucfirst($status) }}</strong>.
</div>
@endif

---

## 📋 Order Summary
- **Total:** LKR {{ number_format($order->total, 2) }}  
- **Placed At:** {{ $order->created_at->format('Y-m-d H:i') }}

@component('mail::button', ['url' => url('/orders')])
View My Orders
@endcomponent

Thanks for shopping with **GAMERZ2.0**!
@endcomponent
