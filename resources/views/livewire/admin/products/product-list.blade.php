{{-- Admin > Products (premium: gradient header, centered titles, zebra rows, borders, glass) --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            {{-- Page title + Create --}}
            <div class="flex items-center justify-between">
                <h1 class="text-5xl font-extrabold tracking-tight text-slate-700">
                    Products
                </h1>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold shadow-xl shadow-indigo-500/20 transition-all duration-300 hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </a>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="relative overflow-hidden rounded-2xl bg-emerald-50 border border-emerald-200/70 p-5 shadow-md">
                    <div class="flex items-center gap-3 text-emerald-800">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Glass card container (page body) --}}
            <section class="rounded-3xl p-6 md:p-8 border border-slate-300/80 bg-white/60 backdrop-blur-xl shadow-[0_14px_40px_rgba(2,6,23,0.10)]">
                {{-- Controls --}}
                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 md:gap-6 mb-6 md:mb-8">
                    {{-- Search --}}
                    <div class="relative flex-1 max-w-3xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            placeholder="Search by name, description or category..."
                            class="w-full pl-12 pr-4 py-3 rounded-2xl border-2 border-slate-300 bg-white text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300"
                            wire:model.live="search"
                        />
                    </div>

                    {{-- Selected Category pill --}}
                    @if($selectedCategory)
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold">
                                Filtering by: {{ $selectedCategory->name }}
                            </span>
                            <button type="button"
                                    wire:click="clearCategory"
                                    class="text-sm px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold">
                                Clear
                            </button>
                        </div>
                    @endif

                    {{-- Per Page --}}
                    <div class="flex items-center gap-3 px-5 py-2.5 bg-slate-900 text-slate-200 rounded-2xl border border-slate-700 shadow-lg">
                        <span class="text-sm font-semibold">Show</span>
                        <select wire:model="perPage"
                                class="rounded-xl border border-slate-600 bg-slate-800 text-slate-200 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 transition-all duration-300">
                            <option class="text-black" value="10">10</option>
                            <option class="text-black" value="25">25</option>
                            <option class="text-black" value="50">50</option>
                        </select>
                        <span class="text-sm font-semibold">per page</span>
                    </div>
                </div>

                {{-- SECONDARY CHIP if $category prop is present --}}
                @if ($category)
                    <div class="mb-6">
                        <button wire:click="clearCategory"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-sm font-semibold hover:bg-indigo-200">
                            @if($selectedCategory)
                                <span>{{ $selectedCategory->name }}</span>
                            @endif
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- ========== MOBILE CARDS (< md) ========== --}}
                <div class="md:hidden space-y-4">
                    @forelse($products as $p)
                        @php
                            $imgUrl = $p->image_path ? asset('storage/'.$p->image_path) : null;
                            $brand  = $p->brand ?? null;
                            $cat    = $p->category?->name;
                        @endphp
                        <div class="rounded-3xl border border-slate-300 bg-white shadow-md p-4 group">
                            <div class="flex gap-3">
                                {{-- Larger image --}}
                                <div class="h-24 w-24 rounded-xl overflow-hidden bg-slate-100 ring-1 ring-slate-200 flex-shrink-0">
                                    @if ($imgUrl)
                                        <img src="{{ $imgUrl }}" alt="{{ $p->name }}"
                                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                    @else
                                        <svg viewBox="0 0 64 64" class="h-full w-full text-slate-300">
                                            <rect width="64" height="64" fill="currentColor"/>
                                            <g fill="#fff">
                                                <circle cx="22" cy="24" r="8" opacity=".9"/>
                                                <path d="M8 52l14-14 8 8 12-12 14 18H8z" opacity=".95"/>
                                            </g>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $p->name }}</div>
                                    @if ($brand || $cat)
                                        <span class="inline-block mt-1 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                            {{ $brand ?: $cat }}
                                        </span>
                                    @endif
                                </div>

                                <div class="hidden xs:block">
                                    @if ((int)$p->stock > 0)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                            {{ $p->stock }} in stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">
                                            Out of stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="font-bold text-slate-900 tabular-nums">
                                    <span class="text-xs text-slate-500">LKR</span>
                                    <span class="text-lg leading-none">{{ number_format((int)$p->price, 0) }}</span>
                                </div>
                                <div class="xs:hidden">
                                    @if ((int)$p->stock > 0)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                            {{ $p->stock }} in stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">
                                            Out of stock
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <a href="{{ route('admin.products.edit', $p->id) }}"
                                   class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md">
                                    Update
                                </a>
                                <button
                                    x-data
                                    @click.prevent="if (confirm('Delete this product?')) { $wire.delete({{ $p->id }}) }"
                                    class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                            <p class="text-base text-gray-600">Try searching or add a new product.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ========== DESKTOP TABLE (md+) ========== --}}
                <div class="hidden md:block overflow-x-auto rounded-3xl border border-slate-300 bg-white/70 backdrop-blur-xl shadow-[0_16px_40px_rgba(2,6,23,0.12)]">
                    {{-- Header (centered + gradient) --}}
                    <div class="rounded-t-3xl bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 text-slate-100">
                        <table class="min-w-full table-fixed">
                            <colgroup>
                                <col class="w-28">
                                <col>
                                <col class="w-56">
                                <col class="w-44">
                                <col class="w-44">
                                <col class="w-56">
                            </colgroup>
                            <thead>
                            <tr class="text-[13px] md:text-sm uppercase tracking-wider">
                                <th class="px-4 py-5 text-center">Product</th>
                                <th class="px-4 py-5 text-center">Product Name</th>
                                <th class="px-4 py-5 text-center">Brand / Category</th>
                                <th class="px-4 py-5 text-center">Stock</th>
                                <th class="px-4 py-5 text-center">Price</th>
                                <th class="px-4 py-5 text-center">Actions</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    {{-- Body --}}
                    <table class="min-w-full table-fixed">
                        <colgroup>
                            <col class="w-28">
                            <col>
                            <col class="w-56">
                            <col class="w-44">
                            <col class="w-44">
                            <col class="w-56">
                        </colgroup>
                        <tbody class="divide-y divide-slate-200">
                        @forelse ($products as $p)
                            @php
                                $imgUrl = $p->image_path ? asset('storage/'.$p->image_path) : null;
                                $brand  = $p->brand ?? null;
                                $cat    = $p->category?->name;
                            @endphp
                            <tr
                                class="group transition-colors
                                       odd:bg-white even:bg-slate-50
                                       odd:shadow-[inset_6px_0_0_0_rgba(99,102,241,0.45)]
                                       even:shadow-[inset_6px_0_0_0_rgba(239,68,68,0.45)]
                                       hover:bg-white/90">
                                {{-- Product image --}}
                                <td class="px-4 py-5 align-middle">
                                    <div class="h-20 w-20 rounded-xl overflow-hidden bg-slate-100 ring-1 ring-slate-200 mx-auto">
                                        @if ($imgUrl)
                                            <img src="{{ $imgUrl }}" alt="{{ $p->name }}"
                                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                        @else
                                            <svg viewBox="0 0 64 64" class="h-full w-full text-slate-300">
                                                <rect width="64" height="64" fill="currentColor"/>
                                                <g fill="#fff">
                                                    <circle cx="22" cy="24" r="8" opacity=".9"/>
                                                    <path d="M8 52l14-14 8 8 12-12 14 18H8z" opacity=".95"/>
                                                </g>
                                            </svg>
                                        @endif
                                    </div>
                                </td>

                                {{-- Product name + desc --}}
                                <td class="px-4 py-5 align-middle">
                                    <div class="font-semibold text-slate-900 text-[15px]">{{ $p->name }}</div>
                                    <div class="text-xs text-slate-500 line-clamp-1">{{ $p->description }}</div>
                                </td>

                                {{-- Brand / Category --}}
                                <td class="px-4 py-5 align-middle text-center">
                                    @if ($brand || $cat)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                                            {{ $brand ?: $cat }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Stock --}}
                                <td class="px-4 py-5 align-middle text-center">
                                    @if ((int)$p->stock > 0)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                            {{ $p->stock }} in stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">
                                            Out of stock
                                        </span>
                                    @endif
                                </td>

                                {{-- Price --}}
                                <td class="px-4 py-5 align-middle text-center">
                                    <div class="inline-flex items-baseline gap-1 font-bold text-slate-900 tabular-nums">
                                        <span class="text-xs text-slate-500">LKR</span>
                                        <span class="text-[18px] leading-none">{{ number_format((int)$p->price, 0) }}</span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-5 align-middle text-center">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('admin.products.edit', $p->id) }}"
                                           class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold transition">
                                            Update
                                        </a>
                                        <button
                                            x-data
                                            @click.prevent="if (confirm('Delete this product?')) { $wire.delete({{ $p->id }}) }"
                                            class="inline-flex items-center px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold transition">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-16 text-center">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                                    <p class="text-base text-gray-600">Try searching or add a new product.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{-- subtle spacer strip just below the table contents --}}
                    <div class="h-4 w-full bg-gradient-to-r from-slate-100 via-white to-slate-100 rounded-b-3xl border-t border-slate-200"></div>
                </div>

                {{-- Pagination --}}
                @if ($products->hasPages())
                    <div class="mt-10 border-t border-slate-200 pt-6">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <div>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</div>
                            <div>{{ $products->links() }}</div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</div>
