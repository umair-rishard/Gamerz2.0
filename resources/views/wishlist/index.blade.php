@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">My Wishlist</h1>
            <p class="text-slate-500 mt-1 text-sm">Save items you love. Move them to cart when you’re ready.</p>
        </div>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline font-medium">Continue shopping →</a>
    </div>

    <div id="wishlist-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"></div>

    <div id="wishlist-empty" class="hidden text-center py-16">
        <h2 class="text-xl font-semibold text-slate-700">Your wishlist is empty</h2>
        <p class="text-slate-500 mt-2">Browse products and add your favourites here.</p>
        <a href="{{ route('products.index') }}"
           class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Shop Now
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
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

    const container = document.getElementById('wishlist-container');
    const emptyState = document.getElementById('wishlist-empty');

    loadWishlist();

    async function loadWishlist() {
        container.innerHTML = skeleton(8);
        try {
            const res = await api().get('/wishlist');
            const list = res.data?.data || res.data || [];
            if (!Array.isArray(list) || list.length === 0) {
                container.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }
            emptyState.classList.add('hidden');
            render(list);
        } catch (e) {
            console.error('Wishlist load error:', e);
            container.innerHTML = '';
            toastr.error('Failed to load wishlist');
        }
    }

    function render(items) {
        container.innerHTML = '';
        items.forEach(item => {
            const p = item.product || {};
            const card = document.createElement('div');
            card.className = 'wishlist-card bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden hover:shadow-md transition flex flex-col';
            card.dataset.wishlistId = item.id;

            card.innerHTML = `
                <img src="${p.image_url || ''}" alt="${p.name || 'Product'}" class="w-full h-40 object-cover">
                <div class="p-3 flex flex-col flex-1">
                    <h3 class="text-sm font-semibold text-slate-800 line-clamp-2 min-h-[2.8rem]">${p.name || 'Unnamed Product'}</h3>
                    <div class="mt-2 text-slate-800 font-semibold">Rs. ${Number(p.price || 0).toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                    <div class="mt-auto flex gap-2 pt-3">
                        <button class="move-cart-btn flex-1 inline-flex items-center justify-center gap-2 bg-emerald-600 text-white text-sm py-2 rounded-lg hover:bg-emerald-700 active:scale-[.98] transition"
                                data-product-id="${p.id || ''}" data-wishlist-id="${item.id || ''}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.17 14h9.52c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1 1 0 0 0 21.17 5H6.21l-.94-2H2v2h2l3.6 7.59-.95 1.72A2.003 2.003 0 0 0 6 18h12v-2H6l1.17-2z"/></svg>
                            Move to Cart
                        </button>
                        <button class="remove-btn flex-1 inline-flex items-center justify-center gap-2 bg-rose-600 text-white text-sm py-2 rounded-lg hover:bg-rose-700 active:scale-[.98] transition"
                                data-wishlist-id="${item.id || ''}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 7h12v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7zm3-4h6l1 1h4v2H4V4h4l1-1z"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        attachEvents();
    }

    function bumpBadge(id, delta) {
        const el = document.getElementById(id);
        if (!el) return;
        const current = parseInt(el.textContent || '0', 10) || 0;
        const next = Math.max(0, current + delta);
        el.textContent = next;
    }

    function attachEvents() {
        // Remove
        container.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const wishlistId = this.dataset.wishlistId;
                const card = this.closest('.wishlist-card');

                const ok = await Swal.fire({
                    title: 'Remove item?',
                    text: 'This item will be removed from your wishlist.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove'
                }).then(r => r.isConfirmed);
                if (!ok) return;

                // optimistic: UI + badge
                card.remove();
                bumpBadge('wishlistCount', -1);
                try {
                    await api().delete(`/wishlist/${wishlistId}`);
                    if (!container.querySelector('.wishlist-card')) {
                        emptyState.classList.remove('hidden');
                    }
                    if (typeof window.refreshHeaderCounts === 'function') {
                        await window.refreshHeaderCounts();
                    }
                    toastr.success('Removed from wishlist');
                } catch (e) {
                    console.error(e);
                    toastr.error('Failed to remove item');
                    // revalidate UI
                    loadWishlist();
                    if (typeof window.refreshHeaderCounts === 'function') {
                        await window.refreshHeaderCounts();
                    }
                }
            });
        });

        // Move to cart
        container.querySelectorAll('.move-cart-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const productId  = this.dataset.productId;
                const wishlistId = this.dataset.wishlistId;
                const card = this.closest('.wishlist-card');

                // optimistic badges: -1 wishlist, +1 cart
                card.remove();
                bumpBadge('wishlistCount', -1);
                bumpBadge('cartCount', +1);

                try {
                    await api().post('/cart', { product_id: productId, quantity: 1 });
                    await api().delete(`/wishlist/${wishlistId}`);
                    if (!container.querySelector('.wishlist-card')) {
                        emptyState.classList.remove('hidden');
                    }
                    if (typeof window.refreshHeaderCounts === 'function') {
                        await window.refreshHeaderCounts();
                    }
                    toastr.success('Moved to cart');
                } catch (e) {
                    console.error(e);
                    toastr.error('Failed to move item');
                    // revalidate
                    await loadWishlist();
                    if (typeof window.refreshHeaderCounts === 'function') {
                        await window.refreshHeaderCounts();
                    }
                }
            });
        });
    }

    function skeleton(n=6){
        return Array.from({ length:n }).map(()=>`
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="h-40 bg-slate-200 animate-pulse"></div>
                <div class="p-3 space-y-2">
                    <div class="h-4 bg-slate-200 rounded animate-pulse"></div>
                    <div class="h-4 w-1/2 bg-slate-200 rounded animate-pulse"></div>
                    <div class="h-8 bg-slate-200 rounded mt-3 animate-pulse"></div>
                </div>
            </div>
        `).join('');
    }
});
</script>
@endpush
