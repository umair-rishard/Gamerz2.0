@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    {{-- Top bar / Back --}}
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('products.index') }}"
           class="group inline-flex items-center gap-2 text-sm sm:text-base px-3 sm:px-4 py-2 rounded-full backdrop-blur-lg bg-white/80 border border-white/20 shadow-lg hover:shadow-xl hover:bg-white/90 transition-all duration-300">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
            </svg>
            Back to products
        </a>
    </div>

    {{-- Product Section --}}
    <div id="productDetail"
         class="relative bg-gradient-to-br from-white via-white to-gray-50 rounded-3xl border border-white/50 shadow-2xl backdrop-blur-xl p-4 sm:p-6 lg:p-8 mb-10 overflow-hidden">
        {{-- Animated background gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 via-transparent to-indigo-500/5 animate-pulse"></div>
        <p class="relative text-center text-gray-500">Loading product...</p>
    </div>

    {{-- Reviews Section --}}
    <div id="reviewsSection"
         class="relative rounded-3xl backdrop-blur-xl bg-gradient-to-b from-white/90 via-white/80 to-white/90 border border-white/50 p-5 sm:p-8 shadow-xl overflow-hidden">
        {{-- Decorative gradient orbs --}}
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-violet-400/20 to-indigo-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-gradient-to-br from-indigo-400/20 to-violet-400/20 rounded-full blur-3xl"></div>
        
        <div class="relative flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 3 .97 4.29L1 23l6.71-1.97C9 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm5.5 13.5c-.25.69-.82 1.26-1.47 1.37-.39.07-.9.13-2.61-.55-2.19-.87-3.59-3.13-3.7-3.27-.11-.15-.94-1.25-.94-2.38 0-1.13.59-1.69.8-1.92.21-.23.46-.29.61-.29.15 0 .31 0 .44.01.14.01.34-.05.53.4.19.46.65 1.58.71 1.7.06.12.1.26.02.42-.08.16-.12.26-.24.4-.12.14-.25.31-.36.42-.11.12-.23.25-.1.48.13.23.58.96 1.24 1.55.85.76 1.58 1 1.8 1.11.22.11.35.09.48-.06.13-.15.55-.64.7-.86.15-.22.3-.19.5-.11.2.08 1.28.6 1.5.71.22.11.37.17.42.26.06.09.06.52-.19 1.21z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Customer Reviews</h2>
            </div>

            {{-- Right summary: avg & count --}}
            <div id="ratingSummary" class="hidden sm:flex items-center gap-3 px-4 py-2 rounded-full bg-white/60 backdrop-blur-sm border border-white/30 shadow-sm">
                <span id="avgStars" class="flex"></span>
                <span id="avgText" class="font-medium text-gray-700"></span>
            </div>
        </div>

        {{-- Masonry-like grid with more spacing --}}
        <div id="reviewsList" class="relative grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-10">
            <p class="text-gray-500">Loading reviews...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("auth_token");
    const api = axios.create({
        baseURL: "http://127.0.0.1:8000/api",
        headers: { Authorization: token ? `Bearer ${token}` : undefined, Accept: "application/json" }
    });

    const productId = "{{ $id }}";
    let productThumb = null;

    /* ================= Icons ================= */
    const icoCart  = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v8m0-8l2.293 2.293c.63.63.184 1.707-.707 1.707H7"/><circle cx="9" cy="22" r="1"/><circle cx="20" cy="22" r="1"/></svg>`;
    const icoBolt  = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11 21l1-7H6.74a.5.5 0 01-.4-.8l7.66-10.6c.35-.48 1.09-.16 1 .43l-1 6.3h5.26a.5.5 0 01.4.8l-7.66 10.6c-.35.48-1.09.16-1-.43z"/></svg>`;
    const icoHeart = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.5c0-2.485-2.015-4.5-4.5-4.5-1.47 0-2.775.705-3.6 1.8h-.001C12.074 4.705 10.77 4 9.3 4 6.815 4 4.8 6.015 4.8 8.5c0 .888.257 1.715.7 2.412l-.001.001L12 20l6.5-9.087v-.001c.443-.697.7-1.524.7-2.412z"/></svg>`;
    const icoCheck = `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
    const icoQuote = `<svg class="w-5 h-5 text-indigo-400/40" viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>`;
    const icoStar = `<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>`;

    /* ================= Helpers ================= */
    function esc(s){
      return String(s ?? '').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    }
    const star = (filled) => `
      <svg class="w-4 h-4 sm:w-5 sm:h-5 ${filled ? 'text-amber-400 drop-shadow-sm' : 'text-gray-200'}" viewBox="0 0 20 20" fill="currentColor">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674h4.91c.97 0 1.371 1.24.588 1.81l-3.975 2.89 1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.975-2.89-3.975 2.89c-.785.57-1.84-.197-1.54-1.118l1.518-4.674-3.975-2.89c-.783-.57-.382-1.81.588-1.81h4.91L9.05 2.927z"/>
      </svg>`;
    const starsRow = (n) => {
      const N = Math.max(0, Math.min(5, Number(n)||0));
      return `<div class="flex items-center gap-0.5">${[0,1,2,3,4].map(i => star(i < N)).join('')}</div>`;
    };
    const initialsBadge = (name, size='w-16 h-16') => {
      const t = (name || '').trim();
      const init = t ? t.split(' ').slice(0,2).map(s=>s[0]).join('').toUpperCase() : 'U';
      const colors = ['from-violet-400 to-indigo-500', 'from-indigo-400 to-cyan-500', 'from-emerald-400 to-teal-500', 'from-amber-400 to-orange-500'];
      const color = colors[Math.floor(Math.random() * colors.length)];
      return `<div class="${size} rounded-full bg-gradient-to-br ${color} text-white grid place-items-center font-bold shadow-lg">${init}</div>`;
    };

    function bumpBadge(id, delta = 1) {
        const el = document.getElementById(id);
        if (!el) return;
        const current = parseInt(el.textContent, 10) || 0;
        el.textContent = current + delta;
        el.classList.add('animate-bounce');
        setTimeout(() => el.classList.remove('animate-bounce'), 500);
    }

    /* ================= PRODUCT LOAD ================= */
    api.get(`/products/${productId}`)
        .then(res => {
            const p = res.data;
            const main = p.image_url || `/${p.image_path}`;
            productThumb = main || null;

            const extra = Array.isArray(p.extra_images) ? p.extra_images : [];
            const allThumbs = [main, ...extra.map(x => `/storage/${x}`)];
            const inStock = (p.stock ?? 0) > 0;

            const container = document.getElementById("productDetail");
            container.innerHTML = `
                <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
                    <!-- Left: Inset 3D Glass Media Container -->
                    <div class="relative">
                        <!-- Inset glass container with depth effect -->
                        <div class="relative">
                            <!-- Main inset container -->
                            <div class="relative bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl p-1 shadow-inner">
                                <!-- Inner recessed area -->
                                <div class="relative bg-gradient-to-br from-white/70 to-white/90 rounded-3xl p-3 sm:p-4 shadow-[inset_0_8px_16px_rgba(0,0,0,0.1)]">
                                    <!-- Deep inset effect -->
                                    <div class="relative rounded-2xl bg-gradient-to-br from-gray-50 to-white shadow-[inset_0_4px_12px_rgba(0,0,0,0.08)] p-2">
                                        <!-- Product Image (no hover effect) -->
                                        <img id="mainProductImage" src="${allThumbs[0]}" alt="${esc(p.name)}"
                                             class="relative w-full h-[22rem] sm:h-[26rem] lg:h-[28rem] object-contain rounded-xl"/>
                                        
                                        <!-- Inner glass overlay for depth -->
                                        <div class="absolute inset-0 rounded-xl bg-gradient-to-t from-black/5 via-transparent to-white/10 pointer-events-none"></div>
                                    </div>
                                    
                                    <!-- Premium badge -->
                                    <div class="absolute top-6 right-6 px-3 py-1.5 rounded-full bg-black/5 backdrop-blur-sm border border-white/50 shadow-sm">
                                        <span class="text-xs font-semibold text-gray-700 flex items-center gap-1">
                                            ${icoStar} Premium
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Subtle outer shadow for depth -->
                            <div class="absolute inset-0 rounded-3xl shadow-[0_0_40px_rgba(0,0,0,0.1)] pointer-events-none"></div>
                        </div>

                        <!-- Thumbnails with inset effect -->
                        <div id="thumbGallery" class="mt-4 flex flex-wrap gap-3">
                            ${allThumbs.map((src, i) => `
                                <button data-src="${src}" class="thumb relative rounded-xl ${i===0 ? 'ring-2 ring-indigo-500 ring-offset-2' : ''} bg-gray-100 p-0.5 shadow-inner transition-all">
                                    <div class="rounded-lg bg-white/80 p-1 shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)]">
                                        <img src="${src}" class="relative w-14 h-14 sm:w-18 sm:h-18 object-cover rounded-md" />
                                    </div>
                                </button>
                            `).join("")}
                        </div>
                    </div>

                    <!-- Right: Premium Info Card -->
                    <div class="flex flex-col">
                        <!-- Status badges with glass effect -->
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="text-xs px-3 py-1.5 rounded-full backdrop-blur-md bg-gradient-to-r from-slate-800 to-slate-700 text-white shadow-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                                ${p.category ?? "Uncategorized"}
                            </span>
                            <span class="text-xs px-3 py-1.5 rounded-full ${inStock ? 'bg-gradient-to-r from-emerald-500/20 to-green-500/20 text-emerald-700 border border-emerald-200/50' : 'bg-gradient-to-r from-rose-500/20 to-red-500/20 text-rose-700 border border-rose-200/50'} backdrop-blur-sm flex items-center gap-1">
                                ${icoCheck} <span class="font-semibold">${inStock ? 'In stock' : 'Out of stock'}</span>
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight mb-2 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent">${esc(p.name)}</h1>

                        <!-- Price with animated gradient -->
                        <div class="text-3xl sm:text-4xl font-extrabold mb-3 tracking-tight">
                            <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-600 bg-clip-text text-transparent animate-gradient">
                                Rs. ${Number(p.price).toLocaleString('en-LK', { minimumFractionDigits: 2 })}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            Stock: <span class="font-bold ${inStock ? 'text-emerald-600' : 'text-rose-600'}">${p.stock} units</span>
                        </p>

                        <!-- Premium Specs Card -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Specifications
                            </h3>
                            <div class="rounded-2xl backdrop-blur-md bg-gradient-to-br from-gray-50/90 to-white/90 border border-white/50 shadow-lg overflow-hidden">
                                <ul class="divide-y divide-gray-200/50">
                                    ${
                                        p.specs
                                          ? Object.entries(p.specs).map(([k,v], idx) =>
                                              `<li class="px-4 sm:px-5 py-3 flex justify-between gap-4 hover:bg-white/50 transition-colors ${idx % 2 === 0 ? 'bg-gray-50/30' : ''}">
                                                  <span class="text-gray-600 flex items-center gap-2">
                                                      <svg class="w-3 h-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="2"/></svg>
                                                      ${esc(k)}
                                                  </span>
                                                  <span class="font-semibold text-gray-900 text-right">${esc(v)}</span>
                                              </li>`
                                            ).join("")
                                          : `<li class="px-4 sm:px-5 py-4 text-gray-500 text-center">No specifications provided.</li>`
                                    }
                                </ul>
                            </div>
                        </div>

                        <!-- Premium Action Buttons -->
                        <div class="mt-6 sm:mt-8">
                            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                                <!-- Add to Cart -->
                                <button ${!inStock ? 'disabled' : ''} onclick="addToCart(${p.id})"
                                    class="group col-span-2 relative inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 to-violet-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="relative flex items-center gap-2">${icoCart} Add to Cart</span>
                                </button>

                                <!-- Buy Now -->
                                <button ${!inStock ? 'disabled' : ''} onclick="buyNow(${p.id})"
                                    class="group relative inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="relative flex items-center gap-1">${icoBolt} Buy</span>
                                </button>

                                <!-- Wishlist -->
                                <button onclick="addToWishlist(${p.id})"
                                    class="group mt-3 sm:mt-4 relative inline-flex items-center justify-center gap-2 rounded-xl border-2 border-rose-200 bg-gradient-to-r from-rose-50 to-pink-50 text-rose-600 px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold hover:border-rose-300 hover:from-rose-100 hover:to-pink-100 col-span-3 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all overflow-hidden">
                                    <span class="relative flex items-center gap-2">${icoHeart} Add to Wishlist</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Enhanced thumb switching (no hover on main image)
            document.querySelectorAll("#thumbGallery .thumb").forEach(btn => {
                btn.addEventListener("click", () => {
                    const src = btn.getAttribute("data-src");
                    const mainImg = document.getElementById("mainProductImage");
                    
                    // Smooth transition
                    mainImg.style.opacity = '0.7';
                    setTimeout(() => {
                        mainImg.src = src;
                        mainImg.style.opacity = '1';
                    }, 150);

                    // Update active state
                    document.querySelectorAll("#thumbGallery .thumb").forEach(b => {
                        b.classList.remove("ring-2","ring-indigo-500","ring-offset-2");
                    });
                    btn.classList.add("ring-2","ring-indigo-500","ring-offset-2");
                });
            });
        })
        .catch(() => {
            document.getElementById("productDetail").innerHTML =
                `<p class="text-center text-red-500">Error loading product details</p>`;
        });

    /* ================= Actions ================= */
    window.addToCart = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!", confirmButtonColor: "#6366f1" });
        api.post("/cart", { product_id: id, quantity: 1 })
            .then(() => {
                bumpBadge('cartCount', 1);
                Swal.fire({ icon: "success", title: "Added to Cart", timer: 1100, showConfirmButton: false });
            })
            .catch(() => Swal.fire({ icon: "error", title: "Failed to add" }));
    };

    window.buyNow = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!", confirmButtonColor: "#6366f1" });
        api.post("/cart", { product_id: id, quantity: 1 })
            .then(() => window.location.href = "/checkout")
            .catch(() => Swal.fire({ icon: "error", title: "Failed to proceed" }));
    };

    window.addToWishlist = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!", confirmButtonColor: "#6366f1" });
        api.post("/wishlist", { product_id: id })
            .then(() => {
                bumpBadge('wishlistCount', 1);
                Swal.fire({ icon: "success", title: "Added to Wishlist", timer: 1100, showConfirmButton: false });
            })
            .catch(() => Swal.fire({ icon: "error", title: "Failed to add" }));
    };

    /* ================= Reviews ================= */
    loadReviews();

    // Clean Premium Review Card (no glow, better spacing)
    function reviewCard({ name, avatar, rating, comment, when }) {
        const avatarNode = avatar
            ? `<img src="${esc(avatar)}" class="w-16 h-16 rounded-full object-cover border-4 border-white shadow-xl" alt="${esc(name)}">`
            : initialsBadge(name);

        return `
        <div class="group relative mt-8">
            <!-- Clean card with subtle gradient -->
            <div class="relative backdrop-blur-xl bg-gradient-to-br from-white/95 to-white/90 rounded-2xl border border-gray-200/60 shadow-lg hover:shadow-xl transition-all duration-300 p-5 sm:p-6">
                <!-- Floating avatar (no glow) -->
                <div class="absolute -top-8 left-1/2 -translate-x-1/2">
                    ${avatarNode}
                </div>

                <!-- Quote decoration -->
                <div class="absolute top-4 right-4">
                    ${icoQuote}
                </div>

                <!-- Content with better spacing -->
                <div class="pt-10">
                    <!-- Name -->
                    <div class="text-center mb-4">
                        <span class="text-sm font-bold text-gray-800">${esc(name)}</span>
                    </div>

                    <!-- Comment -->
                    <div class="px-2">
                        <p class="text-gray-600 text-center leading-relaxed text-sm sm:text-base min-h-[3rem]">
                            "${esc(comment || 'Great product!')}"
                        </p>
                    </div>

                    <!-- Rating badge -->
                    <div class="mt-5 flex justify-center">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-yellow-50 to-amber-50 border border-amber-200/40">
                            ${starsRow(rating)}
                            <span class="text-xs font-semibold text-amber-700">${Number(rating||0).toFixed(1)}</span>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] sm:text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            ${esc(when)}
                        </span>
                        ${productThumb ? `
                            <div class="w-8 h-8 rounded-lg overflow-hidden border border-gray-200">
                                <img src="${productThumb}" class="w-full h-full object-cover" alt="product">
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>`;
    }

    function loadReviews(){
        axios.get(`/api/reviews/${productId}`)
            .then(res => {
                const reviews = Array.isArray(res.data) ? res.data : [];
                const list = document.getElementById("reviewsList");

                if (!reviews.length) {
                    list.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <p class="text-gray-500">No reviews yet. Be the first to write one!</p>
                        </div>`;
                    document.getElementById('ratingSummary').classList.add('hidden');
                    return;
                }

                // Calculate and show average
                const avg = (reviews.reduce((s,r)=> s + (Number(r.rating)||0), 0) / reviews.length).toFixed(1);
                document.getElementById('avgStars').innerHTML = starsRow(Math.round(avg));
                document.getElementById('avgText').innerHTML = `<strong>${avg}</strong> / 5 · ${reviews.length} review${reviews.length>1?'s':''}`;
                document.getElementById('ratingSummary').classList.remove('hidden');

                // Render cards with proper spacing
                list.innerHTML = reviews.map((r, idx) => {
                    const name = r.user_name || (r.user && r.user.name) || 'Anonymous';
                    const when = r.created_at ? new Date(r.created_at).toLocaleDateString() : '';
                    return `<div style="animation-delay: ${idx * 0.1}s" class="animate-fadeIn">
                        ${reviewCard({
                            name,
                            avatar: r.user_avatar || '',
                            rating: r.rating,
                            comment: r.comment,
                            when
                        })}
                    </div>`;
                }).join('');
            })
            .catch(() => {
                document.getElementById("reviewsList").innerHTML =
                    `<p class="col-span-full text-center text-gray-500">Reviews not available right now.</p>`;
                document.getElementById('ratingSummary').classList.add('hidden');
            });
    }
});
</script>

<style>
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.6s ease forwards;
}
</style>
@endpush