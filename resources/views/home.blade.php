@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-white via-slate-50/40 to-white">

    {{-- ================= HERO IMAGE SLIDER ================= --}}
    <div
        x-data="{
            active: 0,
            slides: [
                '{{ asset('images/banner.jpg') }}',
                '{{ asset('images/banner2.jpg') }}',
                '{{ asset('images/final.png') }}'
            ],
            timer: null,
            next(){ this.active = (this.active + 1) % this.slides.length },
            prev(){ this.active = (this.active - 1 + this.slides.length) % this.slides.length },
            start(){ this.timer = setInterval(() => this.next(), 5000) },
            stop(){ if (this.timer) { clearInterval(this.timer); this.timer = null; } },
        }"
        x-init="start()"
        @mouseenter="stop()" @mouseleave="start()"
        class="relative w-full h-[300px] md:h-[500px] lg:h-[600px] overflow-hidden"
        aria-label="Hero banner slider"
    >
        {{-- Slides (fade) --}}
        <template x-for="(slide, i) in slides" :key="i">
            <div
                class="absolute inset-0 transition-opacity duration-[1200ms] ease-in-out"
                :class="active === i ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <img :src="slide" class="w-full h-full object-cover" :alt="`Banner ${i+1}`">
            </div>
        </template>

        {{-- Controls --}}
        <div class="absolute inset-0 flex items-center justify-between px-4 z-20">
            <button @click="prev()" class="bg-black/55 text-white w-9 h-9 md:w-10 md:h-10 rounded-full grid place-items-center hover:bg-black/70 transition" aria-label="Previous slide">‹</button>
            <button @click="next()" class="bg-black/55 text-white w-9 h-9 md:w-10 md:h-10 rounded-full grid place-items-center hover:bg-black/70 transition" aria-label="Next slide">›</button>
        </div>

        {{-- Indicators --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
            <template x-for="(slide, i) in slides" :key="i">
                <button @click="active = i"
                        class="w-2.5 h-2.5 rounded-full transition-all"
                        :aria-label="`Go to slide ${i+1}`"
                        :class="active === i ? 'bg-white scale-125' : 'bg-white/60 hover:bg-white/80'"></button>
            </template>
        </div>
    </div>

    {{-- ================= FULL-SCREEN VIDEO BANNER ================= --}}
    <section class="relative w-full overflow-hidden">
        <video autoplay loop muted playsinline class="block w-full h-screen object-cover">
            <source src="{{ asset('videos/banner.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>

    {{-- ================= STATIC BIG IMAGE BANNER ================= --}}
    <section class="relative w-full overflow-hidden">
        <img src="{{ asset('images/bigbanner.png') }}" alt="Big Banner" class="block w-full h-auto object-cover">
    </section>

    {{-- ================= FEATURED PRODUCTS (white section / white cards with black footer) ================= --}}
    <section class="w-full bg-white">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-8">
                Featured <span class="font-light text-gray-500">Picks</span>
            </h2>

            <div id="featured-products" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <p class="col-span-full text-gray-500" id="loading-text">Loading products...</p>
            </div>
        </div>
    </section>

    {{-- ================= DESIGNED BY #GAMERZ (LOCAL GALLERY) ================= --}}
    @php
        // Load images from /public/images/gallery (jpg, jpeg, png, webp, gif)
        $paths = glob(public_path('images/gallery/*.{jpg,jpeg,png,webp,gif}'), GLOB_BRACE) ?: [];
        shuffle($paths);
        $galleryImages = array_slice(array_map(fn($p) => asset('images/gallery/' . basename($p)), $paths), 0, 8);
    @endphp
    <section class="w-full bg-white">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="text-center mb-8">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900">
                    Designed by <span class="text-black">#GAMERZ</span>
                </h2>
                <p class="mt-2 text-sm text-gray-500">Some of the best designs from our gallery.</p>
            </div>

            @if (count($galleryImages))
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach ($galleryImages as $src)
                        <button class="group relative rounded-2xl overflow-hidden bg-white border border-black/10 shadow-sm hover:shadow-md transition gallery-open" data-src="{{ $src }}">
                            <div class="aspect-[4/3] w-full overflow-hidden">
                                <img src="{{ $src }}" alt="Gallery item" class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300" />
                            </div>
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">No images found in <code>public/images/gallery</code>.</p>
            @endif
        </div>

        <!-- Lightbox Modal -->
        <div id="gallery-modal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
            <button id="gallery-close" class="absolute top-4 right-4 text-white/80 hover:text-white text-2xl" aria-label="Close">&times;</button>
            <img id="gallery-modal-img" src="" alt="Preview" class="max-w-[92vw] max-h-[88vh] rounded-2xl shadow-2xl object-contain" />
        </div>
    </section>

    {{-- ================= WHY CHOOSE GAMERZ / FEATURES ================= --}}
    <section class="w-full bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-2 gap-10 md:gap-14 items-center">
                {{-- Left: Illustration --}}
                <div class="flex justify-center md:justify-start">
                    <img src="{{ asset('images/assistant.png') }}" alt="GAMERZ Assistant" class="max-w-[520px] w-full h-auto select-none">
                </div>

                {{-- Right: 2x2 Features --}}
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        {{-- Feature 1 --}}
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-black text-white grid place-items-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M9 2h6v2h2a1 1 0 0 1 1 1v2h2v2h-2v6h2v2h-2v2a1 1 0 0 1-1 1h-2v2H9v-2H7a1 1 0 0 1-1-1v-2H4v-2h2V7H4V5h2V3a1 1 0 0 1 1-1h2V0h6v2ZM8 8a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1H8Z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Custom PC Builds</h4>
                                <p class="mt-1 text-sm text-gray-600">We tailor every build to your needs—gaming, creative, or pro workflows. Choose parts with confidence and let us optimize your rig.</p>
                            </div>
                        </div>
                        {{-- Feature 2 --}}
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-black text-white grid place-items-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 3 6.5v11L12 22l9-4.5v-11L12 2Zm0 2.2 6.8 3.4L12 11 5.2 7.6 12 4.2ZM5 9.4l6 3v7.3l-6-3V9.4Zm14 7.3-6 3v-7.3l6-3v7.3Z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">High-Quality Components</h4>
                                <p class="mt-1 text-sm text-gray-600">Only trusted brands—CPUs, GPUs, SSDs & cooling—benchmarked and tested. Your build runs cooler, faster, longer.</p>
                            </div>
                        </div>
                        {{-- Feature 3 --}}
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-black text-white grid place-items-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a8 8 0 0 0-8 8v5a3 3 0 0 0 3 3h2v-6H6v-2a6 6 0 0 1 12 0v2h-3v6h2a3 3 0 0 0 3-3v-5a8 8 0 0 0-8-8Z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Expert Support</h4>
                                <p class="mt-1 text-sm text-gray-600">Build advice, part compatibility, and performance tuning—our team is on call before and after your purchase.</p>
                            </div>
                        </div>
                        {{-- Feature 4 --}}
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-black text-white grid place-items-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 4 5v6c0 5 3.4 8.8 8 11 4.6-2.2 8-6 8-11V5l-8-3Zm-1 14-4-4 1.4-1.4L11 12.2l5.6-5.6L18 8l-7 8Z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Warranty & Peace of Mind</h4>
                                <p class="mt-1 text-sm text-gray-600">Covered by warranty with easy service options. Diagnostics, repairs, or replacements—handled quickly and clearly.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

{{-- Axios (once) --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    /* ==================== FEATURED PRODUCTS ==================== */
    const productsContainer = document.getElementById("featured-products");
    const loadingText = document.getElementById("loading-text");

    const shuffle = (arr) => { for (let i = arr.length - 1; i > 0; i--) { const j = Math.floor(Math.random()*(i+1)); [arr[i],arr[j]]=[arr[j],arr[i]]; } return arr; };
    const starHTML = (r) => {
        const full = Math.floor(r), half = (r - full) >= 0.5 ? 1 : 0, empty = 5 - full - half;
        return `${'★'.repeat(full).split('').map(s=>`<span class='text-yellow-500'>${s}</span>`).join('')}${half?'<span class="text-yellow-500">☆</span>':''}${'★'.repeat(empty).split('').map(s=>`<span class='text-gray-300'>${s}</span>`).join('')}<span class="ml-2 text-xs text-gray-500">(${r.toFixed(1)})</span>`;
    };
    const stockBadge = (stock) => {
        const ok = (Number(stock)||0) > 0;
        return `<span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-medium ${ok?'bg-emerald-600/15 text-emerald-700 ring-1 ring-emerald-600/20':'bg-rose-600/15 text-rose-700 ring-1 ring-rose-600/20'}">${ok?'In stock':'Out of stock'}</span>`;
    };

    axios.get("/api/products?per_page=24")
        .then(res => {
            let data = res.data?.data ?? [];
            if (!Array.isArray(data)) data = [];
            data = shuffle(data).slice(0, 8);

            productsContainer.innerHTML = "";

            data.forEach(p => {
                const price = (typeof p.price === 'number') ? p.price.toFixed(2) : p.price;
                const rating = 3.5 + Math.random() * 1.5;
                const category = p.category ?? 'Uncategorized';
                const img = p.image_url ?? '/images/no-image.png';

                productsContainer.innerHTML += `
                    <a href="/products/${p.id}" class="group relative rounded-2xl overflow-hidden bg-white border-2 border-black transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="relative w-full h-56 overflow-hidden bg-gray-100">
                            <img src="${img}" alt="${p.name}" class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-300" onerror="this.src='/images/no-image.png'">
                            <div class="absolute top-3 left-3">${stockBadge(p.stock)}</div>
                        </div>
                        <div class="p-4 min-h-[120px]">
                            <h3 class="text-gray-900 font-semibold line-clamp-1">${p.name}</h3>
                            <div class="mt-2 text-sm">${starHTML(rating)}</div>
                        </div>
                        <div class="bg-black text-white px-4 py-3 flex items-center justify-between">
                            <span class="text-xs uppercase tracking-wide text-white/80">${category}</span>
                            <span class="text-white font-semibold">Rs. ${price}</span>
                        </div>
                    </a>
                `;
            });

            if (!data.length) {
                productsContainer.innerHTML = '<p class="col-span-full text-gray-500">No products found.</p>';
            }
        })
        .catch(() => loadingText.innerText = "Failed to load products.");

    /* ==================== LOCAL GALLERY LIGHTBOX ==================== */
    const modal = document.getElementById('gallery-modal');
    const modalImg = document.getElementById('gallery-modal-img');
    const closeBtn = document.getElementById('gallery-close');

    const closeModal = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); modalImg.src = ''; };

    document.querySelectorAll('.gallery-open').forEach(btn => {
        btn.addEventListener('click', () => {
            modalImg.src = btn.dataset.src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    closeBtn.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
});
</script>

@endsection
