{{-- ======= SIDEBAR (glass, fixed, wider, responsive) ======= --}}
<div id="overlay-side" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 md:hidden"></div>

<aside id="sidebar"
  class="fixed top-0 left-0 h-screen w-72 bg-slate-900/100 text-white flex flex-col shadow-2xl border-r border-slate-800/60 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 backdrop-blur-md">

  {{-- Logo + name (clickable) --}}
<a href="{{ route('admin.dashboard') }}"
   class="group flex items-center justify-center gap-2 py-5 hover:bg-slate-800/40 select-none transition">
  <img src="{{ asset('images/logo.png') }}"
       alt="Logo"
       class="h-16 w-16 object-contain" />

  <span class="text-3xl font-extrabold leading-none tracking-tight
               bg-gradient-to-r from-white via-slate-100 to-slate-300
               text-transparent bg-clip-text">
    GAMERZ
  </span>
</a>

{{-- Nav --}}
<nav class="flex-1 px-6 py-8 space-y-4">
  {{-- Dashboard --}}
  <a href="{{ route('admin.dashboard') }}"
     class="flex items-center px-4 py-3 rounded-lg bg-slate-700/80 text-white font-semibold shadow hover:bg-slate-600/80 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8"/>
    </svg>
    Home
  </a>

  {{-- Products --}}
  <a href="{{ route('admin.products.index') }}"
     class="flex items-center px-4 py-3 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V6.618A2 2 0 014.553 4.724L9 2m6 0l5.447 2.724A2 2 0 0121 6.618v8.764A2 2 0 0119.447 17.276L15 20M9 2v18m6-18v18"/>
    </svg>
    Products
  </a>

  {{-- Categories --}}
  <a href="{{ route('admin.categories.index') }}"
     class="flex items-center px-4 py-3 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    Categories
  </a>

  {{-- Users --}}
<a href="{{ route('admin.users.index') }}"
   class="flex items-center px-4 py-3 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A8.962 8.962 0 0112 15c2.21 0 4.21.805 5.879 2.139M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Users
  </a>

  {{-- Orders --}}
  <a href="{{ route('admin.orders.index') }}"
    class="flex items-center px-4 py-3 rounded-lg bg-slate-800/80 hover:bg-slate-700/80 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M9 3v18m6-18v18"/>
    </svg>
    Orders
  </a>
</nav>


  {{-- Logout --}}
<div class="p-6 border-t border-slate-800/60">
  <form method="POST" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit"
            class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
      </svg>
      Logout
    </button>
  </form>
</div>
</aside>
