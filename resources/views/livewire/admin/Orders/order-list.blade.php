<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
        @include('partials.admin.header')
        @include('partials.admin.sidebar')

        <main class="ml-0 md:ml-72 p-4 md:p-8">
            <div class="max-w-7xl mx-auto space-y-8">

                {{-- Page title --}}
                <div class="flex items-center justify-between">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-slate-800">Orders</h1>
                </div>

                <section class="rounded-3xl p-6 md:p-8 border border-slate-200 bg-white/80 backdrop-blur-xl shadow-xl">
                    {{-- Top row: Status chips + Per Page --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        {{-- Status filter chips --}}
                        <div class="flex flex-wrap gap-2">
                            @php
                                $chips = [
                                    ''           => ['All',        'bg-slate-900 text-white border-slate-900','bg-white text-slate-700 border-slate-300'],
                                    'pending'    => ['Pending',    'bg-amber-600 text-white border-amber-600',   'bg-amber-50 text-amber-700 border-amber-200'],
                                    'confirmed'  => ['Confirmed',  'bg-emerald-600 text-white border-emerald-600','bg-emerald-50 text-emerald-700 border-emerald-200'],
                                    'shipped'    => ['Shipped',    'bg-blue-600 text-white border-blue-600',     'bg-blue-50 text-blue-700 border-blue-200'],
                                    'delivered'  => ['Delivered',  'bg-teal-600 text-white border-teal-600',     'bg-teal-50 text-teal-700 border-teal-200'],
                                    'completed'  => ['Completed',  'bg-indigo-600 text-white border-indigo-600', 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                                    'cancelled'  => ['Cancelled',  'bg-rose-600 text-white border-rose-600',     'bg-rose-50 text-rose-700 border-rose-200'],
                                ];
                            @endphp

                            @foreach($chips as $value => [$label, $activeCls, $idleCls])
                                <button
                                    wire:click="$set('statusFilter','{{ $value }}')"
                                    class="px-4 py-2 rounded-full text-[13px] md:text-sm font-semibold border transition-all
                                    {{ $statusFilter === $value ? $activeCls.' shadow-lg' : $idleCls.' hover:bg-white' }}">
                                    {{ $label }} {!! $statusFilter === $value ? '<span class="ml-1 text-xs">✓</span>' : '' !!}
                                </button>
                            @endforeach
                        </div>

                        {{-- Per Page --}}
                        <div class="flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-slate-900 text-slate-100 border border-slate-800 shadow-lg">
                            <span class="text-sm font-semibold tracking-wide">Show</span>
                            <select wire:model="perPage"
                                    class="rounded-xl border border-slate-700 bg-slate-800 text-slate-100 px-3 py-2 text-sm font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40">
                                <option class="text-black" value="10">10</option>
                                <option class="text-black" value="25">25</option>
                                <option class="text-black" value="50">50</option>
                            </select>
                            <span class="text-sm font-semibold tracking-wide">per page</span>
                        </div>
                    </div>

                    {{-- Table (Desktop) --}}
                    <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-xl hidden md:block">
                        <table class="min-w-full text-[15px]">
                            <thead class="bg-gradient-to-r from-slate-900 to-slate-800 text-white">
                                <tr class="uppercase tracking-wide text-xs">
                                    <th class="px-5 py-4 text-left">User</th>
                                    <th class="px-5 py-4 text-left">Status</th>
                                    <th class="px-5 py-4 text-left">Total</th>
                                    <th class="px-5 py-4 text-left">Date</th>
                                    <th class="px-5 py-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse ($orders as $order)
                                    <tr class="odd:bg-slate-50 even:bg-white hover:bg-slate-100/70 transition">
                                        <td class="px-5 py-4">
                                            <div class="font-semibold text-slate-800 text-[15px]">
                                                {{ $order->user->name ?? '—' }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                                        </td>

                                        <td class="px-5 py-4">
                                            <span @class([
                                                'px-3 py-1 text-xs font-semibold rounded-full',
                                                'bg-yellow-100 text-yellow-700'   => $order->status === 'pending',
                                                'bg-green-100 text-green-700'     => $order->status === 'confirmed',
                                                'bg-blue-100 text-blue-700'       => $order->status === 'shipped',
                                                'bg-emerald-100 text-emerald-700' => in_array($order->status, ['delivered','completed']),
                                                'bg-red-100 text-red-700'         => $order->status === 'cancelled',
                                            ])>
                                                {{ $order->status === 'completed' ? 'Completed' : ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 font-semibold text-slate-800 tabular-nums">
                                            LKR {{ number_format($order->total ?? 0, 2) }}
                                        </td>

                                        <td class="px-5 py-4 text-slate-700">
                                            {{ $order->created_at->format('Y-m-d H:i') }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                   class="px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                                                   View
                                                </a>

                                                @if($order->status === 'pending')
                                                    <button wire:click="confirmOrder({{ $order->id }})"
                                                            wire:loading.attr="disabled"
                                                            class="px-3 py-2 text-sm rounded-lg text-white bg-emerald-600 hover:bg-emerald-700">
                                                        Confirm
                                                    </button>
                                                    <button wire:click="openCancelModal({{ $order->id }})"
                                                            class="px-3 py-2 text-sm rounded-lg text-white bg-rose-600 hover:bg-rose-700">
                                                        Cancel
                                                    </button>
                                                @elseif($order->status === 'confirmed')
                                                    <button wire:click="shipOrder({{ $order->id }})"
                                                            wire:loading.attr="disabled"
                                                            class="px-3 py-2 text-sm rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                                                        Mark as Shipped
                                                    </button>
                                                @elseif($order->status === 'shipped')
                                                    <button wire:click="deliverOrder({{ $order->id }})"
                                                            wire:loading.attr="disabled"
                                                            class="px-3 py-2 text-sm rounded-lg text-white bg-teal-600 hover:bg-teal-700">
                                                        Delivered
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-6 text-center text-gray-500">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                    <div class="md:hidden grid gap-4 p-1">
                        @forelse ($orders as $order)
                            <div class="rounded-2xl border border-slate-200 p-4 shadow-sm bg-white">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $order->user->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</p>
                                    </div>
                                    <span @class([
                                        'px-3 py-1 text-xs font-semibold rounded-full',
                                        'bg-yellow-100 text-yellow-700'   => $order->status === 'pending',
                                        'bg-green-100 text-green-700'     => $order->status === 'confirmed',
                                        'bg-blue-100 text-blue-700'       => $order->status === 'shipped',
                                        'bg-emerald-100 text-emerald-700' => in_array($order->status, ['delivered','completed']),
                                        'bg-red-100 text-red-700'         => $order->status === 'cancelled',
                                    ])>
                                        {{ $order->status === 'completed' ? 'Completed' : ucfirst($order->status) }}
                                    </span>
                                </div>

                                <p class="text-slate-800 font-semibold">LKR {{ number_format($order->total ?? 0, 2) }}</p>
                                <p class="text-slate-600 text-sm mb-3">{{ $order->created_at->format('Y-m-d H:i') }}</p>

                                <div class="flex gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="flex-1 text-center px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                                       View
                                    </a>

                                    @if($order->status === 'pending')
                                        <button wire:click="confirmOrder({{ $order->id }})"
                                                wire:loading.attr="disabled"
                                                class="flex-1 text-center px-3 py-2 text-sm rounded-lg text-white bg-emerald-600 hover:bg-emerald-700">
                                            Confirm
                                        </button>
                                        <button wire:click="openCancelModal({{ $order->id }})"
                                                class="flex-1 text-center px-3 py-2 text-sm rounded-lg text-white bg-rose-600 hover:bg-rose-700">
                                            Cancel
                                        </button>
                                    @elseif($order->status === 'confirmed')
                                        <button wire:click="shipOrder({{ $order->id }})"
                                                wire:loading.attr="disabled"
                                                class="flex-1 text-center px-3 py-2 text-sm rounded-lg text-white bg-blue-600 hover:bg-blue-700">
                                            Shipped
                                        </button>
                                    @elseif($order->status === 'shipped')
                                        <button wire:click="deliverOrder({{ $order->id }})"
                                                wire:loading.attr="disabled"
                                                class="flex-1 text-center px-3 py-2 text-sm rounded-lg text-white bg-teal-600 hover:bg-teal-700">
                                            Delivered
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No orders found.</p>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- Cancel Modal --}}
    <div x-data="{ open: @entangle('showCancelModal') }">
        <div x-show="open" x-transition.opacity class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Cancel Order</h2>
                <p class="text-slate-600 mb-3">Please provide a reason for cancelling this order:</p>
                <textarea wire:model.defer="cancelReason" class="w-full border rounded-lg p-3 text-sm focus:ring focus:ring-rose-200" rows="3"></textarea>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300">Close</button>
                    <button wire:click="confirmCancel" wire:loading.attr="disabled" class="px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                        Confirm Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast (kept) --}}
    <div 
        x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="
            type = $event.detail.type;
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
        "
        class="fixed top-6 right-6 z-50"
    >
        <div x-show="show" x-transition
             :class="{ 'bg-emerald-600': type === 'success', 'bg-rose-600': type === 'error' }"
             class="text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <span x-text="message"></span>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('swal', (e) => {
    // Handle Livewire v2/v3 event shapes
    const d1 = e?.detail ?? {};
    const d2 = d1.detail ?? {};
    const d3 = Array.isArray(d1.params) ? (d1.params[0] || {}) : {};
    const payload = Object.assign({}, d1, d2, d3);

    const icon  = payload.icon  || 'success';
    const title = payload.title || (
      icon === 'error'   ? 'Something went wrong' :
      icon === 'warning' ? 'Heads up' :
      icon === 'info'    ? 'FYI' :
      'Success'
    );
    const desc  = (payload.text ?? payload.html ?? '').toString().trim() ||
                  (icon === 'success' ? 'Action completed successfully.' : '');

    Swal.fire({
      icon,
      title,
      html: desc,
      showConfirmButton: false,
      timer: 1800,
      width: 460,
      background: '#ffffff',
      color: '#0f172a',
      iconColor: icon === 'success' ? '#10b981' :
                 icon === 'warning' ? '#f59e0b' :
                 icon === 'error'   ? '#ef4444' : '#3b82f6',
      backdrop: 'rgba(15,23,42,0.25)',
      customClass: {
        popup: 'rounded-2xl shadow-2xl',
        title: 'text-lg md:text-xl font-semibold -mt-1',
        htmlContainer: 'text-slate-600 text-sm md:text-base mt-1'
      }
    });
  });
});
</script>
