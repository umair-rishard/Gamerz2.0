<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>
</head>
<body style="font-family: DejaVu Sans, sans-serif; font-size:14px; color:#1f2937; background:#f8fafc; padding:20px;">

    <div style="max-width:750px; margin:auto; background:#ffffff; border-radius:20px; border:2px solid #059669; box-shadow:0px 4px 20px rgba(0,0,0,0.1); padding:30px;">

        <!-- Header -->
        <div style="text-align:center; border-bottom:2px solid #059669; padding-bottom:15px; margin-bottom:20px;">
            <h1 style="color:#059669; font-size:28px; margin:0;">GAMERZ - Order Receipt</h1>
            <p style="font-size:14px; margin:5px 0 0 0; color:#4b5563;">Thank you for shopping with us 🎮</p>
        </div>

        <!-- Order Info -->
        <div style="margin-bottom:20px;">
            <h2 style="font-size:18px; color:#059669; border-bottom:1px solid #d1d5db; padding-bottom:5px; margin-bottom:10px;">Order Information</h2>
            <p style="margin:4px 0;"><strong style="color:#111827;">Order ID:</strong> #{{ $order->id }}</p>
            <p style="margin:4px 0;"><strong style="color:#111827;">Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p style="margin:4px 0;"><strong style="color:#111827;">Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <!-- Customer Info -->
        <div style="margin-bottom:20px;">
            <h2 style="font-size:18px; color:#059669; border-bottom:1px solid #d1d5db; padding-bottom:5px; margin-bottom:10px;">Customer Details</h2>
            <p style="margin:4px 0;"><strong style="color:#111827;">Name:</strong> {{ $order->shipping_name }}</p>
            <p style="margin:4px 0;"><strong style="color:#111827;">Phone:</strong> {{ $order->shipping_phone }}</p>
            <p style="margin:4px 0;"><strong style="color:#111827;">Address:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }} - {{ $order->shipping_postal }}</p>
            <p style="margin:4px 0;"><strong style="color:#111827;">Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
        </div>

        <!-- Items -->
        <div style="margin-bottom:20px;">
            <h2 style="font-size:18px; color:#059669; border-bottom:1px solid #d1d5db; padding-bottom:5px; margin-bottom:10px;">Items Ordered</h2>
            <table style="width:100%; border-collapse:collapse; font-size:14px; margin-top:12px;">
                <thead>
                    <tr>
                        <th style="border:1px solid #d1d5db; background:#059669; color:#fff; padding:8px; text-align:left;">Item</th>
                        <th style="border:1px solid #d1d5db; background:#059669; color:#fff; padding:8px; text-align:left;">Qty</th>
                        <th style="border:1px solid #d1d5db; background:#059669; color:#fff; padding:8px; text-align:left;">Price</th>
                        <th style="border:1px solid #d1d5db; background:#059669; color:#fff; padding:8px; text-align:left;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td style="border:1px solid #d1d5db; background:#f9fafb; padding:8px;">{{ $item->product->name ?? 'Product' }}</td>
                        <td style="border:1px solid #d1d5db; background:#f9fafb; padding:8px;">{{ $item->quantity }}</td>
                        <td style="border:1px solid #d1d5db; background:#f9fafb; padding:8px;">{{ number_format($item->price, 2) }} LKR</td>
                        <td style="border:1px solid #d1d5db; background:#f9fafb; padding:8px;">{{ number_format($item->price * $item->quantity, 2) }} LKR</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align:right; margin-top:15px;">
                <h3 style="color:#059669; font-size:20px; margin:0;">Total: {{ number_format($order->total, 2) }} LKR</h3>
            </div>
        </div>

        <!-- Footer -->
        <div style="margin-top:30px; text-align:center; font-size:13px; color:#6b7280;">
            <p>We hope you enjoy your gear!<br>Come back soon for more epic gaming deals.</p>
            <p>© {{ date('Y') }} GAMERZ. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
