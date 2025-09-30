{{-- resources/views/dashboard/orders/order.blade.php --}}
@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 md:px-8">
  <h1 class="text-3xl font-extrabold text-slate-900 mb-10">My Orders</h1>

  {{-- Orders List --}}
  <div id="ordersList" class="space-y-10">
    <div class="p-10 text-center text-slate-500 bg-white rounded-2xl shadow border border-slate-200">
      Loading orders…
    </div>
  </div>

  {{-- Back to Dashboard --}}
  <div class="mt-12 text-center">
    <a href="{{ route('dashboard') }}" 
       class="inline-block px-8 py-3 bg-slate-900 text-white rounded-lg shadow hover:bg-black text-base font-semibold transition">
      ← Back to Dashboard
    </a>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
  const box = document.getElementById('ordersList');

  try {
    let res = await axios.get('/api/orders');
    let orders = res.data?.data ?? res.data;

    if (!orders.length) {
      box.innerHTML = `
        <div class="p-10 text-center text-slate-400 bg-white rounded-2xl shadow border border-slate-200 text-lg">
          You have no orders yet.
        </div>`;
      return;
    }

    box.innerHTML = orders.map(o => renderOrder(o)).join('');
  } catch (err) {
    console.error(err);
    box.innerHTML = `
      <div class="p-10 text-center text-rose-500 bg-white rounded-2xl shadow border border-slate-200 text-lg">
        Failed to load orders.
      </div>`;
  }
});

function renderOrder(order){
  const dt = new Date(order.created_at).toLocaleDateString('en-LK', {
    day: 'numeric', month: 'short', year: 'numeric'
  });
  const total = parseFloat(order.total).toLocaleString('en-LK');
  const status = (order.status || 'placed').toLowerCase();

  // Timeline / badge colors
  const statusColors = {
    pending:    'bg-amber-100 text-amber-800',
    confirmed:  'bg-blue-100 text-blue-800',
    processing: 'bg-cyan-100 text-cyan-800',
    shipped:    'bg-indigo-100 text-indigo-800',
    delivered:  'bg-emerald-100 text-emerald-800',
    cancelled:  'bg-rose-100 text-rose-800',
  };
  const badgeClass = statusColors[status] || 'bg-slate-100 text-slate-800';

  // Order items
  const items = (order.items || []).map(it => `
    <div class="flex items-center gap-5 py-4 border-b border-slate-100 last:border-0">
      <img src="${esc(it.product?.image_url || '/images/placeholder.png')}" 
           alt="item" class="w-24 h-24 rounded-xl object-cover shadow">
      <div class="flex-1 min-w-0">
        <div class="font-semibold text-slate-900 text-lg truncate">${esc(it.product?.name || it.product_name || 'Item')}</div>
        <div class="text-sm text-slate-500">Qty: ${it.quantity ?? 1}</div>
      </div>
      <div class="text-slate-900 font-extrabold text-lg">LKR ${parseFloat(it.price ?? 0).toLocaleString('en-LK')}</div>
    </div>
  `).join('');

  // Action buttons logic
  let actions = '';
  if(status === 'delivered'){
    actions = `
      <a href="/dashboard/orders/${esc(order.id)}/review" 
         class="px-6 py-2 text-sm rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">
         Review
      </a>`;
  } else if(status === 'cancelled'){
    actions = ``; // ❌ no buttons
  } else {
    actions = `
      <a href="/dashboard/orders/${esc(order.id)}" 
         class="px-6 py-2 text-sm rounded-lg bg-slate-900 text-white font-semibold hover:bg-black transition">
         Track
      </a>`;
  }

  return `
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden hover:shadow-2xl transition">
      <!-- Header -->
      <div class="px-8 py-6 flex items-center justify-between bg-slate-50 border-b border-slate-200">
        <div>
          <div class="font-bold text-slate-900 text-xl">Order #${esc(order.id)}</div>
          <div class="text-sm text-slate-500">${dt}</div>
        </div>
        <div class="flex items-center gap-3">
          <span class="px-3 py-1.5 text-sm font-semibold rounded-full ${badgeClass}">
            ${esc(order.status || 'Placed')}
          </span>
          <div class="text-slate-900 font-extrabold text-xl">LKR ${total}</div>
        </div>
      </div>
      
      <!-- Items -->
      <div class="p-6 divide-y divide-slate-100">
        ${items || '<div class="text-slate-400 text-sm">No items found.</div>'}
      </div>

      <!-- Footer actions -->
      ${actions ? `
        <div class="px-6 py-4 flex justify-end gap-3 border-t border-slate-200 bg-slate-50">
          ${actions}
        </div>` : ``}
    </div>
  `;
}

// Escape helper
function esc(s){
  return String(s ?? '').replace(/[&<>"']/g, m => (
    {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]
  ));
}
</script>
@endpush
