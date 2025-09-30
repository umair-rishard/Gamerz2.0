@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50 to-green-100 py-8 md:py-12">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- narrower container --}}

    {{-- ============ SUCCESS HEADER ============ --}}
    <div class="relative">
      <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
        <div class="w-80 h-80 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full blur-3xl animate-pulse"></div>
      </div>

      <div class="relative bg-white/90 rounded-3xl shadow-2xl border border-slate-200 p-6 md:p-10 text-center">
        <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-green-600 mb-5 shadow-lg">
          <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
          </svg>
        </div>

        <h1 class="text-4xl md:text-5xl font-black text-emerald-600 mb-3">Order Confirmed!</h1>

        <div class="space-y-2 mb-6">
          <h2 class="text-xl md:text-2xl font-bold text-slate-900">Thank You!</h2>
          <p class="text-lg text-slate-700">for choosing <span class="font-extrabold text-emerald-700">GAMERZ</span></p>
          <p class="text-base text-slate-600">Your order has been placed successfully.</p>
          <p class="text-slate-600">You'll receive a confirmation email soon.</p>
          <p class="text-base font-semibold text-emerald-700 mt-2">We hope you enjoy your purchase!</p>
          <p class="text-slate-600">Come back soon for more epic gaming gear and unbeatable offers.</p>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
          {{-- smaller & darker button --}}
          <a href="/orders/{{ $id }}/receipt" target="_blank"
          class="group px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-black transition-all duration-200 flex items-center justify-center gap-2 shadow-md">
            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-semibold">Download Receipt</span>
        </a>

          <a href="/account/orders" class="group px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold transition-all duration-200 shadow-md flex items-center justify-center gap-2">
            <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Track Order
          </a>
        </div>

        <p class="text-base font-bold text-slate-800 mt-6">
          Thank you for being a part of the <span class="text-emerald-700">GAMERZ</span> family! 🎮
        </p>
      </div>
    </div>

    {{-- ============ ORDER TIMELINE (icons crisp & bordered) ============ --}}
    <div class="mt-10 bg-white rounded-3xl shadow-xl border border-slate-200 p-6">
      <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-6">Order Timeline</h3>
      <div class="relative">
        <div class="absolute top-7 left-0 right-0 h-0.5 bg-slate-200">
          <div class="h-full w-1/4 bg-gradient-to-r from-emerald-500 to-green-600"></div>
        </div>

        <div class="relative grid grid-cols-2 md:grid-cols-4 gap-4">
          {{-- Confirmed --}}
          <div class="flex flex-col items-center">
            <div class="relative z-10 w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow ring-4 ring-emerald-100 mb-2">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
            <p class="font-semibold text-slate-900">Order Confirmed</p>
            <p class="text-sm text-slate-500">Just now</p>
          </div>

          {{-- Processing (no blur, crisp icon with border) --}}
          <div class="flex flex-col items-center">
            <div class="relative z-10 w-14 h-14 rounded-full bg-white flex items-center justify-center mb-2 border border-slate-200 shadow-sm">
              <svg class="w-7 h-7 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
            <p class="font-semibold text-slate-600">Processing</p>
            <p class="text-sm text-slate-500">1–2 days</p>
          </div>

          {{-- Shipped --}}
          <div class="flex flex-col items-center">
            <div class="relative z-10 w-14 h-14 rounded-full bg-white flex items-center justify-center mb-2 border border-slate-200 shadow-sm">
              <svg class="w-7 h-7 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6 0a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
              </svg>
            </div>
            <p class="font-semibold text-slate-600">Shipped</p>
            <p class="text-sm text-slate-500">3–5 days</p>
          </div>

          {{-- Delivered --}}
          <div class="flex flex-col items-center">
            <div class="relative z-10 w-14 h-14 rounded-full bg-white flex items-center justify-center mb-2 border border-slate-200 shadow-sm">
              <svg class="w-7 h-7 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </div>
            <p class="font-semibold text-slate-600">Delivered</p>
            <p class="text-sm text-slate-500">5–7 days</p>
          </div>
        </div>
      </div>
    </div>

    {{-- ============ ORDER DETAILS (NARROW CARD) ============ --}}
    <div id="orderBox" class="mt-6 hidden">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Order Info (narrow, bordered, greens) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl border border-slate-200 p-6">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
              <h2 class="text-xl md:text-2xl font-bold text-slate-900">Order Details</h2>
              <p class="text-slate-600 mt-1">Order <span id="orderId" class="font-mono text-emerald-700"></span></p>
            </div>
            <div class="mt-3 sm:mt-0">
              <a id="receiptBtn" href="#" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-black transition-all duration-200 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Receipt
              </a>
            </div>
          </div>

          {{-- Items List (real image + borders) --}}
          <div class="space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Items Ordered</h3>
            <div id="itemsList" class="space-y-3"></div>
          </div>

          {{-- Price Breakdown --}}
          <div class="mt-6 pt-5 border-t border-slate-200">
            <div class="space-y-2.5">
              <div class="flex justify-between text-slate-700">
                <span>Subtotal</span>
                <span id="subtotal" class="font-semibold text-slate-900"></span>
              </div>
              <div class="flex justify-between text-slate-700">
                <span>Shipping</span>
                <span id="shipping" class="font-semibold text-slate-900"></span>
              </div>
              <div class="flex justify-between text-slate-700">
                <span>Discount</span>
                <span id="discount" class="font-semibold text-emerald-700"></span>
              </div>
              <div class="flex justify-between text-lg font-extrabold pt-3 border-t border-slate-200">
                <span class="text-slate-900">Total</span>
                <span id="grandTotal" class="text-2xl text-emerald-700"></span>
              </div>
            </div>
          </div>
        </div>

        {{-- Right column: Address (dark) + Payment (green) + Help --}}
        <div class="space-y-6">
          {{-- Delivery Address (dark box) --}}
          <div class="rounded-3xl shadow-xl p-6 text-white border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-800">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center ring-2 ring-emerald-500/40">
                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <h3 class="text-lg md:text-xl font-bold">Delivery Address</h3>
            </div>
            <div class="space-y-1 text-white/90">
              <p id="shippingName" class="font-semibold"></p>
              <p id="shippingPhone" class="text-sm"></p>
              <p id="shippingAddress" class="text-sm leading-6"></p>
            </div>
          </div>

          {{-- Payment Method (green card) --}}
          <div class="rounded-3xl shadow-xl border border-emerald-200 p-6 text-white bg-gradient-to-br from-emerald-600 to-green-700">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-11 h-11 rounded-full bg-white/15 flex items-center justify-center ring-2 ring-white/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
              </div>
              <h3 class="text-lg md:text-xl font-bold">Payment Method</h3>
            </div>
            <p id="paymentMethod" class="font-medium"></p>
            <p id="paymentMeta" class="text-sm opacity-90 mt-1"></p>
            <p class="text-xs opacity-80 mt-2">Payment processed securely</p>
          </div>

          {{-- Help --}}
          <div class="rounded-3xl p-5 border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white">
            <h4 class="font-semibold text-slate-900 mb-2">Need help?</h4>
            <a href="/contact" class="flex items-center gap-2 text-emerald-700 hover:text-emerald-800 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
              </svg>
              <span class="font-medium">Contact Support</span>
            </a>
          </div>
        </div>
      </div>

      {{-- Action Buttons (smaller & darker) --}}
      <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
        <a href="/products" class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800 transition-all duration-200 shadow-md">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          Continue Shopping
        </a>

        <a href="/dashboard" class="inline-flex items-center justify-center gap-2.5 px-6 py-3 rounded-xl bg-slate-900 hover:bg-black text-white font-bold transition-all duration-200 shadow-md">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Go to My Dashboard
        </a>
      </div>
    </div>

    {{-- LOADING --}}
    <div id="loadingBox" class="flex items-center justify-center py-20">
      <div class="text-center">
        <div class="relative">
          <div class="w-16 h-16 border-4 border-emerald-200 rounded-full animate-spin"></div>
          <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-t-emerald-600 rounded-full animate-spin"></div>
        </div>
        <p class="mt-4 text-slate-600 font-medium">Loading your order details...</p>
      </div>
    </div>

    {{-- ERROR --}}
    <div id="errorBox" class="hidden">
      <div class="bg-red-50 border border-red-200 rounded-3xl p-8 text-center">
        <div class="mx-auto w-16 h-16 flex items-center justify-center rounded-full bg-red-100 mb-4">
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-red-800 mb-2">Oops! Something went wrong</h3>
        <p class="text-red-600 mb-6">We couldn't load your order details. Please try again.</p>
        <button onclick="location.reload()" class="px-6 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors">
          Try Again
        </button>
      </div>
    </div>

  </div>
