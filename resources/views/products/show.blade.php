@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    {{-- Top bar / Back --}}
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 text-sm sm:text-base px-3 sm:px-4 py-2 rounded-full border border-gray-200 bg-white shadow hover:bg-gray-50">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
            </svg>
            Back to products
        </a>
    </div>

    {{-- Product Section --}}
    <div id="productDetail" class="bg-white rounded-2xl border border-gray-200 shadow-lg p-4 sm:p-6 lg:p-8 mb-10">
        <p class="text-center text-gray-500">Loading product...</p>
    </div>

    {{-- Testimonials Section --}}
    <div id="reviewsSection" class="rounded-2xl border border-gray-200 bg-gray-50 p-5 sm:p-8">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.137 1.5 2.113v6.376a2.25 2.25 0 0 1-2.25 2.25H8.25L3 21l1.75-4.375V6.75A2.25 2.25 0 0 1 7 4.5h6.375"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h7.5M8.25 8.25h7.5M18 4.5H9.75A2.25 2.25 0 0 0 7.5 6.75v7.5"/>
            </svg>
            <h2 class="text-2xl font-bold">Customer Reviews</h2>
        </div>
        <div id="reviewsList" class="space-y-4">
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

    // Icons (Heroicons)
    const icoCart  = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.09.834l.383 1.433M7.5 14.25h10.36a1.5 1.5 0 0 0 1.463-1.174l1.32-6.346A1.5 1.5 0 0 0 19.166 5.25H5.109M7.5 14.25l-.768 3.07A1.5 1.5 0 0 0 8.19 19.5h9.06M7.5 14.25H5.25M9 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm9 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>`;
    const icoBolt  = `<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.5 4.5 5.25 13.75h6L9.5 21 18.75 11.75h-6z"/></svg>`;
    const icoHeart = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21s-7.5-4.686-9.75-8.25C.436 9.33 2.25 6 5.25 6c1.86 0 3.36 1.002 4.125 2.25C10.39 7.002 11.89 6 13.75 6 16.75 6 18.564 9.33 21.75 12.75 19.5 16.314 12 21 12 21Z"/></svg>`;
    const icoCheck = `<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>`;

    // Badge bump
    function bumpBadge(id, delta = 1) {
        const el = document.getElementById(id);
        if (!el) return;
        const current = parseInt(el.textContent, 10) || 0;
        el.textContent = current + delta;
        el.style.transform = 'scale(1.2)';
        setTimeout(() => el.style.transform = 'scale(1)', 120);
    }

    // PRODUCT LOAD
    api.get(`/products/${productId}`)
        .then(res => {
            const p = res.data;
            const main = p.image_url || `/${p.image_path}`;
            const extra = Array.isArray(p.extra_images) ? p.extra_images : [];
            const allThumbs = [main, ...extra.map(x => `/storage/${x}`)];
            const inStock = (p.stock ?? 0) > 0;

            const container = document.getElementById("productDetail");
            container.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">

                    <!-- Left: Media (clean white card, subtle border) -->
                    <div>
                        <div class="relative rounded-xl border border-gray-200 bg-white p-3 sm:p-4">
                            <div class="absolute top-3 left-3 flex items-center gap-2">
                                <span class="text-xs px-2 py-1 rounded bg-gray-900/80 text-white">${p.category ?? "Uncategorized"}</span>
                                <span class="text-xs px-2 py-1 rounded ${inStock ? 'bg-emerald-500/20 text-emerald-700' : 'bg-rose-500/20 text-rose-700'}">
                                    ${inStock ? `${icoCheck} <span class='ml-1'>In stock</span>` : 'Out of stock'}
                                </span>
                            </div>
                            <img id="mainProductImage" src="${allThumbs[0]}" alt="${p.name}"
                                 class="w-full h-[22rem] sm:h-[26rem] lg:h-[28rem] object-contain rounded-lg"/>
                        </div>

                        <!-- Thumbnails -->
                        <div id="thumbGallery" class="mt-4 flex flex-wrap gap-3">
                            ${allThumbs.map((src, i) => `
                                <button data-src="${src}" class="thumb group rounded-lg border ${i===0 ? 'border-indigo-600 ring-2 ring-indigo-500/40' : 'border-gray-200'} p-1 bg-white hover:border-indigo-400 transition">
                                    <img src="${src}" class="w-16 h-16 sm:w-18 sm:h-18 object-cover rounded-md" />
                                </button>
                            `).join("")}
                        </div>
                    </div>

                    <!-- Right: Info -->
                    <div class="flex flex-col">
                        <h1 class="text-2xl sm:text-3xl font-bold leading-tight mb-2">${p.name}</h1>

                        <div class="text-3xl sm:text-4xl font-extrabold text-indigo-600 mb-3">
                            Rs. ${Number(p.price).toLocaleString('en-LK', { minimumFractionDigits: 2 })}
                        </div>

                        <p class="text-sm text-gray-500 mb-6">Stock:
                            <span class="font-medium ${inStock ? 'text-emerald-600' : 'text-rose-600'}">${p.stock}</span>
                        </p>

                        <!-- Specs -->
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold mb-3">Specifications</h3>
                            <div class="rounded-xl border border-gray-200 bg-gray-50">
                                <ul class="divide-y divide-gray-200">
                                    ${
                                        p.specs
                                          ? Object.entries(p.specs).map(([k,v]) =>
                                              `<li class="px-4 sm:px-5 py-3 flex justify-between gap-4">
                                                  <span class="text-gray-500">${k}</span>
                                                  <span class="font-medium text-gray-900 text-right">${v}</span>
                                              </li>`
                                            ).join("")
                                          : `<li class="px-4 sm:px-5 py-4 text-gray-500">No specifications provided.</li>`
                                    }
                                </ul>
                            </div>
                        </div>

                        <!-- Actions moved BELOW specs -->
                        <div class="mt-6 sm:mt-8">
                            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                                <button ${!inStock ? 'disabled' : ''} onclick="addToCart(${p.id})"
                                    class="col-span-2 inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-600 bg-indigo-600 text-white px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold hover:bg-indigo-700 disabled:opacity-50">
                                    ${icoCart} <span>Add to Cart</span>
                                </button>

                                <button ${!inStock ? 'disabled' : ''} onclick="buyNow(${p.id})"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-500 bg-amber-500 text-white px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold hover:bg-amber-600 disabled:opacity-50">
                                    ${icoBolt} <span>Buy Now</span>
                                </button>

                                <button onclick="addToWishlist(${p.id})"
                                    class="mt-3 sm:mt-4 inline-flex items-center justify-center gap-2 rounded-xl border border-rose-500 bg-white text-rose-600 px-4 py-2.5 sm:py-3 text-sm sm:text-base font-semibold hover:bg-rose-50 col-span-3">
                                    ${icoHeart} <span>Add to Wishlist</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Thumb switching + active state
            document.querySelectorAll("#thumbGallery .thumb").forEach(btn => {
                btn.addEventListener("click", () => {
                    const src = btn.getAttribute("data-src");
                    const mainImg = document.getElementById("mainProductImage");
                    mainImg.src = src;

                    document.querySelectorAll("#thumbGallery .thumb").forEach(b => {
                        b.classList.remove("border-indigo-600","ring-2","ring-indigo-500/40");
                        b.classList.add("border-gray-200");
                    });
                    btn.classList.remove("border-gray-200");
                    btn.classList.add("border-indigo-600","ring-2","ring-indigo-500/40");
                });
            });
        })
        .catch(() => {
            document.getElementById("productDetail").innerHTML =
                `<p class="text-center text-red-500">Error loading product details</p>`;
        });

    // Actions
    window.addToCart = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!" });
        api.post("/cart", { product_id: id, quantity: 1 })
            .then(() => {
                bumpBadge('cartCount', 1);
                Swal.fire({ icon: "success", title: "Added to Cart", timer: 1100, showConfirmButton: false });
            })
            .catch(() => Swal.fire({ icon: "error", title: "Failed to add" }));
    };

    window.buyNow = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!" });
        api.post("/cart", { product_id: id, quantity: 1 })
            .then(() => window.location.href = "/checkout")
            .catch(() => Swal.fire({ icon: "error", title: "Failed to proceed" }));
    };

    window.addToWishlist = function (id) {
        if (!token) return Swal.fire({ icon: "info", text: "Login required!" });
        api.post("/wishlist", { product_id: id })
            .then(() => {
                bumpBadge('wishlistCount', 1);
                Swal.fire({ icon: "success", title: "Added to Wishlist", timer: 1100, showConfirmButton: false });
            })
            .catch(() => Swal.fire({ icon: "error", title: "Failed to add" }));
    };

    // Reviews (stubbed)
    axios.get(`http://127.0.0.1:8000/api/reviews/${productId}`)
        .then(res => {
            const reviews = res.data || [];
            const list = document.getElementById("reviewsList");
            list.innerHTML = reviews.length
                ? reviews.map(r => `
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold">${r.user_name}</p>
                            <p class="text-xs text-gray-500">${r.created_at}</p>
                        </div>
                        <p class="mt-2 text-gray-700">${r.comment}</p>
                    </div>
                `).join("")
                : `<p class="text-gray-500">No reviews yet. Be the first to write one!</p>`;
        })
        .catch(() => {
            document.getElementById("reviewsList").innerHTML =
                `<p class="text-gray-500">Reviews not available right now.</p>`;
        });
});
</script>
@endpush
