{{-- resources/views/dashboard/main.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50 py-8 px-4 md:px-8">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ================= LEFT: MAIN CONTENT ================= --}}
    <div class="lg:col-span-2 space-y-8">

      {{-- WELCOME / PROFILE (black & white) --}}
      <div class="group rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 shadow-xl p-6 relative overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="relative">
              <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-lg ring-4 ring-white/10 border border-white/20 overflow-hidden">
                <img
                src="{{ Auth::user()->profile_photo_url }}"
                alt="Profile"
                class="w-14 h-14 rounded-full object-cover border border-slate-200"
              />
              </div>
              <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-slate-950 animate-pulse"></div>
            </div>
            <div>
              <h1 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-2">
                Welcome back, {{ Auth::user()->name }}
                <span class="animate-wave inline-block">👋</span>
              </h1>
              <p class="text-slate-300 text-sm mt-1">Here's what's happening with your account today.</p>
            </div>
          </div>
          <div class="hidden md:flex items-center gap-2">
            <div class="px-4 py-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-medium">
              {{ now()->format('D, M j') }}
            </div>
          </div>
        </div>
      </div>

      {{-- KPI BOXES --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="group rounded-2xl bg-white shadow-sm hover:shadow-xl border border-slate-200 p-5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-blue-600/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-2">
              <div class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Total Orders</div>
              <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div id="kpi_total" class="text-3xl font-black text-slate-900 animate-count">0</div>
            <div class="mt-2 text-xs text-emerald-600 font-medium">↑ View all orders</div>
          </div>
        </div>

        <div class="group rounded-2xl bg-white shadow-sm hover:shadow-xl border border-slate-200 p-5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-500/10 to-amber-600/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-2">
              <div class="text-xs uppercase tracking-wide text-slate-500 font-semibold">In Progress</div>
              <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div id="kpi_progress" class="text-3xl font-black text-slate-900 animate-count">0</div>
            <div class="mt-2 text-xs text-amber-600 font-medium">⏳ Active shipments</div>
          </div>
        </div>

        <div class="group rounded-2xl bg-white shadow-sm hover:shadow-xl border border-slate-200 p-5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-2">
              <div class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Delivered</div>
              <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div id="kpi_delivered" class="text-3xl font-black text-slate-900 animate-count">0</div>
            <div class="mt-2 text-xs text-emerald-600 font-medium">✓ Successfully completed</div>
          </div>
        </div>

        <div class="group rounded-2xl bg-white shadow-sm hover:shadow-xl border border-slate-200 p-5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1">
          <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-500/10 to-purple-600/5 rounded-full -mr-12 -mt-12 group-hover:scale-150 transition-transform duration-500"></div>
          <div class="relative">
            <div class="flex items-center justify-between mb-2">
              <div class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Total Spend</div>
              <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div id="kpi_spend" class="text-3xl font-black text-slate-900 animate-count">LKR 0</div>
            <div class="mt-2 text-xs text-purple-600 font-medium">💰 Lifetime value</div>
          </div>
        </div>
      </div>

      {{-- PROMO BANNER (taller + roomy) --}}
      <div class="space-y-4">
        <div class="group rounded-3xl overflow-hidden bg-white shadow-xl border border-slate-200 hover:shadow-2xl transition-all duration-300">
          <div class="relative">
           <img
            src="{{ asset('images/promo.png') }}"
            class="w-full h-64 md:h-80 lg:h-96 object-cover group-hover:scale-105 transition-transform duration-700"
            alt="Promo Banner">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
            <div class="absolute top-0 left-0 mt-8 px-8 md:px-12 text-white flex flex-col justify-start">
              <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500 text-white text-xs font-bold uppercase tracking-wider w-fit mb-4 md:mb-5 animate-pulse">
                  <span class="w-2 h-2 bg-white rounded-full"></span> Limited Time Offer
                </div>
                <div class="text-4xl md:text-5xl lg:text-6xl font-black leading-tight mb-4">
                  Mega Sale<br/>
                  <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-rose-400">Up to 40% OFF</span>
                </div>
                <div class="text-sm md:text-base opacity-90 mb-6 max-w-md">
                  Transform your gaming setup with premium gear at unbeatable prices. Limited stock available!
                </div>
              </div>
              <div class="pt-2">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-900 text-sm md:text-base font-bold hover:bg-slate-100 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                  <span>Shop Now</span>
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="group rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="relative h-32 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                <div class="font-bold text-slate-800 text-sm">Free Shipping</div>
              </div>
              <div class="text-xs text-slate-500">On orders over LKR 9,999</div>
            </div>
          </div>

          <div class="group rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="relative h-32 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                <div class="font-bold text-slate-800 text-sm">Seasonal Offers</div>
              </div>
              <div class="text-xs text-slate-500">Bundle & save on essentials</div>
            </div>
          </div>

          <div class="group rounded-2xl overflow-hidden border border-slate-200 bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="relative h-32 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            </div>
            <div class="p-4">
              <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <div class="font-bold text-slate-800 text-sm">New Arrivals</div>
              </div>
              <div class="text-xs text-slate-500">Fresh drops every week</div>
            </div>
          </div>
        </div>
      </div>

      {{-- UPCOMING EVENTS & OFFERS --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-xl font-black text-slate-900">Upcoming Events & Offers</h2>
            <p class="text-sm text-slate-500 mt-1">Don't miss out on these exciting opportunities</p>
          </div>
          <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-semibold group">
            <span>View All</span>
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div class="group rounded-2xl overflow-hidden border border-slate-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-white">
            <div class="relative h-48 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1551033406-611cf9a28f67?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
              <div class="absolute top-3 right-3"><span class="px-3 py-1 rounded-full bg-rose-500 text-white text-xs font-bold">Hot</span></div>
              <div class="absolute bottom-3 left-3 right-3 text-white">
                <div class="text-lg font-bold">Gaming Weekend</div>
                <div class="text-xs opacity-90">Giveaways + Flash deals</div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <div class="text-sm font-bold text-slate-900">Starts 12 Oct</div>
                  <div class="text-xs text-slate-500">Mark your calendar</div>
                </div>
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition-colors">Notify Me</button>
              </div>
            </div>
          </div>

          <div class="group rounded-2xl overflow-hidden border border-slate-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-white">
            <div class="relative h-48 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
              <div class="absolute top-3 right-3"><span class="px-3 py-1 rounded-full bg-purple-500 text-white text-xs font-bold">Live</span></div>
              <div class="absolute bottom-3 left-3 right-3 text-white">
                <div class="text-lg font-bold">Creator Spotlight</div>
                <div class="text-xs opacity-90">Meet top streamers</div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <div class="text-sm font-bold text-slate-900">19 Oct • 7:00 PM</div>
                  <div class="text-xs text-slate-500">Join the livestream</div>
                </div>
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition-colors">Register</button>
              </div>
            </div>
          </div>

          <div class="group rounded-2xl overflow-hidden border border-slate-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 bg-white">
            <div class="relative h-48 overflow-hidden">
              <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=900&q=80&auto=format&fit=crop" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
              <div class="absolute top-3 right-3"><span class="px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-bold">Sale</span></div>
              <div class="absolute bottom-3 left-3 right-3 text-white">
                <div class="text-lg font-bold">Clearance Drop</div>
                <div class="text-xs opacity-90">Last season discounts</div>
              </div>
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between">
                <div>
                  <div class="text-sm font-bold text-slate-900">From LKR 990</div>
                  <div class="text-xs text-slate-500">Limited quantities</div>
                </div>
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition-colors">Shop Now</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- QUICK ACTIONS --}}
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('products.index') }}" class="group rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
          <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div class="font-bold text-sm">Shop Products</div>
          </div>
        </a>

        <a href="{{ route('cart.index') }}" class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
          <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="font-bold text-sm">My Cart</div>
          </div>
        </a>

        <a href="{{ route('wishlist.index') }}" class="group rounded-2xl bg-gradient-to-br from-rose-500 to-rose-600 p-6 text-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
          <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div class="font-bold text-sm">Wishlist</div>
          </div>
        </a>

        <a href="{{ route('dashboard.orders.index') }}" class="group rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 p-6 text-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
          <div class="flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
            </div>
            <div class="font-bold text-sm">Orders</div>
          </div>
        </a>
      </div>

      {{-- RECENT ORDERS (more responsive) --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-xl font-black text-slate-900">Recent Orders</h2>
            <p class="text-sm text-slate-500 mt-1">Track your latest purchases</p>
          </div>
          <a href="{{ route('dashboard.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-semibold group">
            <span>View All</span>
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
        </div>
        <div id="recentOrders" class="divide-y divide-slate-100">
          <div class="py-12 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-slate-200 border-t-blue-600"></div>
            <p class="mt-3 text-slate-400">Loading orders...</p>
          </div>
        </div>
      </div>

      {{-- PENDING REVIEWS --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-xl font-black text-slate-900">Pending Reviews</h2>
            <p class="text-sm text-slate-500 mt-1">Share your experience with these products</p>
          </div>
        </div>
        <div id="pendingWrap" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
        <div id="pendingEmpty" class="hidden py-12 text-center">
          <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <p class="text-slate-600 font-semibold">All caught up!</p>
          <p class="text-sm text-slate-500 mt-1">No items pending review. 🎉</p>
        </div>
      </div>

      {{-- YOU MAY LIKE (product cards improved mobile layout) --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="text-xl font-black text-slate-900">You May Like</h2>
            <p class="text-sm text-slate-500 mt-1">Handpicked recommendations just for you</p>
          </div>
        </div>
        <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="col-span-full py-12 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-slate-200 border-t-blue-600"></div>
            <p class="mt-3 text-slate-400">Loading products...</p>
          </div>
        </div>
      </div>

    </div>

    {{-- ================= RIGHT: SIDEBAR ================= --}}
    <aside class="space-y-6">

      {{-- COUPONS & OFFERS --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div>
            <h3 class="text-lg font-black text-slate-900">Coupons & Offers</h3>
            <p class="text-xs text-slate-500 mt-1">Click to copy code</p>
          </div>
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
          </div>
        </div>
        <div class="space-y-3">
          <div class="group rounded-2xl border-2 border-dashed border-blue-200 bg-gradient-to-br from-blue-50 to-blue-100/50 p-4 hover:border-blue-400 hover:shadow-md transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                  <div class="text-sm font-bold text-slate-900">New User</div>
                  <div class="text-xs text-blue-600 font-semibold">20% OFF</div>
                </div>
              </div>
              <button data-code="NEW20" class="btn-copy px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors">Copy</button>
            </div>
            <div class="flex items-center gap-2 pt-2 border-t border-blue-200">
              <span class="text-xs text-slate-600">Code:</span>
              <code class="px-2 py-1 rounded bg-white text-xs font-mono font-bold text-blue-600">NEW20</code>
            </div>
          </div>

          <div class="group rounded-2xl border-2 border-dashed border-purple-200 bg-gradient-to-br from-purple-50 to-purple-100/50 p-4 hover:border-purple-400 hover:shadow-md transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-purple-500 flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                  <div class="text-sm font-bold text-slate-900">Festive Sale</div>
                  <div class="text-xs text-purple-600 font-semibold">LKR 500 OFF</div>
                </div>
              </div>
              <button data-code="FEST500" class="btn-copy px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors">Copy</button>
            </div>
            <div class="flex items-center gap-2 pt-2 border-t border-purple-200">
              <span class="text-xs text-slate-600">Code:</span>
              <code class="px-2 py-1 rounded bg-white text-xs font-mono font-bold text-purple-600">FEST500</code>
            </div>
          </div>

          <div class="group rounded-2xl border-2 border-dashed border-emerald-200 bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-4 hover:border-emerald-400 hover:shadow-md transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div>
                  <div class="text-sm font-bold text-slate-900">Free Shipping</div>
                  <div class="text-xs text-emerald-600 font-semibold">On LKR 9,999+</div>
                </div>
              </div>
              <button data-code="FREESHIP" class="btn-copy px-3 py-1.5 rounded-lg bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors">Copy</button>
            </div>
            <div class="flex items-center gap-2 pt-2 border-t border-emerald-200">
              <span class="text-xs text-slate-600">Code:</span>
              <code class="px-2 py-1 rounded bg-white text-xs font-mono font-bold text-emerald-600">FREESHIP</code>
            </div>
          </div>
        </div>
      </div>

      {{-- CART PREVIEW --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Your Cart</h3>
              <p class="text-xs text-slate-500">Quick view</p>
            </div>
          </div>
          <a href="{{ route('cart.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">View all</a>
        </div>
        <div id="cartList" class="space-y-3">
          <div class="py-8 text-center"><div class="inline-block animate-spin rounded-full h-6 w-6 border-3 border-slate-200 border-t-blue-600"></div></div>
        </div>
      </div>

      {{-- WISHLIST PREVIEW --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Your Wishlist</h3>
              <p class="text-xs text-slate-500">Saved items</p>
            </div>
          </div>
          <a href="{{ route('wishlist.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">View all</a>
        </div>
        <div id="wishList" class="space-y-3">
          <div class="py-8 text-center"><div class="inline-block animate-spin rounded-full h-6 w-6 border-3 border-slate-200 border-t-rose-600"></div></div>
        </div>
      </div>

      {{-- SPENDING OVERVIEW --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Spending Overview</h3>
              <p class="text-xs text-slate-500">Last 6 months</p>
            </div>
          </div>
        </div>
        <div class="bg-slate-50 rounded-2xl p-4">
          <canvas id="spendChart" height="200"></canvas>
        </div>
      </div>

      {{-- ORDER STATUS (bigger chart) --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Order Status</h3>
              <p class="text-xs text-slate-500">Distribution</p>
            </div>
          </div>
        </div>
        <div class="bg-slate-50 rounded-2xl p-4">
          <canvas id="statusChart" height="230"></canvas>
        </div>
      </div>

      {{-- QUICK PICKS --}}
      <div class="rounded-3xl bg-white border border-slate-200 shadow-lg p-6">
        <div class="flex items-center justify-between mb-5">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
              <h3 class="text-sm font-bold text-slate-900">Quick Picks</h3>
              <p class="text-xs text-slate-500">Popular items</p>
            </div>
          </div>
          <a href="{{ route('products.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-semibold">More</a>
        </div>
        <div id="quickPicks" class="space-y-3">
          <div class="py-8 text-center"><div class="inline-block animate-spin rounded-full h-6 w-6 border-3 border-slate-200 border-t-amber-600"></div></div>
        </div>
      </div>

    </aside>

  </div>
</div>
@endsection

@push('styles')
<style>
  @keyframes wave { 0%,100%{transform:rotate(0)} 10%,30%{transform:rotate(14deg)} 20%{transform:rotate(-8deg)} 40%{transform:rotate(-4deg)} 50%{transform:rotate(10deg)} }
  @keyframes count { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  .animate-wave{animation:wave 2s ease-in-out infinite;transform-origin:70% 70%;display:inline-block}
  .animate-count{animation:count .5s ease-out}

  html{scroll-behavior:smooth}
  ::-webkit-scrollbar{width:8px;height:8px}
  ::-webkit-scrollbar-track{background:#f1f5f9}
  ::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:4px}
  ::-webkit-scrollbar-thumb:hover{background:#94a3b8}

  .group:hover .group-hover\:scale-105{transform:scale(1.05)}
  .group:hover .group-hover\:scale-110{transform:scale(1.10)}
  .group:hover .group-hover\:scale-150{transform:scale(1.50)}
  .group:hover .group-hover\:translate-x-1{transform:translateX(.25rem)}

  .backdrop-blur-sm{backdrop-filter:blur(4px)}
  .bg-clip-text{-webkit-background-clip:text;background-clip:text}
  .shadow-xl{box-shadow:0 20px 25px -5px rgba(0,0,0,.1),0 10px 10px -5px rgba(0,0,0,.04)}
  .shadow-2xl{box-shadow:0 25px 50px -12px rgba(0,0,0,.25)}
  .transition-all{transition-property:all;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:300ms}

  @keyframes spin { to{transform:rotate(360deg)} }
  .animate-spin{animation:spin 1s linear infinite}

  @keyframes slide-up { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
  .animate-slide-up{animation:slide-up .3s ease-out}

  *{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:150ms}
  .preload *{transition:none!important}
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', init);

async function init(){
  try{
    const [ordersRes, cartRes, wishRes, prodRes] = await Promise.all([
      axios.get('/api/orders'),
      axios.get('/api/cart'),
      axios.get('/api/wishlist'),
      axios.get('/api/products'),
    ]);

    const orders = toArr(ordersRes?.data?.data ?? ordersRes?.data);

    const cartPayload = cartRes?.data?.data ?? cartRes?.data;
    const cart = Array.isArray(cartPayload) ? cartPayload : (cartPayload?.items ?? []);

    const wishPayload = wishRes?.data?.data ?? wishRes?.data;
    const wish = Array.isArray(wishPayload) ? wishPayload : (wishPayload?.items ?? []);

    const prods  = toArr(prodRes?.data?.data ?? prodRes?.data);

    // KPIs
    const counts = byStatus(orders);
    const inProg = (counts.confirmed||0) + (counts.shipped||0) + (counts.processing||0) + (counts.pending||0);
    const spend  = orders.reduce((s,o)=> s + toNum(o.total), 0);

    animateCount('#kpi_total', orders.length);
    animateCount('#kpi_progress', inProg);
    animateCount('#kpi_delivered', counts.delivered || 0);
    animateCountMoney('#kpi_spend', spend);

    // Sections
    renderRecent(orders.slice(0,5));
    renderPending(collectPending(orders));
    renderItems('#cartList', cart, true);
    renderItems('#wishList', wish, false);
    renderProducts('#productsGrid', prods.slice(0,3));
    renderSimpleProductList('#quickPicks', prods.slice(3,6));

    // Charts
    drawSpendChart(orders);
    drawStatusChart(counts);

    // Coupon copy
    document.querySelectorAll('.btn-copy').forEach(btn => {
      btn.addEventListener('click', () => {
        const code = btn.getAttribute('data-code');
        navigator.clipboard.writeText(code).then(()=>{
          const old = btn.textContent;
          btn.textContent = '✓ Copied!';
          btn.classList.add('bg-emerald-600','scale-95');
          btn.classList.remove('bg-slate-900');
          setTimeout(()=>{
            btn.textContent = old;
            btn.classList.remove('bg-emerald-600','scale-95');
            btn.classList.add('bg-slate-900');
          }, 1500);
        });
      });
    });

  }catch(e){
    console.error('init error', e);
    setError('#recentOrders'); 
    setError('#cartList'); 
    setError('#wishList'); 
    setError('#quickPicks');
    const grid = qs('#productsGrid');
    if(grid) grid.innerHTML = '<div class="col-span-full py-12 text-center text-rose-500">Failed to load products.</div>';
  }
}

/* ===== Animated counters ===== */
function animateCount(sel, target){ const el=qs(sel); if(!el) return; let c=0, inc = (target||0)/30; const t=setInterval(()=>{ c+=inc; if(c>=target){ el.textContent=Math.round(target); clearInterval(t);} else { el.textContent=Math.round(c);} },30); }
function animateCountMoney(sel, target){ const el=qs(sel); if(!el) return; let c=0, inc=(target||0)/30; const t=setInterval(()=>{ c+=inc; if(c>=target){ el.textContent='LKR '+Math.round(target).toLocaleString('en-LK'); clearInterval(t);} else { el.textContent='LKR '+Math.round(c).toLocaleString('en-LK'); } },30); }

/* ===== Charts ===== */
function drawSpendChart(orders){
  const ctx = document.getElementById('spendChart');
  if(!ctx || typeof Chart === 'undefined') return;
  const map = {};
  orders.forEach(o=>{
    const d = new Date(o.created_at || o.date || Date.now());
    const key = `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}`;
    map[key] = (map[key]||0) + toNum(o.total);
  });
  const keys = Object.keys(map).sort().slice(-6);
  const data = keys.map(k => Math.round(map[k]));
  new Chart(ctx, {
    type: 'line',
    data: { labels: keys, datasets: [{ 
      label: 'Spending (LKR)',
      data,
      borderColor: 'rgb(147, 51, 234)',
      backgroundColor: 'rgba(147, 51, 234, 0.1)',
      tension: .4, fill: true, borderWidth: 3,
      pointRadius: 5, pointBackgroundColor: 'rgb(147, 51, 234)', pointBorderColor: '#fff', pointBorderWidth: 2, pointHoverRadius: 7
    }]},
    options: {
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{display:false}, tooltip:{backgroundColor:'rgba(0,0,0,.8)', padding:12, borderRadius:8, titleColor:'#fff', bodyColor:'#fff', displayColors:false}},
      scales:{ y:{ beginAtZero:true, grid:{color:'rgba(0,0,0,.05)', drawBorder:false}, ticks:{callback:v=>'LKR '+Number(v).toLocaleString('en-LK'), color:'#64748b', font:{size:11}} },
              x:{ grid:{display:false, drawBorder:false}, ticks:{color:'#64748b', font:{size:11}} } }
    }
  });
}

function drawStatusChart(counts){
  const ctx = document.getElementById('statusChart');
  if(!ctx || typeof Chart === 'undefined') return;
  const labels = ['pending','confirmed','processing','shipped','delivered','cancelled'];
  const data = labels.map(k => counts[k]||0);
  const colors = ['#f59e0b','#06b6d4','#78716c','#64748b','#10b981','#ef4444'];
  new Chart(ctx, {
    type: 'doughnut',
    data: { labels: labels.map(s=>s[0].toUpperCase()+s.slice(1)), datasets:[{ data, backgroundColor:colors, borderWidth:3, borderColor:'#fff', hoverOffset:8 }] },
    options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{padding:12, usePointStyle:true, pointStyle:'circle', font:{size:12}, color:'#64748b'}},
      tooltip:{backgroundColor:'rgba(0,0,0,.8)', padding:12, borderRadius:8, titleColor:'#fff', bodyColor:'#fff', displayColors:true}}, cutout:'58%' }
  });
}

/* ===== Renderers ===== */
function renderRecent(list){
  const box = qs('#recentOrders');
  if(!box) return;
  if(!list.length){
    box.innerHTML = `
      <div class="py-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
          <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <p class="text-slate-600 font-semibold">No orders yet</p>
        <p class="text-sm text-slate-500 mt-1">Start shopping to see your orders here</p>
      </div>`;
    return;
  }
  box.innerHTML = list.map(o=>{
    const id  = esc(o.id ?? o.order_id ?? '—');
    const dt  = fmtDate(o.created_at ?? o.date);
    const st  = String(o.status||'').toLowerCase();
    const tl  = toNum(o.total);
    const first = (o.items||[])[0] || {};
    const prod  = first.product || first;
    const thumb = imgUrl(prod?.image_url || (prod?.image_path ? `/${prod.image_path}` : null) || first?.image_url || (first?.image_path ? `/${first.image_path}` : null));
    const badge = statusBadge(st);
    return `
      <div class="group py-4 md:py-5 rounded-xl px-3 -mx-3 transition-all duration-200 hover:bg-slate-50">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <div class="flex items-center gap-4 flex-1 min-w-0">
            <div class="relative flex-shrink-0">
              <img src="${thumb}" class="w-14 h-14 rounded-xl object-cover border-2 border-slate-100 group-hover:border-blue-200 transition-colors" alt="thumb">
              <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-white border-2 border-slate-100 flex items-center justify-center">
                <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center flex-wrap gap-2 mb-1">
                <div class="text-sm font-bold text-slate-900">Order #${id}</div>
                ${badge}
              </div>
              <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  ${dt}
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                  ${(o.items||[]).length} item(s)
                </span>
              </div>

              {{-- Mobile price + button --}}
              <div class="mt-3 flex items-center justify-between sm:hidden">
                <div class="text-left">
                  <div class="text-base font-black text-slate-900">LKR ${tl.toLocaleString('en-LK')}</div>
                  <div class="text-xs text-slate-500">Total</div>
                </div>
                <a href="/dashboard/orders/${id}" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors">
                  <span>View</span>
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
              </div>
            </div>
          </div>

          {{-- Desktop price + button --}}
          <div class="hidden sm:flex items-center gap-3 flex-shrink-0">
            <div class="text-right">
              <div class="text-lg font-black text-slate-900">LKR ${tl.toLocaleString('en-LK')}</div>
              <div class="text-xs text-slate-500">Total</div>
            </div>
            <a href="/dashboard/orders/${id}" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-colors group-hover:scale-105">
              <span>View</span>
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>`;
  }).join('');
}

function renderPending(items){
  const wrap = qs('#pendingWrap');
  const empty = qs('#pendingEmpty');
  if(!wrap || !empty) return;
  if(!items.length){ empty.classList.remove('hidden'); wrap.innerHTML=''; return; }
  empty.classList.add('hidden');
  wrap.innerHTML = items.slice(0,6).map(x => `
    <div class="group rounded-2xl border-2 border-slate-200 hover:border-blue-300 p-4 hover:shadow-lg transition-all duration-300 bg-white">
      <div class="flex items-center gap-3 mb-3">
        <div class="relative flex-shrink-0">
          <img src="${imgUrl(x.img)}" class="w-16 h-16 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-blue-200 transition-all" alt="product">
          <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-amber-400 border-2 border-white flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm font-bold text-slate-900 truncate mb-1">${esc(x.name || 'Product')}</div>
          <div class="text-xs text-slate-500">${x.price!=null ? 'LKR '+toNum(x.price).toLocaleString('en-LK') : ''}</div>
        </div>
      </div>
      <a href="/dashboard/orders/${esc(x.order_id)}/review" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-bold hover:from-emerald-600 hover:to-emerald-700 transition-all duration-300 shadow-sm hover:shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        <span>Write Review</span>
      </a>
    </div>
  `).join('');
}

function renderItems(sel, items, showQty){
  const box = qs(sel);
  if(!box) return;
  if(!items.length){
    box.innerHTML = `
      <div class="py-8 text-center">
        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center">
          <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <p class="text-sm text-slate-500">Nothing here yet</p>
      </div>`;
    return;
  }
  box.innerHTML = items.slice(0,4).map(it => {
    const p = it.product ?? it;
    const id = p.id ?? it.product_id ?? '';
    const name = p.name ?? it.product_name ?? 'Item';
    const qty = it.quantity ?? 1;
    const priceEach = toNum(p.price ?? it.price);
    const price = priceEach * (showQty ? qty : 1);
    const imageUrl = p.image_url || (p.image_path ? `/${p.image_path}` : null) || it.image_url || (it.image_path ? `/${it.image_path}` : null);
    return `
      <div class="group flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-all duration-200">
        <div class="relative flex-shrink-0">
          <img src="${imgUrl(imageUrl)}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 group-hover:border-blue-300 transition-colors" alt="item">
          ${showQty ? `<div class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-blue-500 border-2 border-white text-white text-xs font-bold flex items-center justify-center">${qty}</div>` : ''}
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm font-bold text-slate-900 truncate">${esc(name)}</div>
          <div class="text-xs text-slate-500 mt-0.5">${showQty ? qty+' × ' : ''}LKR ${priceEach.toLocaleString('en-LK')}</div>
        </div>
        <div class="flex-shrink-0 flex items-center gap-2">
          <div class="text-sm font-black text-slate-900">LKR ${price.toLocaleString('en-LK')}</div>
          <a href="/products/${esc(id)}" class="p-2 rounded-lg hover:bg-slate-200 transition-colors"><svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
        </div>
      </div>`;
  }).join('');
}

function renderProducts(sel, products){
  const grid = qs(sel);
  if(!grid) return;
  if(!products.length){
    grid.innerHTML = `
      <div class="col-span-full py-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
          <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <p class="text-slate-600 font-semibold">No products available</p>
        <p class="text-sm text-slate-500 mt-1">Check back soon for new items</p>
      </div>`;
    return;
  }

  grid.innerHTML = '';
  products.forEach(p=>{
    const price = toNum(p.price);
    const id = p.id ?? p.product_id ?? '';
    const name = p.name ?? p.product_name ?? 'Product';
    const imageUrl = p.image_url || (p.image_path ? `/${p.image_path}` : p.image || '');
    grid.insertAdjacentHTML('beforeend', `
      <div class="group rounded-3xl overflow-hidden bg-white border-2 border-slate-200 hover:border-blue-300 shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
        <div class="relative h-48 overflow-hidden bg-slate-100">
          <img src="${imgUrl(imageUrl)}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="${esc(name)}">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <button onclick="addToWishlist(${id})" class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center hover:bg-white transition-colors shadow-lg">
              <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </button>
          </div>
          <div class="absolute bottom-3 left-3">
            <span class="px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-slate-900">${p.category?.name ?? 'Product'}</span>
          </div>
        </div>
        <div class="p-5">
          <div class="mb-3">
            <h3 class="font-bold text-slate-900 line-clamp-1 group-hover:text-blue-600 transition-colors mb-1">${esc(name)}</h3>
            <div class="flex items-center gap-2 text-xs text-slate-500">
              <div class="flex items-center gap-1">
                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                <span class="font-semibold">4.5</span>
              </div>
              <span>•</span>
              <span>128 reviews</span>
            </div>
          </div>
          {{-- Price + Actions: stack on mobile, side-by-side on larger screens --}}
          <div class="flex flex-col items-center gap-4 pt-4 border-t border-slate-100">
          <div class="text-center">
            <div class="text-2xl font-black text-slate-900">
              LKR ${price.toLocaleString('en-LK', {minimumFractionDigits:0})}
            </div>
            <div class="text-xs text-slate-500">Free shipping</div>
          </div>
          <div class="flex gap-2 w-full justify-center">
            <a href="/products/${id}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1 px-4 py-2.5 text-sm rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-all hover:scale-105">
              <span>View</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </a>
            <button onclick="addToCart(${id})" class="flex-1 sm:flex-none p-2.5 rounded-xl bg-white border-2 border-slate-200 hover:border-blue-300 hover:bg-blue-50 transition-all hover:scale-105">
              <svg class="w-5 h-5 mx-auto text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </button>
          </div>
        </div>
        </div>
      </div>
    `);
  });
}

function renderSimpleProductList(sel, products){
  const box = qs(sel);
  if(!box) return;
  if(!products.length){
    box.innerHTML = `
      <div class="py-8 text-center">
        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center">
          <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <p class="text-sm text-slate-500">No items</p>
      </div>`;
    return;
  }
  box.innerHTML = products.slice(0,3).map(p=>{
    const id = p.id ?? p.product_id ?? '';
    const name = p.name ?? p.product_name ?? 'Product';
    const imageUrl = p.image_url || (p.image_path ? `/${p.image_path}` : p.image || '');
    const price = toNum(p.price);
    return `
      <div class="group flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all duration-200">
        <div class="relative flex-shrink-0">
          <img src="${imgUrl(imageUrl)}" class="w-14 h-14 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-amber-300 transition-all" alt="${esc(name)}">
          <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-amber-400 border-2 border-white flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <div class="text-sm font-bold text-slate-900 truncate group-hover:text-blue-600 transition-colors">${esc(name)}</div>
          <div class="flex items-center gap-2 mt-1">
            <div class="text-sm font-black text-slate-900">LKR ${price.toLocaleString('en-LK')}</div>
            <div class="flex items-center gap-0.5">
              <svg class="w-3 h-3 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="text-xs text-slate-500">4.5</span>
            </div>
          </div>
        </div>
        <a href="/products/${id}" class="p-2 rounded-lg hover:bg-slate-200 transition-colors flex-shrink-0">
          <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>`;
  }).join('');
}

/* ===== Actions ===== */
async function addToCart(productId){
  try{ await axios.post('/api/cart', {product_id: productId, quantity: 1}); showToast('Added to cart! ✅', 'success'); }
  catch(e){ console.error('addToCart error', e); showToast('Failed to add to cart', 'error'); }
}
async function addToWishlist(productId){
  try{ await axios.post('/api/wishlist', {product_id: productId}); showToast('Added to wishlist! ❤️', 'success'); }
  catch(e){ console.error('addToWishlist error', e); showToast('Failed to add to wishlist', 'error'); }
}
function showToast(message, type='success'){
  const toast = document.createElement('div');
  const bg = type==='success' ? 'bg-emerald-500' : 'bg-rose-500';
  toast.className = `fixed bottom-6 right-6 ${bg} text-white px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-3 animate-slide-up`;
  toast.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="font-semibold">${message}</span>`;
  document.body.appendChild(toast);
  setTimeout(()=>{ toast.style.opacity='0'; toast.style.transform='translateY(20px)'; setTimeout(()=>toast.remove(),300); },3000);
}

/* ===== Helpers ===== */
function makePlaceholder(){
  const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='200' height='160'><rect width='100%' height='100%' fill='#e5e7eb'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='14' fill='#6b7280'>No Image</text></svg>`;
  return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
}
function imgUrl(u){
  if(!u) return makePlaceholder();
  if(/^https?:\/\//i.test(u) || /^data:image\//i.test(u)) return u;
  const clean = String(u).replace(/^\/+/, '');
  if (clean.startsWith('storage/'))  return '/' + clean;
  if (clean.startsWith('public/'))   return '/storage/' + clean.replace(/^public\//,'');
  if (!clean.includes('/')) return '/images/' + clean;
  if (clean.startsWith('products/')) return '/storage/' + clean;
  return '/' + clean;
}
function byStatus(orders){ const m={}; orders.forEach(o=>{ const s=String(o.status||'placed').toLowerCase(); m[s]=(m[s]||0)+1; }); return m; }
function collectPending(orders){
  const out=[]; orders.forEach(o=>{
    const st = String(o.status||'').toLowerCase();
    if(st==='delivered'){
      (o.items||[]).forEach(it=>{
        const reviewed = it.reviewed || it.has_review || it.rating;
        if(!reviewed){
          out.push({
            order_id: o.id || o.order_id,
            name: it.product?.name || it.product_name || it.name,
            img: it.product?.image_url || (it.product?.image_path ? `/${it.product.image_path}` : null) || it.image_url || (it.image_path ? `/${it.image_path}` : null),
            price: it.price || it.product?.price
          });
        }
      });
    }
  }); return out;
}
function statusBadge(s){
  const map = {
    pending:    { bg:'bg-amber-100', text:'text-amber-800', border:'border-amber-200', icon:'⏳' },
    confirmed:  { bg:'bg-cyan-100', text:'text-cyan-800', border:'border-cyan-200', icon:'✓' },
    processing: { bg:'bg-blue-100', text:'text-blue-800', border:'border-blue-200', icon:'⚙️' },
    shipped:    { bg:'bg-purple-100', text:'text-purple-800', border:'border-purple-200', icon:'🚚' },
    delivered:  { bg:'bg-emerald-100', text:'text-emerald-800', border:'border-emerald-200', icon:'✅' },
    cancelled:  { bg:'bg-rose-100', text:'text-rose-800', border:'border-rose-200', icon:'✕' },
  };
  const style = map[s] || { bg:'bg-slate-100', text:'text-slate-800', border:'border-slate-200', icon:'•' };
  const label = String(s||'').toUpperCase();
  return `<span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold rounded-full ${style.bg} ${style.text} border ${style.border}"><span>${style.icon}</span><span>${label}</span></span>`;
}
function qs(sel){ return document.querySelector(sel); }
function toArr(v){ return Array.isArray(v) ? v : (v ? [v] : []); }
function toNum(x){ const n=parseFloat(String(x??0).toString().replace(/,/g,'')); return isNaN(n)?0:n; }
function esc(s){ return String(s ?? '').replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
function fmtDate(d){ try{ return new Date(d).toLocaleDateString('en-LK',{day:'numeric',month:'short',year:'numeric'});}catch{return '—'} }
function setError(sel){ const el=qs(sel); if(el) el.innerHTML=`<div class="py-8 text-center"><div class="w-12 h-12 mx-auto mb-3 rounded-full bg-rose-100 flex items-center justify-center"><svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><p class="text-sm text-rose-500 font-semibold">Failed to load</p></div>`; }
</script>

<script>
  window.addEventListener('load', () => { document.body.classList.remove('preload'); });
</script>
@endpush