</div>

@push('styles')
<style>
  @keyframes bounce-slow { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
  @keyframes fade-in-up { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
  @keyframes fade-in { from{opacity:0} to{opacity:1} }
  .animate-bounce-slow { animation: bounce-slow 2s ease-in-out infinite; }
  .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
  .animate-fade-in { animation: fade-in 0.6s ease-out forwards; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
  const token = localStorage.getItem('token');
  const headers = token ? { Authorization: `Bearer ${token}` } : {};
  const orderId = "{{ $id }}";
  const apiUrl = `/api/orders/${orderId}`;

  const loading = document.getElementById('loadingBox');
  const orderBox = document.getElementById('orderBox');
  const errorBox = document.getElementById('errorBox');

  try {
    const res = await axios.get(apiUrl, { headers });
    const order = res.data || {};

    // ====== BASIC FIELDS ======
    document.getElementById('orderId').textContent = `#${order.id ?? ''}`;

    // ====== ADDRESS (use the same keys you saved at checkout) ======
    const fullName = order.shipping_name || [order.first_name, order.last_name].filter(Boolean).join(' ') || 'N/A';
    const phone    = order.shipping_phone || order.phone || 'N/A';

    // Compose address (line1, line2, city, postal, country)
    const line1 = order.shipping_address || order.address_line1 || '';
    const line2 = order.shipping_address2 || order.address_line2 || '';
    const city  = order.shipping_city || order.city || '';
    const zip   = order.shipping_postal || order.postal_code || '';
    const country = order.shipping_country || order.country || '';
    const addressParts = [line1, line2, city, zip, country].filter(Boolean);
    const addressText = addressParts.length ? addressParts.join(', ') : 'N/A';

    document.getElementById('shippingName').textContent = fullName;
    document.getElementById('shippingPhone').textContent = phone;
    document.getElementById('shippingAddress').textContent = addressText;

    // ====== PAYMENT (render real data) ======
    // Expected checkout keys (adjust to your payload): payment_method, payment_brand, last4, txn_id
    const method = (order.payment_method || '').toString().toUpperCase() || 'N/A';
    const paymentIcons = { 'CARD':'💳','PAYPAL':'🅿️','COD':'💵','BANK':'🏦','STRIPE':'💳','VISA':'💳','MASTERCARD':'💳' };
    const icon = paymentIcons[method] || '💰';
    let brand = order.payment_brand ? order.payment_brand.toUpperCase() : '';
    let last4 = order.last4 ? `•••• ${order.last4}` : '';
    const metaBits = [brand, last4, order.txn_id ? `TXN: ${order.txn_id}` : ''].filter(Boolean);

    document.getElementById('paymentMethod').textContent = `${icon} ${method}`;
    document.getElementById('paymentMeta').textContent = metaBits.join('  ·  ');

    // ====== ITEMS (real image + borders, crisp icons) ======
    const itemsList = document.getElementById('itemsList');
    itemsList.innerHTML = '';

    (order.items || []).forEach((item, i) => {
      const name = item.product?.name || item.name || 'Product';
      // Common backend conventions: image, image_url, thumbnail, photo
      const img = item.product?.image_url || item.product?.image || item.image_url || item.thumbnail || '/images/placeholder-product.png';
      const qty = Number(item.quantity || 1);
      const price = Number(item.price || 0);
      const lineTotal = price * qty;

      const card = document.createElement('div');
      card.className = 'flex items-center gap-4 p-4 rounded-2xl bg-white border border-slate-200 hover:shadow transition-all duration-200';
      card.style.animationDelay = `${i * 0.07}s`;
      card.classList.add('animate-fade-in-up');

      card.innerHTML = `
        <img src="${img}" alt="${name}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-slate-200 shadow-sm" onerror="this.src='/images/placeholder-product.png'"/>
        <div class="flex-1 min-w-0">
          <h4 class="font-semibold text-slate-900 truncate">${name}</h4>
          <p class="text-sm text-slate-500">Quantity: ${qty}</p>
        </div>
        <div class="text-right">
          <p class="font-bold text-lg text-slate-900">${lineTotal.toLocaleString('en-LK')} LKR</p>
          <p class="text-xs text-slate-500">${price.toLocaleString('en-LK')} × ${qty}</p>
        </div>
      `;

      itemsList.appendChild(card);
    });

    // ====== TOTALS ======
    const fmt = (v) => (Number(v||0)).toLocaleString('en-LK') + ' LKR';
    document.getElementById('subtotal').textContent   = fmt(order.subtotal);
    document.getElementById('shipping').textContent   = fmt(order.shipping);
    document.getElementById('discount').textContent   = `-${(Number(order.discount||0)).toLocaleString('en-LK')} LKR`;
    document.getElementById('grandTotal').textContent = fmt(order.total);

    // Receipt route
    const receiptBtn = document.getElementById('receiptBtn');
    if (receiptBtn) receiptBtn.href = `/orders/${orderId}/receipt`;

    // Show
    loading.classList.add('hidden');
    orderBox.classList.remove('hidden');

    // Optional confetti (kept subtle)
    createConfetti();
  } catch (err) {
    console.error('Error loading order:', err);
    loading.classList.add('hidden');
    errorBox.classList.remove('hidden');
  }
});

// Subtle confetti for win vibes
function createConfetti() {
  const colors = ['#059669','#065f46','#10b981','#34d399'];
  const n = 36;
  for (let i=0;i<n;i++) {
    const el = document.createElement('div');
    el.style.cssText = `
      position: fixed; width:8px; height:8px; background:${colors[Math.floor(Math.random()*colors.length)]};
      left:${Math.random()*100}%; top:-10px; opacity:${0.6+Math.random()*0.4};
      transform: rotate(${Math.random()*360}deg);
      animation: confetti-fall ${3+Math.random()*2}s linear;
      z-index: 1000;
    `;
    document.body.appendChild(el);
    setTimeout(()=>el.remove(), 5500);
  }
}
const style = document.createElement('style');
style.textContent = `
  @keyframes confetti-fall { to { top: 100vh; transform: rotate(${Math.random()*360}deg); } }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
