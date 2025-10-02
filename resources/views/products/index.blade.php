{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white via-slate-50/40 to-white">
  {{-- Hero: banner image only (no text, no overlay) --}}
  <div class="relative overflow-hidden">
    <img
  src="{{ asset('storage/products/banner2.jpg') }}"
  alt="Products"
  class="w-full h-[300px] md:h-[500px] lg:h-[600px] object-cover"
  onerror="this.style.display='none'">
  </div>

  <div class="max-w-screen-2xl mx-auto px-4 lg:px-6 py-8">
    {{-- Stats Bar --}}
    <div class="mb-8 grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-300 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-black to-slate-800 flex items-center justify-center border border-black/60">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-slate-900" id="totalProducts">0</p>
            <p class="text-sm text-slate-500">Total Products</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-300 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-black to-slate-800 flex items-center justify-center border border-black/60">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-slate-900" id="totalCategories">0</p>
            <p class="text-sm text-slate-500">Categories</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-300 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-black to-slate-800 flex items-center justify-center border border-black/60">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-slate-900" id="avgPrice">Rs. 0</p>
            <p class="text-sm text-slate-500">Avg. Price</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-300 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-black to-slate-800 flex items-center justify-center border border-black/60">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <p class="text-2xl font-bold text-slate-900" id="inStockCount">0</p>
            <p class="text-sm text-slate-500">In Stock</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Filter Bar + Mobile Toggle --}}
    <div class="mb-6 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
      <div class="flex flex-wrap items-center gap-3">
        {{-- Quick filters --}}
        <button class="px-4 py-2 rounded-xl bg-white border border-slate-300 text-sm font-medium text-slate-900 hover:bg-slate-50 hover:border-slate-400 transition-all quick-filter" data-filter="all">
          All Products
        </button>
        <button class="px-4 py-2 rounded-xl bg-white border border-slate-300 text-sm font-medium text-slate-900 hover:bg-slate-50 hover:border-slate-400 transition-all quick-filter" data-filter="new">
          New Arrivals
        </button>
        <button class="px-4 py-2 rounded-xl bg-white border border-slate-300 text-sm font-medium text-slate-900 hover:bg-slate-50 hover:border-slate-400 transition-all quick-filter" data-filter="sale">
          On Sale
        </button>
      </div>

      <div class="flex items-center gap-3">
        {{-- View mode toggles (Desktop) --}}
        <div class="hidden lg:flex items-center bg-white rounded-xl border border-slate-300 p-1">
          <button id="gridView" class="p-2 rounded-lg bg-black text-white">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
          </button>
          <button id="listView" class="p-2 rounded-lg text-slate-700 hover:bg-slate-100">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>

        {{-- Mobile controls: Filters + View toggle --}}
        <div class="lg:hidden flex items-center gap-2">
          <button id="openFiltersBtn"
                  class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-black text-white font-medium shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
              <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Filters
          </button>

          <div class="inline-flex items-center bg-white rounded-xl border border-slate-300 p-1">
            <button id="gridView_m" class="p-2 rounded-lg bg-black text-white">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
              </svg>
            </button>
            <button id="listView_m" class="p-2 rounded-lg text-slate-700 hover:bg-slate-100">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- ================= FILTERS SIDEBAR ================= --}}
      <aside class="lg:col-span-3">
        {{-- Desktop Filters --}}
        <div class="hidden lg:block sticky top-20">
          <div class="bg-white rounded-2xl shadow-sm border border-slate-300 overflow-hidden">
            {{-- Filter Header (black) --}}
            <div class="px-5 py-4 bg-gradient-to-r from-black to-slate-800 border-b border-black/70">
              <h3 class="font-semibold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span>Filter Products</span>
              </h3>
            </div>

            <div class="p-5 space-y-6">
              {{-- Search --}}
              <div>
                <label class="text-sm font-semibold text-black mb-2 block">Search Products</label>
                <div class="relative">
                  <input id="qInput" type="text" placeholder="Type to search..."
                         class="w-full pl-10 pr-4 py-2.5 rounded-xl border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-black focus:border-transparent transition-all">
                  <svg class="absolute left-3 top-3 w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </div>
              </div>

              {{-- Categories --}}
              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Categories</label>
                <div id="categoryList" class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                  <div class="animate-pulse space-y-2">
                    <div class="h-8 bg-slate-100 rounded-lg"></div>
                    <div class="h-8 bg-slate-100 rounded-lg"></div>
                    <div class="h-8 bg-slate-100 rounded-lg"></div>
                  </div>
                </div>
              </div>

              {{-- Price Range (visible dual sliders) --}}
              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Price Range</label>
                <div class="space-y-4">
                  <div class="space-y-2">
                    <input id="priceMinRange" type="range" min="0" max="0" value="0" class="w-full accent-black">
                    <input id="priceMaxRange" type="range" min="0" max="0" value="0" class="w-full accent-black">
                  </div>
                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <label class="text-xs text-slate-600 mb-1 block">Min Price</label>
                      <input id="minPrice" type="number" min="0"
                             class="w-full px-3 py-2 rounded-lg border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-black text-sm"
                             placeholder="Rs. 0">
                    </div>
                    <div>
                      <label class="text-xs text-slate-600 mb-1 block">Max Price</label>
                      <input id="maxPrice" type="number" min="0"
                             class="w-full px-3 py-2 rounded-lg border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-black text-sm"
                             placeholder="Rs. 0">
                    </div>
                  </div>
                  <div class="flex items-center justify-between">
                    <span id="priceBadge" class="text-xs text-slate-800 font-medium"></span>
                    <button id="clearPrice" class="text-xs text-black hover:opacity-80 font-medium">Clear</button>
                  </div>
                </div>
              </div>

              {{-- Availability --}}
              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Availability</label>
                <div class="space-y-3">
                  <label class="flex items-center gap-3 cursor-pointer group">
                    <input id="inStockCb" type="checkbox"
                           class="w-5 h-5 rounded-lg border-slate-300 bg-white text-black focus:ring-black focus:ring-offset-0 transition-all">
                    <span class="text-sm text-slate-800 group-hover:text-black">In Stock</span>
                  </label>
                  <label class="flex items-center gap-3 cursor-pointer group">
                    <input id="outStockCb" type="checkbox"
                           class="w-5 h-5 rounded-lg border-slate-300 bg-white text-black focus:ring-black focus:ring-offset-0 transition-all">
                    <span class="text-sm text-slate-800 group-hover:text-black">Out of Stock</span>
                  </label>
                </div>
              </div>

              {{-- Sort Options --}}
              <div>
                <label for="sortSelect" class="text-sm font-semibold text-black mb-2 block">Sort By</label>
                <select id="sortSelect"
                        class="w-full px-3 py-2.5 rounded-xl border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-black text-sm">
                  <option value="new">Newest First</option>
                  <option value="popular">Most Popular</option>
                  <option value="price_asc">Price: Low to High</option>
                  <option value="price_desc">Price: High to Low</option>
                  <option value="name_asc">Name: A to Z</option>
                  <option value="name_desc">Name: Z to A</option>
                </select>
              </div>

              {{-- Action Buttons --}}
              <div class="flex gap-3 pt-2">
                <button id="applyBtn"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-black text-white font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                  Apply Filters
                </button>
                <button id="resetBtn"
                        class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-900 font-medium hover:bg-slate-50 transition-all">
                  Reset
                </button>
              </div>
            </div>
          </div>
        </div>

        {{-- Mobile Filters Panel --}}
        <div id="filtersPanel"
             class="lg:hidden fixed left-0 top-0 z-50 w-full max-w-sm h-full bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 border-r border-slate-300">
          <div class="h-full flex flex-col">
            {{-- Header --}}
            <div class="px-5 py-4 bg-gradient-to-r from-black to-slate-800 text-white border-b border-black/70">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Filter Products</h3>
                <button id="closeFiltersBtn" class="p-2 rounded-lg hover:bg-white/10 transition-colors">
                  <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                    <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </button>
              </div>
            </div>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto p-5 space-y-6">
              {{-- Mobile filter controls (similar to desktop) --}}
              <div>
                <label class="text-sm font-semibold text-black mb-2 block">Search</label>
                <input id="qInput_m" type="text" placeholder="Search products..."
                       class="w-full px-4 py-2.5 rounded-xl border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-black">
              </div>

              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Categories</label>
                <div id="categoryList_m" class="space-y-2"></div>
              </div>

              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Price Range</label>
                <div class="space-y-4">
                  <input id="priceMinRange_m" type="range" min="0" max="0" value="0" class="w-full accent-black">
                  <input id="priceMaxRange_m" type="range" min="0" max="0" value="0" class="w-full accent-black">
                  <div class="grid grid-cols-2 gap-3">
                    <input id="minPrice_m" type="number" placeholder="Min"
                           class="px-3 py-2 rounded-lg border-slate-300 bg-slate-50 text-slate-900 text-sm focus:bg-white focus:ring-2 focus:ring-black">
                    <input id="maxPrice_m" type="number" placeholder="Max"
                           class="px-3 py-2 rounded-lg border-slate-300 bg-slate-50 text-slate-900 text-sm focus:bg-white focus:ring-2 focus:ring-black">
                  </div>
                  <div class="flex justify-between">
                    <span id="priceBadge_m" class="text-xs text-slate-800"></span>
                    <button id="clearPrice_m" class="text-xs text-black font-medium">Clear</button>
                  </div>
                </div>
              </div>

              <div>
                <label class="text-sm font-semibold text-black mb-3 block">Availability</label>
                <div class="space-y-3">
                  <label class="flex items-center gap-3">
                    <input id="inStockCb_m" type="checkbox" class="w-5 h-5 rounded-lg bg-white border-slate-300 text-black focus:ring-black">
                    <span class="text-sm text-slate-800">In Stock</span>
                  </label>
                  <label class="flex items-center gap-3">
                    <input id="outStockCb_m" type="checkbox" class="w-5 h-5 rounded-lg bg-white border-slate-300 text-black focus:ring-black">
                    <span class="text-sm text-slate-800">Out of Stock</span>
                  </label>
                </div>
              </div>

              <div>
                <label class="text-sm font-semibold text-black mb-2 block">Sort By</label>
                <select id="sortSelect_m" class="w-full px-3 py-2.5 rounded-xl border-slate-300 bg-slate-50 text-slate-900 text-sm focus:bg-white focus:ring-2 focus:ring-black">
                  <option value="new">Newest First</option>
                  <option value="popular">Most Popular</option>
                  <option value="price_asc">Price: Low to High</option>
                  <option value="price_desc">Price: High to Low</option>
                  <option value="name_asc">Name: A to Z</option>
                  <option value="name_desc">Name: Z to A</option>
                </select>
              </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-5 bg-slate-50 border-t border-slate-300">
              <div class="flex gap-3">
                <button id="applyBtn_m"
                        class="flex-1 px-4 py-3 rounded-xl bg-black text-white font-medium shadow-lg">
                  Apply Filters
                </button>
                <button id="resetBtn_m"
                        class="px-6 py-3 rounded-xl bg-white border border-slate-300 text-slate-900 font-medium">
                  Reset
                </button>
              </div>
            </div>
          </div>
        </div>
        <div id="filtersBackdrop" class="lg:hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden"></div>
      </aside>

      {{-- ================= PRODUCTS GRID ================= --}}
      <section class="lg:col-span-9">
        {{-- Results Bar --}}
        <div class="mb-6 flex items-center justify-between bg-white rounded-xl px-4 py-3 shadow-sm border border-slate-300">
          <div class="flex items-center gap-4">
            <p id="resultsCount" class="text-sm font-medium text-slate-700">Loading products...</p>
            <div id="activeFilters" class="flex items-center gap-2"></div>
          </div>

          <div class="hidden lg:flex items-center gap-3">
            <label class="text-sm text-slate-600">Sort:</label>
            <select id="sortSelectTop"
                    class="px-3 py-1.5 rounded-lg border-slate-300 bg-slate-50 text-slate-900 text-sm focus:ring-2 focus:ring-black">
              <option value="new">Newest</option>
              <option value="popular">Popular</option>
              <option value="price_asc">Price ↑</option>
              <option value="price_desc">Price ↓</option>
            </select>
          </div>
        </div>

        {{-- Loading State --}}
        <div id="loadingGrid" class="hidden">
          <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5">
            @for($i = 0; $i < 8; $i++)
            <div class="animate-pulse">
              <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-300">
                <div class="h-64 bg-slate-100"></div>
                <div class="p-4 space-y-3">
                  <div class="h-4 bg-slate-100 rounded-lg"></div>
                  <div class="h-3 bg-slate-100 rounded-lg w-2/3"></div>
                  <div class="h-6 bg-slate-100 rounded-lg w-1/2"></div>
                </div>
              </div>
            </div>
            @endfor
          </div>
        </div>

        {{-- Products Grid --}}
        <div id="productsGrid" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5"></div>

        {{-- Pagination --}}
        <div id="pagination" class="mt-8 flex items-center justify-center gap-2"></div>

        {{-- Empty State --}}
        <div id="emptyBox" class="hidden">
          <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 border border-slate-300 flex items-center justify-center mb-4">
              <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-black mb-2">No products found</h3>
            <p class="text-slate-500 mb-6">Try adjusting your filters or search terms</p>
            <button onclick="document.getElementById('resetBtn').click()"
                    class="px-6 py-2.5 rounded-xl bg-black text-white font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
              Clear All Filters
            </button>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

