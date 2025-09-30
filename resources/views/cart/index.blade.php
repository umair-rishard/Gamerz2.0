@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">My Cart</h1>
            <p class="text-slate-500 mt-1 text-sm">Review items in your cart. Update quantities or proceed to checkout.</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-black text-white font-semibold shadow hover:brightness-110 active:scale-[.98]">
            Continue shopping
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13 5l7 7-7 7M5 5h8v2H5v12h8v2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Items -->
        <div class="lg:col-span-2">
            <div id="cart-list" class="space-y-4"></div>

            <!-- Empty State -->
            <div id="cart-empty" class="hidden rounded-2xl border border-slate-200 bg-white p-14 text-center">
                <div class="mx-auto mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-900/90 text-white">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18a2 2 0 110 4 2 2 0 010-4zm10 0a2 2 0 110 4 2 2 0 010-4zM3 3h2l.4 2H21a1 1 0 01.96 1.27l-2.4 8A2 2 0 0117.65 16H9.1a2 2 0 01-1.94-1.52L5.16 6H3V3z"/></svg>
                </div>
                <h2 class="text-xl font-semibold text-slate-800">Your cart is empty</h2>
                <p class="text-slate-500 mt-2">Add items from the shop to see them here.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Shop Products
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M13 5l7 7-7 7M5 5h8v2H5v12h8v2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2z"/></svg>
                </a>
            </div>
        </div>

        <!-- Summary -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sticky top-28">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-slate-900">Order Summary</h3>
                    <span id="itemCountPill" class="px-2.5 py-1 rounded-full bg-slate-100 text-xs font-semibold text-slate-700">0 items</span>
                </div>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-600">Subtotal</dt>
                        <dd id="subtotal" class="font-semibold text-slate-900">Rs. 0.00</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-600">Shipping</dt>
                        <dd class="text-slate-600">Calculated at checkout</dd>
                    </div>
                    <div class="border-t border-slate-200 pt-3 flex justify-between text-base">
                        <dt class="font-semibold text-slate-900">Total</dt>
                        <dd id="grandtotal" class="font-extrabold text-slate-900">Rs. 0.00</dd>
                    </div>
                </dl>

                <a href="/checkout"
                   id="checkoutBtn"
                   class="mt-5 block w-full text-center bg-emerald-600 text-white font-semibold py-3 rounded-xl shadow hover:bg-emerald-700 active:scale-[.99] transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Proceed to Checkout
                </a>
                <p class="text-xs text-slate-500 mt-3">By placing your order, you agree to our Terms and Privacy Policy.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Axios instance (fresh each call to always read latest token)
    function api() {
        const token = localStorage.getItem('auth_token');
        return axios.create({
            baseURL: '/api',
            headers: {
                Accept: 'application/json',
                ...(token ? { Authorization: `Bearer ${token}` } : {}),
                'Cache-Control': 'no-cache'
            }
        });
    }

    const listEl      = document.getElementById('cart-list');
    const emptyEl     = document.getElementById('cart-empty');
    const subtotalEl  = document.getElementById('subtotal');
    const grandEl     = document.getElementById('grandtotal');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const itemPill    = document.getElementById('itemCountPill');

    let items = [];            // [{ id, quantity, product:{...} }]
    let isProgrammatic = false; // guard for programmatic input changes

    // Initial load
    loadCart();

    async function loadCart() {
        listEl.innerHTML = skeleton(3);
        try {
            const res = await api().get('/cart');
            const payload = res.data;
            items = Array.isArray(payload?.items) ? payload.items : [];
            render();
            totals();
        } catch (e) {
            console.error('Cart load error:', e);
            listEl.innerHTML = '';
            toastr.error('Failed to load cart');
        }
    }

    // Format currency
    function rs(n) {
        const x = Number(String(n ?? 0).replace(/,/g, '')) || 0;
        return 'Rs. ' + x.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Render all rows
    function render() {
        listEl.innerHTML = '';

        if (!items.length) {
            emptyEl.classList.remove('hidden');
            checkoutBtn.setAttribute('disabled', 'disabled');
            itemPill.textContent = '0 items';
            return;
        }

        emptyEl.classList.add('hidden');
        checkoutBtn.removeAttribute('disabled');
        itemPill.textContent = `${items.reduce((n, it) => n + Number(it.quantity||0), 0)} item(s)`;

        for (const it of items) {
            const p    = it.product || {};
            const unit = Number(p.price || 0);
            const qty  = Number(it.quantity || 1);

            const row = document.createElement('div');
            row.className = 'cart-row rounded-2xl border border-slate-200 bg-white p-4 shadow-sm flex gap-4 items-start';
            row.dataset.itemId = it.id;

            row.innerHTML = `
                <img class="w-24 h-24 rounded-xl object-cover border border-slate-100"
                     src="${p.image_url || ''}" alt="${p.name || 'Product'}">

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 line-clamp-2">${p.name || 'Unnamed Product'}</h3>
                            <div class="mt-1 text-xs text-slate-500">In stock: ${p.stock ?? '-'}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-slate-500">Unit</div>
                            <div class="text-lg font-semibold text-slate-900">${rs(unit)}</div>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div class="inline-flex items-center rounded-xl border border-slate-200 overflow-hidden bg-slate-50">
                            <button class="btn-dec px-3 py-2 text-slate-700 hover:bg-white" title="Decrease">−</button>
                            <input type="text" class="qty-input w-12 text-center border-0 bg-transparent focus:ring-0 py-2" value="${qty}" inputmode="numeric" pattern="[0-9]*">
                            <button class="btn-inc px-3 py-2 text-slate-700 hover:bg-white" title="Increase">+</button>
                        </div>

                        <button class="btn-remove inline-flex items-center gap-2 px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 font-medium" title="Remove">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 7h12v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7zm3-4h6l1 1h4v2H4V4h4l1-1z"/></svg>
                            Remove
                        </button>
                    </div>

                    <div class="mt-3 text-right">
                        <div class="text-xs text-slate-500">Line total</div>
                        <div class="text-lg font-extrabold text-slate-900 line-total">${rs(unit * qty)}</div>
                    </div>
                </div>
            `;
            listEl.appendChild(row);
        }
    }

    // Totals
    function totals() {
        const subtotal = items.reduce((s, it) => s + Number(it.product?.price || 0) * Number(it.quantity || 1), 0);
        subtotalEl.textContent = rs(subtotal);
        grandEl.textContent    = rs(subtotal);
        itemPill.textContent   = `${items.reduce((n, it) => n + Number(it.quantity||0), 0)} item(s)`;
    }

    // Event delegation
    listEl.addEventListener('click', async (e) => {
        const row = e.target.closest('.cart-row');
        if (!row) return;
        const id  = row.dataset.itemId;
        const idx = items.findIndex(x => String(x.id) === String(id));
        if (idx < 0) return;

        // Prevent bubbling into input change
        e.preventDefault();
        e.stopPropagation();

        if (e.target.closest('.btn-inc')) {
            await setQuantity(idx, Number(items[idx].quantity) + 1);
            return;
        }
        if (e.target.closest('.btn-dec')) {
            const current = Number(items[idx].quantity);
            if (current <= 1) {
                await removeItem(idx, true);
            } else {
                await setQuantity(idx, current - 1);
            }
            return;
        }
        if (e.target.closest('.btn-remove')) {
            await removeItem(idx, true);
            return;
        }
    });

    // Manual quantity edit
    listEl.addEventListener('change', async (e) => {
        const input = e.target.closest('.qty-input');
        if (!input) return;
        if (isProgrammatic) return; // ignore our own writes

        const row = e.target.closest('.cart-row');
        const id  = row.dataset.itemId;
        const idx = items.findIndex(x => String(x.id) === String(id));
        if (idx < 0) return;

        let val = parseInt(input.value, 10);
        if (isNaN(val) || val < 1) val = 1;
        await setQuantity(idx, val);
    });

    // ---- Actions (no full reloads on success) ----
    async function setQuantity(idx, newQty) {
        // Optimistic update
        items[idx].quantity = newQty;
        syncRow(idx);
        totals();

        try {
            isProgrammatic = true;
            await api().patch(`/cart/${items[idx].id}`, { quantity: newQty });

            // keep UI (already correct); only refresh counters
            if (typeof window.refreshHeaderCounts === 'function') {
                await window.refreshHeaderCounts();
            }
            toastr.success('Cart updated');
        } catch (err) {
            console.warn(err);
            await loadCart(); // resync on error
            toastr.error('Failed to update quantity');
        } finally {
            isProgrammatic = false;
        }
    }

    async function removeItem(idx, ask = false) {
        if (ask) {
            const ok = await Swal.fire({
                title: 'Remove item?',
                text: 'This item will be removed from your cart.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove'
            }).then(r => r.isConfirmed);
            if (!ok) return;
        }

        const id = items[idx].id;

        // Optimistic UI
        items.splice(idx, 1);
        render(); totals();

        try {
            await api().delete(`/cart/${id}`);

            // no full reload; just update counters
            if (typeof window.refreshHeaderCounts === 'function') {
                await window.refreshHeaderCounts();
            }
            toastr.success('Item removed');
        } catch (err) {
            console.warn(err);
            await loadCart(); // resync if backend failed
            toastr.error('Failed to remove item');
        }
    }

    // Update a single row after quantity change
    function syncRow(idx) {
        const node = listEl.querySelector(`.cart-row[data-item-id="${items[idx].id}"]`);
        if (!node) return;
        node.querySelector('.qty-input').value = items[idx].quantity;
        const unit = Number(items[idx].product?.price || 0);
        node.querySelector('.line-total').textContent = rs(unit * Number(items[idx].quantity || 1));
    }

    // Skeleton placeholders
    function skeleton(n = 3) {
        return Array.from({ length: n }).map(() => `
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm flex gap-4 items-start">
                <div class="w-24 h-24 rounded-xl bg-slate-200 animate-pulse"></div>
                <div class="flex-1">
                    <div class="h-4 w-2/3 bg-slate-200 rounded animate-pulse"></div>
                    <div class="h-4 w-1/3 bg-slate-200 rounded animate-pulse mt-2"></div>
                    <div class="h-8 w-full bg-slate-200 rounded animate-pulse mt-4"></div>
                </div>
            </div>
        `).join('');
    }
});
</script>
@endpush
