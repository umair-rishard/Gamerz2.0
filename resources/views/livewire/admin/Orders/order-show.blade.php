{{-- Admin > Orders > Show --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-5xl mx-auto space-y-10">

            {{-- Back button --}}
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center px-5 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition shadow-md">
                ← Back to Orders
            </a>

            {{-- Current Order Summary --}}
            <section class="rounded-3xl p-6 border border-slate-200 bg-white shadow-xl">
                <h1 class="text-3xl font-bold text-slate-800 mb-6">
                    Order #{{ $order->id }}
                </h1>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <p class="text-slate-700 mb-2">
                            User: <span class="font-semibold">{{ $order->user->name ?? '—' }}</span>
                            <br>
                            <span class="text-sm text-gray-500">{{ $order->user->email ?? '' }}</span>
                        </p>
                        <p class="text-slate-700 mb-2">
                            Status:
                            <span @class([
                                'px-2 py-1 text-xs font-semibold rounded-full',
                                'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                                'bg-green-100 text-green-700'   => $order->status === 'confirmed',
                                'bg-red-100 text-red-700'       => $order->status === 'cancelled',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p class="text-slate-700">Placed: <span class="font-semibold">{{ $order->created_at->format('Y-m-d H:i') }}</span></p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-slate-900">LKR {{ number_format($order->total, 2) }}</p>
                        <p class="text-slate-500 text-sm">Total Amount</p>
                    </div>
                </div>
            </section>

            {{-- Current Order Items --}}
            <section class="rounded-3xl p-6 border border-slate-200 bg-gradient-to-r from-indigo-50 to-white shadow-xl">
                <h2 class="text-xl font-semibold text-slate-800 mb-4">Items in this Order</h2>
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-900 text-slate-100">
                            <tr>
                                <th class="px-4 py-3 text-left">Product</th>
                                <th class="px-4 py-3 text-center">Quantity</th>
                                <th class="px-4 py-3 text-center">Price</th>
                                <th class="px-4 py-3 text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($order->items as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3">{{ $item->product->name }}</td>
                                    <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-center">LKR {{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-3 text-center">LKR {{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</div>