{{-- Quick View Modal --}}
<div id="quickViewModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    {{-- Clicking the backdrop now closes the modal --}}
    <div class="fixed inset-0 transition-opacity bg-black/60 backdrop-blur-sm" onclick="closeQuickView()"></div>
    <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white border border-slate-300 shadow-2xl rounded-2xl">
      <div id="quickViewContent"></div>
    </div>
  </div>
</div>

<style>
  .custom-scrollbar::-webkit-scrollbar { width: 6px; }
  .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
  .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
  .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

  @keyframes slideUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-slideup { animation: slideUp 0.3s ease-out; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* === the rest of your JS stays exactly the same === */
document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("auth_token");

  const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: { Authorization: token ? `Bearer ${token}` : undefined, Accept: "application/json" }
  });

  // DOM Elements
  const grid = document.getElementById("productsGrid");
  const emptyBox = document.getElementById("emptyBox");
  const resultsCount = document.getElementById("resultsCount");
  const pagination = document.getElementById("pagination");
  const loadingGrid = document.getElementById("loadingGrid");
  const activeFilters = document.getElementById("activeFilters");

  // Desktop refs
  const qInput = document.getElementById("qInput");
  const catList = document.getElementById("categoryList");
  const inStockCb = document.getElementById("inStockCb");
  const outStockCb = document.getElementById("outStockCb");
  const minPrice = document.getElementById("minPrice");
  const maxPrice = document.getElementById("maxPrice");
  const clearPriceBtn = document.getElementById("clearPrice");
  const sortSelect = document.getElementById("sortSelect");
  const sortSelectTop = document.getElementById("sortSelectTop");
  const priceMinRange = document.getElementById("priceMinRange");
  const priceMaxRange = document.getElementById("priceMaxRange");
  const priceBadge = document.getElementById("priceBadge");
  const applyBtn = document.getElementById("applyBtn");
  const resetBtn = document.getElementById("resetBtn");

  // Mobile refs
  const filtersPanel = document.getElementById("filtersPanel");
  const filtersBackdrop = document.getElementById("filtersBackdrop");
  const openFiltersBtn = document.getElementById("openFiltersBtn");
  const closeFiltersBtn = document.getElementById("closeFiltersBtn");
  const qInput_m = document.getElementById("qInput_m");
  const catList_m = document.getElementById("categoryList_m");
  const inStockCb_m = document.getElementById("inStockCb_m");
  const outStockCb_m = document.getElementById("outStockCb_m");
  const minPrice_m = document.getElementById("minPrice_m");
  const maxPrice_m = document.getElementById("maxPrice_m");
  const clearPrice_m = document.getElementById("clearPrice_m");
  const sortSelect_m = document.getElementById("sortSelect_m");
  const priceBadge_m = document.getElementById("priceBadge_m");
  const applyBtn_m = document.getElementById("applyBtn_m");
  const resetBtn_m = document.getElementById("resetBtn_m");

  // Mobile view toggles
  const gridView_m = document.getElementById('gridView_m');
  const listView_m = document.getElementById('listView_m');

  // Desktop view toggles
  const gridView = document.getElementById('gridView');
  const listView = document.getElementById('listView');

  // State
  let allProducts = [];
  let filtered = [];
  let activeCats = new Set();
  let itemsPerPage = 12;
  let currentPage = 1;
  let priceMaxAbs = 0;
  let viewMode = 'grid';

  // Mobile panel
  const openFilters = () => { 
    filtersPanel.classList.remove("-translate-x-full"); 
    filtersBackdrop.classList.remove("hidden"); 
    document.body.style.overflow = 'hidden'; 
  };
  const closeFilters = () => { 
    filtersPanel.classList.add("-translate-x-full"); 
    filtersBackdrop.classList.add("hidden"); 
    document.body.style.overflow = ''; 
  };

  openFiltersBtn?.addEventListener("click", openFilters);
  closeFiltersBtn?.addEventListener("click", closeFilters);
  filtersBackdrop?.addEventListener("click", closeFilters);

  // ESC to close Quick View
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeQuickView();
  });

  // View mode toggle
  gridView?.addEventListener('click', () => setViewMode('grid'));
  listView?.addEventListener('click', () => setViewMode('list'));
  gridView_m?.addEventListener('click', () => setViewMode('grid'));
  listView_m?.addEventListener('click', () => setViewMode('list'));

  function setViewMode(mode) {
    viewMode = mode;
    if (gridView && listView) {
      gridView.classList.toggle('bg-black', mode === 'grid');
      gridView.classList.toggle('text-white', mode === 'grid');
      gridView.classList.toggle('text-slate-700', mode !== 'grid');
      listView.classList.toggle('bg-black', mode === 'list');
      listView.classList.toggle('text-white', mode === 'list');
      listView.classList.toggle('text-slate-700', mode !== 'list');
    }
    if (gridView_m && listView_m) {
      gridView_m.classList.toggle('bg-black', mode === 'grid');
      gridView_m.classList.toggle('text-white', mode === 'grid');
      gridView_m.classList.toggle('text-slate-700', mode !== 'grid');
      listView_m.classList.toggle('bg-black', mode === 'list');
      listView_m.classList.toggle('text-white', mode === 'list');
      listView_m.classList.toggle('text-slate-700', mode !== 'list');
    }
    render();
  }

  const money = (v) => Number(String(v ?? 0).replace(/,/g,'')).toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  const escapeHtml = (s) => String(s ?? "").replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));

  function loadProducts() {
    loadingGrid.classList.remove('hidden');
    grid.innerHTML = '';
    
    api.get("/products", { params: { per_page: 500 } })
      .then(res => {
        allProducts = (res.data.data ?? res.data) || [];
        document.getElementById('totalProducts').textContent = allProducts.length;
        const categories = [...new Set(allProducts.map(p => p.category).filter(Boolean))];
        document.getElementById('totalCategories').textContent = categories.length;
        const inStock = allProducts.filter(p => Number(p.stock) > 0).length;
        document.getElementById('inStockCount').textContent = inStock;
        const avgPrice = allProducts.reduce((sum, p) => sum + Number(p.price || 0), 0) / (allProducts.length || 1);
        document.getElementById('avgPrice').textContent = `Rs. ${money(avgPrice)}`;
        
        priceMaxAbs = Math.ceil(Math.max(0, ...allProducts.map(p => Number(p.price) || 0)));
        setupPriceRanges(priceMaxAbs);
        buildCategories(allProducts);
        buildCategories(allProducts, true);
        syncFromDesktopToMobile();
        applyFilters();
        loadingGrid.classList.add('hidden');
      })
      .catch(() => {
        loadingGrid.classList.add('hidden');
        grid.innerHTML = `<p class="col-span-full text-center text-red-500">Error loading products</p>`;
      });
  }

  loadProducts();

  function setupPriceRanges(max) {
    [priceMinRange, priceMinRange_m].forEach(r => { if(!r) return; r.min = 0; r.max = max; r.value = 0; });
    [priceMaxRange, priceMaxRange_m].forEach(r => { if(!r) return; r.min = 0; r.max = max; r.value = max; });
    updatePriceBadges();
  }

  function updatePriceBadges() {
    const a = Number(minPrice.value || priceMinRange?.value || 0);
    const b = Number(maxPrice.value || priceMaxRange?.value || priceMaxAbs);
    const text = `Rs. ${money(a)} - ${money(b)}`;
    if (priceBadge) priceBadge.textContent = text;
    if (priceBadge_m) priceBadge_m.textContent = text;
  }

  function buildCategories(items, mobile = false) {
    const cats = [...new Set(items.map(p => p.category).filter(Boolean))].sort();
    const target = mobile ? catList_m : catList;
    target.innerHTML = "";
    
    cats.forEach((c, i) => {
      const count = items.filter(p => p.category === c).length;
      const id = (mobile ? 'm_' : '') + `cat_${i}`;
      const row = document.createElement("label");
      row.className = "flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors border border-slate-300";
      row.innerHTML = `
        <div class="flex items-center gap-3">
          <input type="checkbox" data-cat="${c}" id="${id}"
                 class="w-4 h-4 rounded border-slate-400 bg-white text-black focus:ring-black focus:ring-offset-0">
          <span class="text-sm text-slate-900">${escapeHtml(c)}</span>
        </div>
        <span class="text-xs text-slate-700 bg-slate-100 px-2 py-1 rounded-full border border-slate-300">${count}</span>`;
      row.querySelector("input").addEventListener("change", (e) => {
        const val = e.target.getAttribute("data-cat");
        if (e.target.checked) activeCats.add(val); else activeCats.delete(val);
        syncBetweenPanels(mobile);
        applyFilters();
      });
      target.appendChild(row);
    });
  }

  function syncBetweenPanels(fromMobile) {
    const getChecks = (root) => [...root.querySelectorAll('input[type=checkbox][data-cat]')];
    const dCbs = getChecks(catList);
    const mCbs = getChecks(catList_m);
    const setChecked = (list) => list.forEach(cb => cb.checked = activeCats.has(cb.getAttribute('data-cat')));
    setChecked(dCbs); 
    setChecked(mCbs);

    if (fromMobile) {
      qInput.value = qInput_m.value;
      inStockCb.checked = inStockCb_m.checked;
      outStockCb.checked = outStockCb_m.checked;
      minPrice.value = minPrice_m.value; 
      maxPrice.value = maxPrice_m.value;
      priceMinRange.value = priceMinRange_m.value; 
      priceMaxRange.value = priceMaxRange_m.value;
      sortSelect.value = sortSelect_m.value;
      sortSelectTop.value = sortSelect_m.value;
    } else {
      qInput_m.value = qInput.value;
      inStockCb_m.checked = inStockCb.checked;
      outStockCb_m.checked = outStockCb.checked;
      minPrice_m.value = minPrice.value; 
      maxPrice_m.value = maxPrice.value;
      priceMinRange_m.value = priceMinRange.value; 
      priceMaxRange_m.value = priceMaxRange.value;
      sortSelect_m.value = sortSelect.value;
    }
    updatePriceBadges();
  }
  
  function syncFromDesktopToMobile(){ syncBetweenPanels(false); }

  qInput.addEventListener("input", () => { qInput_m.value = qInput.value; applyFilters(); });
  [inStockCb, outStockCb].forEach(cb => cb.addEventListener("change", () => { syncFromDesktopToMobile(); applyFilters(); }));
  clearPriceBtn.addEventListener("click", () => { 
    minPrice.value = ""; 
    maxPrice.value = ""; 
    priceMinRange.value = 0; 
    priceMaxRange.value = priceMaxAbs; 
    syncFromDesktopToMobile(); 
    applyFilters(); 
  });
  applyBtn.addEventListener("click", () => applyFilters());
  resetBtn.addEventListener("click", () => resetAll(false));
  sortSelect.addEventListener("change", () => { 
    sortSelectTop.value = sortSelect.value; 
    sortSelect_m.value = sortSelect.value; 
    applyFilters(); 
  });
  sortSelectTop.addEventListener("change", () => { 
    sortSelect.value = sortSelectTop.value; 
    sortSelect_m.value = sortSelectTop.value; 
    applyFilters(); 
  });
  
  priceMinRange.addEventListener("input", () => { 
    if(Number(priceMinRange.value) > Number(priceMaxRange.value)) priceMinRange.value = priceMaxRange.value; 
    minPrice.value = priceMinRange.value; 
    syncFromDesktopToMobile(); 
    updatePriceBadges(); 
  });
  priceMaxRange.addEventListener("input", () => { 
    if(Number(priceMaxRange.value) < Number(priceMinRange.value)) priceMaxRange.value = priceMinRange.value; 
    maxPrice.value = priceMaxRange.value; 
    syncFromDesktopToMobile(); 
    updatePriceBadges(); 
  });
  [minPrice, maxPrice].forEach(el => el.addEventListener("input", () => { 
    priceMinRange.value = minPrice.value || 0; 
    priceMaxRange.value = maxPrice.value || priceMaxAbs; 
    syncFromDesktopToMobile(); 
    updatePriceBadges(); 
  }));

  qInput_m.addEventListener("input", () => { qInput.value = qInput_m.value; applyFilters(); });
  [inStockCb_m, outStockCb_m].forEach(cb => cb.addEventListener("change", () => { 
    inStockCb.checked = inStockCb_m.checked; 
    outStockCb.checked = outStockCb_m.checked; 
    applyFilters(); 
  }));
  clearPrice_m.addEventListener("click", () => { 
    minPrice_m.value = ""; 
    maxPrice_m.value = ""; 
    priceMinRange_m.value = 0; 
    priceMaxRange_m.value = priceMaxAbs; 
    minPrice.value = ""; 
    maxPrice.value = ""; 
    applyFilters(); 
  });
  applyBtn_m.addEventListener("click", () => { closeFilters(); applyFilters(); });
  resetBtn_m.addEventListener("click", () => resetAll(true));
  sortSelect_m.addEventListener("change", () => { 
    sortSelect.value = sortSelect_m.value; 
    sortSelectTop.value = sortSelect_m.value; 
    applyFilters(); 
  });

  document.querySelectorAll('.quick-filter').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const filter = e.currentTarget.dataset.filter;
      resetAll(false);
      if (filter === 'new') {
        sortSelect.value = 'new';
        sortSelectTop.value = 'new';
        sortSelect_m.value = 'new';
      } else if (filter === 'sale') {
        // optional sale logic
      }
      applyFilters();
    });
  });

  function resetAll(fromMobile){
    qInput.value = qInput_m.value = "";
    inStockCb.checked = inStockCb_m.checked = false;
    outStockCb.checked = outStockCb_m.checked = false;
    minPrice.value = maxPrice.value = ""; 
    minPrice_m.value = maxPrice_m.value = "";
    priceMinRange.value = priceMinRange_m.value = 0;
    priceMaxRange.value = priceMaxRange_m.value = priceMaxAbs;
    sortSelect.value = sortSelectTop.value = sortSelect_m.value = "new";
    activeCats.clear();
    [catList, catList_m].forEach(root => root.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false));
    if (fromMobile) closeFilters();
    applyFilters();
  }

  function applyFilters() {
    const q = (qInput.value || "").trim().toLowerCase();
    const min = Number(minPrice.value || priceMinRange.value || 0);
    const max = Number(maxPrice.value || priceMaxRange.value || priceMaxAbs);
    const sort = sortSelect.value || "new";
    const wantIn = inStockCb.checked;
    const wantOut = outStockCb.checked;

    let items = allProducts.slice();

    if (q) {
      items = items.filter(p =>
        (p.name || "").toLowerCase().includes(q) ||
        (p.description || "").toLowerCase().includes(q) ||
        (p.category || "").toLowerCase().includes(q)
      );
    }
    if (activeCats.size) items = items.filter(p => activeCats.has(p.category));
    if (wantIn && !wantOut) items = items.filter(p => Number(p.stock) > 0);
    if (!wantIn && wantOut) items = items.filter(p => Number(p.stock) <= 0);
    items = items.filter(p => {
      const price = Number(p.price) || 0;
      return price >= min && price <= max;
    });

    items.sort((a,b) => {
      switch (sort) {
        case "price_asc":  return Number(a.price) - Number(b.price);
        case "price_desc": return Number(b.price) - Number(a.price);
        case "name_asc":   return String(a.name).localeCompare(String(b.name));
        case "name_desc":  return String(b.name).localeCompare(String(a.name));
        case "popular":    return Number(b.views || 0) - Number(a.views || 0);
        default:           return new Date(b.created_at || 0) - new Date(a.created_at || 0);
      }
    });

    filtered = items;
    currentPage = 1;
    showActiveFilters();
    render();
  }

  function showActiveFilters() {
    activeFilters.innerHTML = '';
    const filters = [];
    
    if (qInput.value) filters.push({ label: `"${qInput.value}"`, key: 'search' });
activeCats.forEach(cat => filters.push({ label: cat, key: 'category' }));
    if (inStockCb.checked) filters.push({ label: 'In Stock', key: 'stock' });
    if (outStockCb.checked) filters.push({ label: 'Out of Stock', key: 'stock' });
    
    filters.forEach(f => {
      const tag = document.createElement('span');
      tag.className = 'inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 border border-slate-300 text-slate-800 text-xs font-medium';
      tag.innerHTML = `
        ${escapeHtml(f.label)}
        <button onclick="removeFilter('${f.key}', '${f.label}')" class="ml-1 hover:opacity-80">
          <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      `;
      activeFilters.appendChild(tag);
    });
  }

  window.removeFilter = function(key, value) {
    if (key === 'search') qInput.value = qInput_m.value = '';
    else if (key === 'category') activeCats.delete(value);
    else if (key === 'stock' && value === 'In Stock') inStockCb.checked = inStockCb_m.checked = false;
    else if (key === 'stock' && value === 'Out of Stock') outStockCb.checked = outStockCb_m.checked = false;
    syncFromDesktopToMobile();
    applyFilters();
  };

  function render() {
    const total = filtered.length;
    resultsCount.textContent = total === 0 ? 'No products found' : `${total} product${total === 1 ? "" : "s"} found`;
    emptyBox.classList.toggle("hidden", total !== 0);

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageItems = filtered.slice(start, end);

    grid.innerHTML = "";
    grid.className = viewMode === 'list' ? 'space-y-4' : 'grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-5';
    
    pageItems.forEach((product, index) => {
      const imageUrl = product.image_url || `/${product.image_path || ''}`;
      const inStock = Number(product.stock) > 0;
      const rating = Math.floor(Math.random() * 2) + 3.5;

      const onCardClick = `window.location.href='/products/${product.id}'`;
      const stop = "event.stopPropagation(); event.preventDefault();";
      
      const card = viewMode === 'grid' ? `
        <div onclick="${onCardClick}" class="group bg-white rounded-2xl shadow-sm border border-slate-300 hover:shadow-lg hover:border-black transition-all duration-300 overflow-hidden animate-slideup cursor-pointer" style="animation-delay: ${index * 50}ms">
          <div class="relative h-64 lg:h-72 bg-gradient-to-br from-slate-50 to-white overflow-hidden">
            <img src="${imageUrl}" alt="${escapeHtml(product.name)}"
                 class="w-full h-full object-contain transition duration-500 group-hover:scale-110"
                 onerror="this.src='https://via.placeholder.com/400x400/f1f5f9/64748b?text=No+Image'">
            <div class="absolute top-3 left-3 flex flex-col gap-2">
              ${inStock ? '' : '<span class="px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded-lg">Out of Stock</span>'}
              ${Math.random() > 0.7 ? '<span class="px-2 py-1 bg-black text-white text-xs font-semibold rounded-lg">New</span>' : ''}
            </div>
            <button onclick="${stop} quickView(${product.id})" class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white border border-slate-300 shadow">
              <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          
          <div class="p-4">
            <div class="flex items-center gap-1 mb-2">
              ${[...Array(5)].map((_, i) => `
                <svg class="w-4 h-4 ${i < Math.floor(rating) ? 'text-yellow-400' : 'text-slate-200'}" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              `).join('')}
              <span class="text-xs text-slate-500 ml-1">(${rating})</span>
            </div>
            
            <h3 class="font-semibold text-slate-900 line-clamp-2 group-hover:text-black transition-colors">
              ${escapeHtml(product.name)}
            </h3>
            
            <p class="mt-1 text-sm text-slate-500">${escapeHtml(product.category || 'Uncategorized')}</p>
            
            <div class="mt-3 flex items-center justify-between">
              <div>
                <p class="text-xl font-extrabold text-black">
                  Rs. ${money(product.price)}
                </p>
                ${Math.random() > 0.5 ? `<p class="text-xs text-slate-400 line-through">Rs. ${money(product.price * 1.2)}</p>` : ''}
              </div>
            </div>
            
            <div class="mt-4 flex gap-2">
              <button onclick="${stop} addToCart(${product.id})"
                      class="w-11 h-11 rounded-xl bg-green-600 text-white border border-green-600 flex items-center justify-center shadow-lg hover:shadow-green-200 hover:-translate-y-0.5 transition transform">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </button>
              <button onclick="${stop} addToWishlist(${product.id})"
                      class="w-11 h-11 rounded-xl border border-slate-300 hover:border-black hover:bg-slate-50 flex items-center justify-center transition-all group">
                <svg class="w-5 h-5 text-slate-700 group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      ` : `
        <div onclick="${onCardClick}" class="bg-white rounded-2xl shadow-sm border border-slate-300 hover:border-black hover:shadow-lg transition-all p-4 animate-slideup cursor-pointer" style="animation-delay: ${index * 50}ms">
          <div class="flex gap-4">
            <img src="${imageUrl}" alt="${escapeHtml(product.name)}"
                 class="w-32 h-32 object-contain rounded-xl bg-slate-50 border border-slate-300"
                 onerror="this.src='https://via.placeholder.com/400x400/f1f5f9/64748b?text=No+Image'">
            <div class="flex-1">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="font-semibold text-lg text-slate-900 group-hover:text-black transition-colors">
                    ${escapeHtml(product.name)}
                  </h3>
                  <p class="text-sm text-slate-500 mt-1">${escapeHtml(product.category || 'Uncategorized')}</p>
                  <div class="flex items-center gap-1 mt-2">
                    ${[...Array(5)].map((_, i) => `
                      <svg class="w-4 h-4 ${i < Math.floor(rating) ? 'text-yellow-400' : 'text-slate-200'}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                    `).join('')}
                    <span class="text-xs text-slate-500 ml-1">(${rating})</span>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-xl font-extrabold text-black">Rs. ${money(product.price)}</p>
                  ${Math.random() > 0.5 ? `<p class="text-xs text-slate-400 line-through">Rs. ${money(product.price * 1.2)}</p>` : ''}
                </div>
              </div>
              <div class="mt-4 flex gap-2">
                <button onclick="${stop} addToCart(${product.id})"
                        class="w-11 h-11 rounded-xl bg-green-600 text-white border border-green-600 flex items-center justify-center">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                </button>
                <button onclick="${stop} addToWishlist(${product.id})"
                        class="w-11 h-11 rounded-xl border border-slate-300 hover:border-black hover:bg-slate-50 flex items-center justify-center">
                  <svg class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                </button>
                <button onclick="${stop} quickView(${product.id})"
                        class="w-11 h-11 rounded-xl border border-slate-300 hover:border-black hover:bg-slate-50 flex items-center justify-center">
                  <svg class="w-5 h-5 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      
      grid.insertAdjacentHTML("beforeend", card);
    });

    renderPagination(total);
  }

  function renderPagination(totalItems) {
    const totalPages = Math.max(1, Math.ceil(totalItems / itemsPerPage));
    pagination.innerHTML = "";
    if (totalPages <= 1) return;

    const makeBtn = (label, disabled, active, onClick) => {
      const btn = document.createElement('button');
      btn.className = active 
        ? "px-4 py-2 rounded-lg bg-black text-white font-medium shadow-lg"
        : disabled 
          ? "px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-400 cursor-not-allowed"
          : "px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-all";
      btn.innerHTML = label;
      if (!disabled && !active) btn.addEventListener('click', onClick);
      return btn;
    };

    pagination.appendChild(makeBtn('← Previous', currentPage === 1, false, () => { currentPage--; render(); }));

    const pages = [];
    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
        pages.push(i);
      }
    }

    let lastPage = 0;
    pages.forEach(page => {
      if (page - lastPage > 1) {
        const dots = document.createElement('span');
        dots.className = 'px-2 text-slate-400';
        dots.textContent = '…';
        pagination.appendChild(dots);
      }
      pagination.appendChild(makeBtn(String(page), false, page === currentPage, () => { currentPage = page; render(); }));
      lastPage = page;
    });

    pagination.appendChild(makeBtn('Next →', currentPage === totalPages, false, () => { currentPage++; render(); }));
  }

  window.quickView = function(id) {
    const product = allProducts.find(p => p.id === id);
    if (!product) return;
    
    const modal = document.getElementById('quickViewModal');
    const content = document.getElementById('quickViewContent');
    
    content.innerHTML = `
      <div class="flex flex-col lg:flex-row gap-6 p-6">
        <div class="lg:w-1/2">
          <img src="${product.image_url || `/${product.image_path || ''}`}" 
               alt="${escapeHtml(product.name)}"
               class="w-full h-96 object-contain bg-slate-50 border border-slate-300 rounded-xl"
               onerror="this.src='https://via.placeholder.com/400x400/f1f5f9/64748b?text=No+Image'">
        </div>
        <div class="lg:w-1/2">
          <h2 class="text-2xl font-bold text-black mb-2">${escapeHtml(product.name)}</h2>
          <p class="text-slate-600 mb-4">${escapeHtml(product.category || 'Uncategorized')}</p>
          <p class="text-2xl font-extrabold text-black mb-4">
            Rs. ${money(product.price)}
          </p>
          <p class="text-slate-700 mb-6">${escapeHtml(product.description || 'No description available.')}</p>
          <div class="flex gap-3">
            <button onclick="addToCart(${product.id}); closeQuickView();" 
                    class="flex-1 px-6 py-3 rounded-xl bg-green-600 text-white font-medium shadow-lg">
              <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Add
              </span>
            </button>
            <a href="/products/${product.id}" 
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-900 font-medium hover:bg-slate-50 text-center">
              View Details
            </a>
          </div>
        </div>
      </div>
    `;
    
    modal.classList.remove('hidden');
  };
  
  window.closeQuickView = function() {
    document.getElementById('quickViewModal').classList.add('hidden');
  };

  window.addToCart = function (id) {
    if (!token) { 
      Swal.fire({ 
        icon: "info", 
        title: "Please log in", 
        text: "You need to login to add items to cart.",
        confirmButtonColor: '#16a34a',
        background: '#ffffff',
        color: '#111827'
      }); 
      return; 
    }
    
    api.post("/cart", { product_id: id, quantity: 1 })
      .then(() => { 
        const cartIcon = document.getElementById('cartCount');
        if (cartIcon) {
          const current = parseInt(cartIcon.textContent) || 0;
          cartIcon.textContent = current + 1;
          cartIcon.classList.add('animate-bounce');
          setTimeout(() => cartIcon.classList.remove('animate-bounce'), 1000);
        }
        
        Swal.fire({ 
          icon: "success", 
          title: "Added to Cart!", 
          showConfirmButton: false, 
          timer: 1500,
          position: 'top-end',
          toast: true,
          background: '#ffffff',
          color: '#065f46'
        }); 
      })
      .catch(err => {
        Swal.fire({ 
          icon: "error", 
          title: "Failed", 
          text: err.response?.data?.message || "Could not add product to cart",
          confirmButtonColor: '#16a34a',
          background: '#ffffff',
          color: '#991b1b'
        });
      });
  };

  window.addToWishlist = function (id) {
    if (!token) { 
      Swal.fire({ 
        icon: "info", 
        title: "Please log in", 
        text: "You need to login to use wishlist.",
        confirmButtonColor: '#16a34a',
        background: '#ffffff',
        color: '#111827'
      }); 
      return; 
    }
    
    api.post("/wishlist", { product_id: id })
      .then(() => { 
        const wishIcon = document.getElementById('wishlistCount');
        if (wishIcon) {
          const current = parseInt(wishIcon.textContent) || 0;
          wishIcon.textContent = current + 1;
          wishIcon.classList.add('animate-pulse');
          setTimeout(() => wishIcon.classList.remove('animate-pulse'), 1000);
        }
        
        Swal.fire({ 
          icon: "success", 
          title: "Added to Wishlist!", 
          showConfirmButton: false, 
          timer: 1500,
          position: 'top-end',
          toast: true,
          background: '#ffffff',
          color: '#065f46'
        }); 
      })
      .catch(err => {
        Swal.fire({ 
          icon: "error", 
          title: "Failed", 
          text: err.response?.data?.message || "Could not add to wishlist",
          confirmButtonColor: '#16a34a',
          background: '#ffffff',
          color: '#991b1b'
        });
      });
  };
});
</script>
@endpush
