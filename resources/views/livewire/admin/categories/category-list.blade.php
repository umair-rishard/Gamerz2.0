{{-- Admin > Categories (GRID) --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">
            {{-- Header Section --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Categories</h1>
                    <p class="mt-2 text-base text-gray-600">Manage your product categories and inventory</p>
                </div>

                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium shadow-xl shadow-indigo-500/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Category
                </a>
            </div>

            {{-- Quick Stats (moved to top) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium">Total Categories</p>
                            <p class="text-3xl font-bold mt-2">{{ $categories->total() }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-xl shadow-emerald-500/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium">In Stock</p>
                            <p class="text-3xl font-bold mt-2">{{ $inStockCount ?? $categories->getCollection()->where('status', true)->count() }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-500 to-gray-700 rounded-3xl p-6 text-white shadow-xl shadow-gray-500/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-200 text-sm font-medium">Out of Stock</p>
                            <p class="text-3xl font-bold mt-2">{{ $outOfStockCount ?? $categories->getCollection()->where('status', false)->count() }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-50 via-green-50 to-teal-50 border border-emerald-200/50 p-5 shadow-lg shadow-emerald-100/50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-1">
                            <div class="p-2 bg-emerald-100 rounded-full">
                                <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-base font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                    <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 opacity-20 blur-3xl"></div>
                </div>
            @endif

            {{-- Controls + Grid --}}
<section class="rounded-3xl shadow-2xl p-8 bg-gray-50 text-slate-900 border border-blue-900/40">
                {{-- Search and Filters --}}
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
                    <div class="relative flex-1 max-w-3xl">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input
                        type="text"
                        placeholder="Search categories..."
                        class="w-full pl-12 pr-4 py-3 rounded-2xl border-2 border-blue-900 bg-white text-slate-900 placeholder-slate-400 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300"
                        wire:model.live="search"
                        />

                    </div>

                    <div class="flex items-center gap-3 px-5 py-2.5 bg-slate-900/100 text-slate-200 rounded-2xl border border-slate-700/60 backdrop-blur-md shadow-lg">
                    <span class="text-sm font-semibold">Show</span>
                    <select wire:model="perPage"
                        class="rounded-xl border border-slate-600 bg-slate-800/90 text-slate-200 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 transition-all duration-300">
                        <option class="text-black" value="10">10</option>
                        <option class="text-black" value="25">25</option>
                        <option class="text-black" value="50">50</option>
                    </select>
                    <span class="text-sm font-semibold">per page</span>
                    </div>

                </div>

                {{-- Categories Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($categories as $cat)
                        <div
                        class="group relative bg-white rounded-3xl border-2 border-gray-300 shadow-lg hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 overflow-hidden transform hover:-translate-y-1"
                        wire:key="cat-{{ $cat->id }}">
                        
                            {{-- Clickable area (image + title + stats) --}}
                            <a href="{{ route('admin.products.index', ['category' => $cat->id]) }}" class="block">
                                {{-- Category Image --}}
                                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50">
                                    @if ($cat->image_path)
                                        <img src="{{ asset('storage/'.$cat->image_path) }}"
                                             alt="{{ $cat->name }}"
                                             class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    @else
                                        <div class="h-full w-full flex items-center justify-center relative">
                                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 opacity-30"></div>
                                            <div class="p-10 rounded-3xl bg-white/60 backdrop-blur-sm shadow-inner">
                                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Status Badge --}}
                                    <div class="absolute top-4 right-4">
                                        @if ($cat->status)
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg shadow-emerald-500/30">
                                                <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse shadow-sm"></span>
                                                In Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg shadow-gray-500/30">
                                                <span class="w-2 h-2 bg-white/70 rounded-full mr-2"></span>
                                                Out of Stock
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Category Info (title + stats) --}}
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-1 group-hover:text-indigo-600 transition-colors duration-300">
                                        {{ $cat->name }}
                                    </h3>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 px-3 py-1.5 bg-indigo-50 rounded-xl">
                                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <span class="text-sm font-bold text-indigo-700">
                                                {{ $cat->products_count }} {{ Str::plural('product', $cat->products_count) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Actions (Edit & Delete only) --}}
                            <div class="px-6 pb-6">
                                <div class="flex items-center gap-3">
                                    <a
                                        href="{{ route('admin.categories.edit', $cat->id) }}"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 text-indigo-700 text-sm font-semibold transition-all duration-300 group/edit">
                                        <svg class="w-4 h-4 mr-2 group-hover/edit:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>

                                    <button
                                        x-data
                                        @click.prevent="if (confirm('Are you sure you want to delete this category?')) { $wire.delete({{ $cat->id }}) }"
                                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 text-red-700 text-sm font-semibold transition-all duration-300 group/delete">
                                        <svg class="w-4 h-4 mr-2 group-hover/delete:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-20 px-4">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No categories found</h3>
                                <p class="text-base text-gray-600 mb-8">Get started by creating your first category.</p>
                                <a href="{{ route('admin.categories.create') }}"
                                   class="inline-flex items-center px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-medium shadow-xl shadow-indigo-500/20 transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create Your First Category
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($categories->hasPages())
                    <div class="mt-12 border-t border-slate-700/40 pt-8">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-slate-300 font-medium">
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </main>
</div>
