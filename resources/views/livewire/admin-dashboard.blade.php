{{-- ======= PAGE WRAPPER ======= --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 pt-32">
  {{-- Header + Sidebar --}}
  @include('partials.admin.header')
  @include('partials.admin.sidebar')

  {{-- Main content (respects sidebar width on md+) --}}
  <main class="ml-0 md:ml-72 p-4 md:p-6">
    {{-- constrain & prevent sideways scroll on small screens --}}
    <div class="w-full overflow-x-hidden">

      {{-- === Top Greeting + Filters === --}}
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="min-w-0">
          <h1 class="text-3xl sm:text-4xl font-black tracking-tight bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            Welcome back, <span id="adminName">Loading...</span>
          </h1>
          <p class="text-slate-600 mt-2 text-lg">Manage your gaming empire. Here's what's happening today.</p>
        </div>

        {{-- Time filter pills --}}
        <div class="flex items-center gap-3 flex-wrap justify-end md:justify-end md:ml-auto w-full md:w-auto">
          <div class="inline-flex rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
            <button class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-500 to-pink-500">Today</button>
            <button class="px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 text-slate-600 transition-colors">Week</button>
            <button class="px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 text-slate-600 transition-colors">Month</button>
            <button class="px-4 py-2.5 text-sm font-semibold hover:bg-slate-50 text-slate-600 transition-colors">Year</button>
          </div>
        </div>
      </div>

      {{-- === KPI CARDS === --}}
      <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Products --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-700 p-4 shadow-lg transition-shadow hover:shadow-2xl">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-2xl"></div>
          <div class="relative">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-white/90 text-sm font-medium">Total Products</p>
                <div class="mt-1.5 text-2xl font-bold text-white">{{ number_format($totalProducts) }}</div>
              </div>
              <div class="h-10 w-10 grid place-items-center rounded-xl bg-white/20 text-white backdrop-blur">
                {{-- boxes icon --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
              <span class="inline-flex items-center gap-1 rounded-full bg-white/20 backdrop-blur text-white px-2.5 py-0.5 text-xs font-semibold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                12.5%
              </span>
              <span class="text-white/90 text-xs">vs last month</span>
            </div>
          </div>
        </div>

        {{-- Total Orders --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 p-4 shadow-lg transition-shadow hover:shadow-2xl">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-2xl"></div>
          <div class="relative">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-white/90 text-sm font-medium">Total Orders</p>
                <div class="mt-1.5 text-2xl font-bold text-white">{{ number_format($totalOrders) }}</div>
              </div>
              <div class="h-10 w-10 grid place-items-center rounded-xl bg-white/20 text-white backdrop-blur">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
              <span class="inline-flex items-center gap-1 rounded-full bg-white/20 backdrop-blur text-white px-2.5 py-0.5 text-xs font-semibold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                23%
              </span>
              <span class="text-white/90 text-xs">vs yesterday</span>
            </div>
          </div>
        </div>

        {{-- Registered Users --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-600 to-pink-700 p-4 shadow-lg transition-shadow hover:shadow-2xl">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/10 blur-2xl"></div>
          <div class="relative">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-white/90 text-sm font-medium">Registered Users</p>
                <div class="mt-1.5 text-2xl font-bold text-white">{{ number_format($totalUsers) }}</div>
              </div>
              <div class="h-10 w-10 grid place-items-center rounded-xl bg-white/20 text-white backdrop-blur">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
              <span class="inline-flex items-center gap-1 rounded-full bg-white/20 backdrop-blur text-white px-2.5 py-0.5 text-xs font-semibold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                8.2%
              </span>
              <span class="text-white/90 text-xs">vs last week</span>
            </div>
          </div>
        </div>

        {{-- Total Revenue --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-4 shadow-lg transition-shadow hover:shadow-2xl">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-20 w-20 rounded-full bg-white/20 blur-2xl"></div>
          <div class="relative">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-white/90 text-sm font-medium">Total Revenue</p>
                <div class="mt-1.5 text-2xl font-bold text-white">LKR {{ number_format($totalRevenue, 2) }}</div>
              </div>
              <div class="h-10 w-10 grid place-items-center rounded-xl bg-white/20 text-white backdrop-blur">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-3">
              <div class="w-full h-2 rounded-full bg-white/30 overflow-hidden">
                <div class="h-full bg-white/90 rounded-full transition-all duration-1000" style="width:85%"></div>
              </div>
              <div class="mt-2 text-xs text-white/90">85% of daily target (LKR 29,000)</div>
            </div>
          </div>
        </div>
      </div>

      {{-- === MAIN GRID: Charts + Right Rail === --}}
      <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- Left: Charts & tables (span 2) --}}
        <div class="lg:col-span-2 space-y-6 min-w-0">
          {{-- Sales by Category Chart --}}
          <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-purple-50 border border-purple-100 shadow-xl">
            <div class="flex items-center justify-between px-6 pt-6">
              <div class="min-w-0">
                <h3 class="text-xl font-bold text-slate-900">Sales by Category</h3>
                <p class="text-sm text-slate-600 mt-1">Gaming accessories performance — last 7 months</p>
              </div>
              <div class="text-sm flex-shrink-0">
                <span class="inline-flex items-center gap-2 mr-4">
                  <span class="inline-block w-3 h-3 rounded-full bg-purple-500"></span>
                  <span class="font-medium">Keyboards</span>
                </span>
                <span class="inline-flex items-center gap-2">
                  <span class="inline-block w-3 h-3 rounded-full bg-pink-500"></span>
                  <span class="font-medium">Headsets</span>
                </span>
              </div>
            </div>
            <div class="p-6">
              <canvas id="salesChart" class="w-full max-w-full h-64"></canvas>
            </div>
          </div>

          {{-- Order Status + Popular Products --}}
          <div class="grid gap-6 md:grid-cols-2">
            {{-- Order Status Doughnut --}}
            <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 shadow-xl">
              <div class="flex items-center justify-between px-6 pt-6">
                <h3 class="text-xl font-bold text-slate-900">Order Status</h3>
                <span class="text-sm text-slate-600">Today</span>
              </div>
              <div class="p-6">
                <canvas id="orderStatusChart" class="w-full max-w-full h-60"></canvas>
              </div>
              <div class="px-6 pb-6 grid grid-cols-3 text-center text-sm">
                <div class="font-medium"><span class="inline-block w-3 h-3 rounded-full bg-emerald-500 mr-2"></span>Delivered</div>
                <div class="font-medium"><span class="inline-block w-3 h-3 rounded-full bg-amber-500 mr-2"></span>Processing</div>
                <div class="font-medium"><span class="inline-block w-3 h-3 rounded-full bg-rose-500 mr-2"></span>Pending</div>
              </div>
            </div>

            {{-- Top Products Bar --}}
            <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 shadow-xl">
              <div class="flex items-center justify-between px-6 pt-6">
                <h3 class="text-xl font-bold text-slate-900">Top Products</h3>
                <span class="text-sm text-slate-600">This week</span>
              </div>
              <div class="p-6">
                <canvas id="topProductsChart" class="w-full max-w-full h-60"></canvas>
              </div>
            </div>
          </div>

          {{-- Recent Orders Table --}}
          <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50 border border-indigo-100 shadow-xl">
            <div class="flex items-center justify-between px-6 pt-6">
              <h3 class="text-xl font-bold text-slate-900">Recent Orders</h3>
              <a href="{{ url('/admin/orders') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-700 transition-colors">View all →</a>
            </div>
            <div class="overflow-x-auto max-w-full">
              <table class="w-full text-left text-sm">
                <thead>
                  <tr class="text-slate-600 border-b border-slate-200">
                    <th class="px-6 py-4 font-semibold">Order ID</th>
                    <th class="px-6 py-4 font-semibold">Customer</th>
                    <th class="px-6 py-4 font-semibold">Product</th>
                    <th class="px-6 py-4 font-semibold">Amount</th>
                    <th class="px-6 py-4 font-semibold">Payment</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  @foreach([
                    ['#GA2451','Alex Chen','Razer DeathAdder V3','$149.99','Credit Card','Delivered'],
                    ['#GA2452','Sarah Johnson','SteelSeries Arctis 7P','$169.99','PayPal','Processing'],
                    ['#GA2453','Mike Wilson','Corsair K70 RGB','$159.99','Credit Card','Shipped'],
                    ['#GA2454','Emma Davis','Logitech G Pro X','$129.99','Stripe','Pending']
                  ] as $row)
                  <tr class="odd:bg-white even:bg-indigo-50/40 hover:bg-white/70 transition-colors">
                    <td class="px-6 py-4 font-mono text-purple-600">{{ $row[0] }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $row[1] }}</td>
                    <td class="px-6 py-4 text-slate-700">{{ $row[2] }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $row[3] }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $row[4] }}</td>
                    <td class="px-6 py-4">
                      @php $status = $row[5]; @endphp
                      @if($status === 'Delivered')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">{{ $status }}</span>
                      @elseif($status === 'Processing')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $status }}</span>
                      @elseif($status === 'Shipped')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">{{ $status }}</span>
                      @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">{{ $status }}</span>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-200 text-right">
              <a href="{{ url('/admin/orders') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 text-white px-5 py-2.5 text-sm font-semibold hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg">
                Manage Orders
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>

          {{-- Store Performance Analytics --}}
          <div class="rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100 shadow-xl">
            <div class="px-6 pt-6">
              <h3 class="text-xl font-bold text-slate-900">Store Performance</h3>
              <p class="text-sm text-slate-600 mt-1">Key metrics for your gaming store</p>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="text-center">
                <div class="relative inline-flex items-center justify-center">
                  <svg class="w-28 h-28 transform -rotate-90">
                    <circle cx="56" cy="56" r="48" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                    <circle cx="56" cy="56" r="48" stroke="#8b5cf6" stroke-width="8" fill="none"
                      stroke-dasharray="301.59" stroke-dashoffset="60.32" stroke-linecap="round"></circle>
                  </svg>
                  <div class="absolute">
                    <div class="text-xl font-bold text-slate-900">80%</div>
                  </div>
                </div>
                <h4 class="mt-3 font-semibold text-slate-900">Customer Satisfaction</h4>
                <p class="text-sm text-slate-600 mt-1">Based on 1,245 reviews</p>
              </div>

              <div class="text-center">
                <div class="relative inline-flex items-center justify-center">
                  <svg class="w-28 h-28 transform -rotate-90">
                    <circle cx="56" cy="56" r="48" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                    <circle cx="56" cy="56" r="48" stroke="#ec4899" stroke-width="8" fill="none"
                      stroke-dasharray="301.59" stroke-dashoffset="75.40" stroke-linecap="round"></circle>
                  </svg>
                  <div class="absolute">
                    <div class="text-xl font-bold text-slate-900">75%</div>
                  </div>
                </div>
                <h4 class="mt-3 font-semibold text-slate-900">Conversion Rate</h4>
                <p class="text-sm text-slate-600 mt-1">Cart to purchase</p>
              </div>

              <div class="text-center">
                <div class="relative inline-flex items-center justify-center">
                  <svg class="w-28 h-28 transform -rotate-90">
                    <circle cx="56" cy="56" r="48" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                    <circle cx="56" cy="56" r="48" stroke="#10b981" stroke-width="8" fill="none"
                      stroke-dasharray="301.59" stroke-dashoffset="30.16" stroke-linecap="round"></circle>
                  </svg>
                  <div class="absolute">
                    <div class="text-xl font-bold text-slate-900">90%</div>
                  </div>
                </div>
                <h4 class="mt-3 font-semibold text-slate-900">Stock Availability</h4>
                <p class="text-sm text-slate-600 mt-1">Products in stock</p>
              </div>
            </div>
          </div>
        </div>

        {{-- Right Rail --}}
        <aside class="space-y-6 min-w-0">
          {{-- Admin Profile Card --}}
          <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-sky-500 p-6 shadow-lg text-white">
            <div class="absolute inset-0 opacity-20">
              <div class="absolute -top-6 -left-6 w-32 h-32 rounded-full bg-blue-400 blur-3xl"></div>
              <div class="absolute bottom-0 right-0 w-40 h-40 rounded-full bg-sky-400 blur-2xl"></div>
            </div>

            <div class="relative flex flex-col items-center text-center">
              <div class="relative">
                <img src="{{ asset('images/adminlogo.png') }}"
                     class="h-24 w-24 rounded-full border-4 border-white shadow-md object-cover"
                     alt="admin">
                <span class="absolute bottom-2 right-2 h-4 w-4 rounded-full bg-emerald-400 ring-2 ring-white"></span>
              </div>

              <h2 class="mt-4 font-bold text-xl" id="adminProfileName">Loading...</h2>
              <p class="text-blue-100 text-sm">Store Administrator</p>

              <dl class="mt-6 grid grid-cols-2 gap-4 w-full">
                <div class="rounded-xl bg-white/10 p-4 shadow-inner backdrop-blur">
                  <dt class="text-blue-100 text-xs">Products Added</dt>
                  <dd class="text-white font-bold text-lg mt-1">{{ number_format($totalProducts) }}</dd>
                </div>
                <div class="rounded-xl bg-white/10 p-4 shadow-inner backdrop-blur">
                  <dt class="text-blue-100 text-xs">This Month</dt>
                  <dd class="text-white font-bold text-lg mt-1">$125k</dd>
                </div>
              </dl>

              <a href="{{ url('/admin/profile') }}"
                 class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur px-6 py-2 text-sm font-semibold text-white transition-all hover:bg-white/25">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7 7 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Profile
              </a>
            </div>
          </div>

          {{-- Quick Actions --}}
          <div class="rounded-2xl bg-gradient-to-br from-slate-100 to-indigo-100 border border-indigo-200 p-5 shadow-xl">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
              <a href="{{ url('/admin/products/create') }}"
                 class="group rounded-xl bg-white border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition-all text-center shadow-sm hover:border-purple-300 hover:text-purple-700 hover:bg-purple-50">
                <svg class="w-5 h-5 mx-auto mb-1 text-slate-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                </svg>
                Add Product
              </a>
              <a href="{{ url('/admin/orders') }}"
                 class="group rounded-xl bg-white border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition-all text-center shadow-sm hover:border-sky-300 hover:text-sky-700 hover:bg-sky-50">
                <svg class="w-5 h-5 mx-auto mb-1 text-slate-500 group-hover:text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                </svg>
                View Orders
              </a>
              <button onclick="openPromoModal()"
                 class="col-span-2 group rounded-xl bg-white border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 transition-all text-center shadow-sm hover:border-amber-300 hover:text-amber-700 hover:bg-amber-50">
                <svg class="w-5 h-5 mx-auto mb-1 text-slate-500 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 19L5 5m4 10a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
                Create Promo
              </button>
            </div>
          </div>

          {{-- Top Selling --}}
          <div class="rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-100 p-5 shadow-xl">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-slate-900">Top Selling</h3>
              <a href="{{ url('/admin/products') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">All →</a>
            </div>
            <ul class="space-y-3">
              <li class="flex items-center justify-between p-3 rounded-xl bg-white/80 backdrop-blur border border-indigo-100 hover:shadow-sm">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 grid place-items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4a2 2 0 012-2h0a2 2 0 012 2v2M6 10a6 6 0 1112 0v4a6 6 0 11-12 0v-4z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900">Razer DeathAdder V3</div>
                    <div class="text-xs text-slate-600">Gaming Mouse · 234 sold</div>
                  </div>
                </div>
                <span class="text-sm font-bold text-emerald-600">$149</span>
              </li>
              <li class="flex items-center justify-between p-3 rounded-xl bg-white/80 backdrop-blur border border-indigo-100 hover:shadow-sm">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-pink-100 text-pink-600 grid place-items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18v-6a9 9 0 1118 0v6M7 18h2a2 2 0 002-2v-2a2 2 0 00-2-2H7v6zm8 0h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2v6z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900">SteelSeries Arctis 7P</div>
                    <div class="text-xs text-slate-600">Headset · 189 sold</div>
                  </div>
                </div>
                <span class="text-sm font-bold text-emerald-600">$169</span>
              </li>
              <li class="flex items-center justify-between p-3 rounded-xl bg-white/80 backdrop-blur border border-indigo-100 hover:shadow-sm">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 grid place-items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2zm3 3h.01M7 13h.01M10 10h.01M10 13h.01M13 10h.01M13 13h.01M16 10h.01M16 13h.01"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-semibold text-slate-900">Corsair K70 RGB</div>
                    <div class="text-xs text-slate-600">Keyboard · 156 sold</div>
                  </div>
                </div>
                <span class="text-sm font-bold text-emerald-600">$159</span>
              </li>
            </ul>
          </div>

          {{-- Inventory Alerts --}}
          <div class="rounded-2xl bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-100 p-5 shadow-xl">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Inventory Alerts</h3>
            <ul class="space-y-3">
              <li class="flex items-start gap-3 p-3 rounded-xl bg-white/70 backdrop-blur border border-rose-100">
                <div class="h-8 w-8 rounded-lg bg-rose-100 text-rose-600 grid place-items-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.06 19h15.88c1.24 0 2.02-1.34 1.4-2.41L13.4 4.59c-.62-1.07-2.18-1.07-2.8 0L2.66 16.59C2.04 17.66 2.82 19 4.06 19z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-semibold text-slate-900">Low Stock Alert</p>
                  <p class="text-xs text-slate-600 mt-1">Logitech G Pro X - Only 5 units left</p>
                </div>
              </li>
              <li class="flex items-start gap-3 p-3 rounded-xl bg-white/70 backdrop-blur border border-amber-100">
                <div class="h-8 w-8 rounded-lg bg-amber-100 text-amber-600 grid place-items-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-semibold text-slate-900">Restock Needed</p>
                  <p class="text-xs text-slate-600 mt-1">HyperX Cloud II - Out of stock</p>
                </div>
              </li>
            </ul>
          </div>

          {{-- Industry Updates --}}
          <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-100 p-5 shadow-xl">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Industry Updates</h3>
            <div class="p-4 rounded-xl bg-white/70 backdrop-blur border border-emerald-100">
              <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white grid place-items-center flex-shrink-0">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                  </svg>
                </div>
                <div>
                  <h4 class="font-semibold text-slate-900 mb-1">New RGB Standards</h4>
                  <p class="text-sm text-slate-600">Major manufacturers agree on unified RGB ecosystem. This could streamline product compatibility.</p>
                  <a href="#" class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold mt-2 inline-block">Read more →</a>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </div>

      {{-- ===== Promo Modal ===== --}}
      <div id="promoModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" onclick="closePromoModal()"></div>
        <div class="relative mx-auto my-8 w-[92%] max-w-lg rounded-2xl bg-white shadow-2xl">
          <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Create Promotion</h3>
            <button class="p-2 rounded-lg hover:bg-slate-100" onclick="closePromoModal()">
              <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
          <div class="p-5 space-y-4">
            <div>
              <label class="text-sm font-medium text-slate-700">Promo Code</label>
              <input type="text" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="GAMING2024">
            </div>
            <div>
              <label class="text-sm font-medium text-slate-700">Discount (%)</label>
              <input type="number" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="20">
            </div>
            <div>
              <label class="text-sm font-medium text-slate-700">Valid Until</label>
              <input type="date" class="mt-2 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <button onclick="savePromo()" class="w-full rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2.5 text-sm font-semibold hover:from-purple-700 hover:to-pink-700 transition-all shadow">
              Create Promotion
            </button>
          </div>
        </div>
      </div>

      {{-- Toast notification --}}
      <div id="promoToast" class="fixed bottom-5 right-5 z-50 hidden">
        <div class="rounded-xl bg-slate-900 text-white text-sm px-4 py-2 shadow-lg">Promotion created successfully!</div>
      </div>

    </div> {{-- /overflow guard --}}
  </main>
</div>

@push('scripts')
  {{-- your chart init can stay in resources/js/admin.js --}}
@endpush
@vite('resources/js/admin.js')

{{-- ====== TOKEN → FETCH ADMIN NAME ====== --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("admin_token");
  if (!token) {
    // no token → back to admin login
    window.location.href = "/admin/login";
    return;
  }

  try {
    const res = await axios.get("/api/me", {
      headers: { Authorization: `Bearer ${token}` }
    });

    const name = res.data?.name || "Admin";
    const n1 = document.getElementById("adminName");
    const n2 = document.getElementById("adminProfileName");
    if (n1) n1.textContent = name;
    if (n2) n2.textContent = name;
  } catch (err) {
    console.error("Error loading admin profile:", err.response?.data || err.message);
    localStorage.removeItem("admin_token");
    window.location.href = "/admin/login";
  }
});
</script>
