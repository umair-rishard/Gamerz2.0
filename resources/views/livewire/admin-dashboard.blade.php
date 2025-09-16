{{-- ======= PAGE WRAPPER ======= --}}
<div class="min-h-screen bg-white pt-28">
  {{-- Header + Sidebar --}}
  @include('partials.admin.header')
  @include('partials.admin.sidebar')

  {{-- Main content (respects sidebar width on md+) --}}
  <main class="ml-0 md:ml-72 p-4 md:p-6">
    {{-- Premium welcome card --}}
    <section class="bg-white rounded-2xl border border-slate-200 shadow-xl p-6">
      <h1 class="text-2xl font-bold text-slate-900 mb-1">Welcome, {{ Auth::guard('admin')->user()->name }}</h1>
      <p class="text-slate-600">You are now logged in as an admin.</p>
    </section>

    {{-- Stats (sample) --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
      <div class="rounded-xl p-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
        <p class="text-sm opacity-90">Total Products</p>
        <p class="text-3xl font-bold mt-1">120</p>
      </div>
      <div class="rounded-xl p-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg">
        <p class="text-sm opacity-90">Orders</p>
        <p class="text-3xl font-bold mt-1">42</p>
      </div>
      <div class="rounded-xl p-5 bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-lg">
        <p class="text-sm opacity-90">Users</p>
        <p class="text-3xl font-bold mt-1">85</p>
      </div>
      <div class="rounded-xl p-5 bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg">
        <p class="text-sm opacity-90">Revenue</p>
        <p class="text-3xl font-bold mt-1">$5.2k</p>
      </div>
    </section>
  </main>
</div>
