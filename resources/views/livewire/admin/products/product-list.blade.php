{{-- Admin > Products (Axios + API; glass UI + SweetAlert + Category Filter + Chip) --}}
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

            {{-- Controls --}}
            <section class="rounded-3xl p-6 md:p-8 border border-slate-300/80 bg-white/60 backdrop-blur-xl shadow-[0_14px_40px_rgba(2,6,23,0.10)]">
                <div class="flex flex-col 2xl:flex-row 2xl:items-center 2xl:justify-between gap-4 md:gap-6 mb-4 md:mb-6">

                    {{-- LEFT: Search + Category --}}
                    <div class="flex flex-col lg:flex-row gap-3 lg:items-center flex-1">
                        {{-- Search --}}
                        <div class="relative flex-1 max-w-3xl">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search by name or category..."
                                class="w-full pl-12 pr-4 py-3 rounded-2xl border-2 border-slate-300 bg-white text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300"
                            />
                        </div>

                        {{-- Category filter (built from loaded products) --}}
                        <div class="min-w-[220px]">
                            <select id="categoryFilter"
                                    class="w-full rounded-2xl border-2 border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                <option value="">All categories</option>
                            </select>
                        </div>
                    </div>

                    {{-- RIGHT: Per Page (UI only for now) --}}
                    <div class="flex items-center gap-3 px-5 py-2.5 bg-slate-900 text-slate-200 rounded-2xl border border-slate-700 shadow-lg">
                        <span class="text-sm font-semibold">Show</span>
                        <select id="perPage" class="rounded-xl border border-slate-600 bg-slate-800 text-slate-200 px-4 py-2.5 text-sm font-medium focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40 transition-all duration-300">
                            <option class="text-black" value="12" selected>12</option>
                            <option class="text-black" value="24">24</option>
                            <option class="text-black" value="48">48</option>
                        </select>
                        <span class="text-sm font-semibold">per page</span>
                    </div>
                </div>

                {{-- Active filter chip (shows when a category is selected) --}}
                <div id="filterChipWrap" class="mb-4 hidden">
                    <span class="inline-flex items-center gap-2 rounded-full bg-indigo-100 text-indigo-700 px-4 py-2 text-sm font-semibold">
                        Filtered by: <span id="chipCategory"></span>
                        <button id="clearCategory"
                                class="ml-1 grid place-items-center rounded-full hover:bg-indigo-200 w-6 h-6">
                            ×
                        </button>
                    </span>
                </div>

                {{-- ========== MOBILE CARDS (< md) ========== --}}
                <div id="productsCards" class="md:hidden space-y-4"></div>

                {{-- ========== DESKTOP TABLE (md+) ========== --}}
                <div class="hidden md:block overflow-x-auto rounded-3xl border border-slate-300 bg-white/70 backdrop-blur-xl shadow-[0_16px_40px_rgba(2,6,23,0.12)]">
                    {{-- Header --}}
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
                                <th class="px-4 py-5 text-center">Category</th>
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
                        <tbody id="productsTableBody" class="divide-y divide-slate-200"></tbody>
                    </table>

                    <div class="h-4 w-full bg-gradient-to-r from-slate-100 via-white to-slate-100 rounded-b-3xl border-t border-slate-200"></div>
                </div>

                {{-- Simple pager --}}
                <div class="mt-6 flex items-center justify-between">
                    <button id="prevPage" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold">Prev</button>
                    <div class="text-sm text-slate-600">Page <span id="pageNum">1</span></div>
                    <button id="nextPage" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold">Next</button>
                </div>
            </section>
        </div>
    </main>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/** Base URLs from Laravel (plain strings to avoid VS Code 'decorators' lint) */
const API_BASE       = "{{ url('/api') }}";
const EDIT_URL_BASE  = "{{ route('admin.products.edit', ['product' => '__ID__']) }}";
const INITIAL_CAT_ID = "{{ request()->query('category', '') }}";

let currentPage = 1;
let lastPage    = 1;
let cache       = []; // current page items
let currentCategory = ""; // UI-selected category text

const currency = (v) => v == null ? '—' : 'LKR ' + v;

// SweetAlert toast helper
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1800,
  timerProgressBar: true
});

/* ---------- render (desktop) ---------- */
function renderDesktop(items) {
  const body = document.getElementById('productsTableBody');
  body.innerHTML = '';

  items.forEach(p => {
    const img = p.image_url
      ? `<img src="${p.image_url}" alt="${p.name}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">`
      : `<svg viewBox="0 0 64 64" class="h-full w-full text-slate-300"><rect width="64" height="64" fill="currentColor"/><g fill="#fff"><circle cx="22" cy="24" r="8" opacity=".9"/><path d="M8 52l14-14 8 8 12-12 14 18H8z" opacity=".95"/></g></svg>`;

    const editHref = EDIT_URL_BASE.replace('__ID__', p.id);

    body.insertAdjacentHTML('beforeend', `
      <tr class="group transition-colors odd:bg-white even:bg-slate-50 odd:shadow-[inset_6px_0_0_0_rgba(99,102,241,0.45)] even:shadow-[inset_6px_0_0_0_rgba(239,68,68,0.45)] hover:bg-white/90">
        <td class="px-4 py-5 align-middle">
          <div class="h-20 w-20 rounded-xl overflow-hidden bg-slate-100 ring-1 ring-slate-200 mx-auto">${img}</div>
        </td>
        <td class="px-4 py-5 align-middle">
          <div class="font-semibold text-slate-900 text-[15px]">${p.name}</div>
          <div class="text-xs text-slate-500 line-clamp-1">${p.description ?? ''}</div>
        </td>
        <td class="px-4 py-5 align-middle text-center">
          ${p.category ? `<span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">${p.category}</span>` : '<span class="text-slate-400 text-sm">—</span>'}
        </td>
        <td class="px-4 py-5 align-middle text-center">
          ${(Number(p.stock) > 0)
            ? `<span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">${p.stock} in stock</span>`
            : `<span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">Out of stock</span>`}
        </td>
        <td class="px-4 py-5 align-middle text-center">
          <div class="inline-flex items-baseline gap-1 font-bold text-slate-900 tabular-nums">
            <span class="text-[18px] leading-none">${currency(p.price)}</span>
          </div>
        </td>
        <td class="px-4 py-5 align-middle text-center">
          <div class="inline-flex items-center gap-3">
            <a href="${editHref}"
               class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold transition">
              Update
            </a>
            <button onclick="deleteProduct(${p.id})"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold transition">
              Delete
            </button>
          </div>
        </td>
      </tr>
    `);
  });
}

/* ---------- render (mobile) ---------- */
function renderMobile(items) {
  const cards = document.getElementById('productsCards');
  cards.innerHTML = '';

  items.forEach(p => {
    const editHref = EDIT_URL_BASE.replace('__ID__', p.id);
    const imgUrl = p.image_url;
    cards.insertAdjacentHTML('beforeend', `
      <div class="rounded-3xl border border-slate-300 bg-white shadow-md p-4 group">
        <div class="flex gap-3">
          <div class="h-24 w-24 rounded-xl overflow-hidden bg-slate-100 ring-1 ring-slate-200 flex-shrink-0">
            ${imgUrl
              ? `<img src="${imgUrl}" alt="${p.name}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">`
              : `<svg viewBox="0 0 64 64" class="h-full w-full text-slate-300"><rect width="64" height="64" fill="currentColor"/><g fill="#fff"><circle cx="22" cy="24" r="8" opacity=".9"/><path d="M8 52l14-14 8 8 12-12 14 18H8z" opacity=".95"/></g></svg>`}
          </div>
          <div class="flex-1 min-w-0">
            <div class="font-semibold text-slate-900 truncate">${p.name}</div>
            ${p.category ? `<span class="inline-block mt-1 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">${p.category}</span>` : ''}
          </div>
          <div class="hidden xs:block">
            ${(Number(p.stock) > 0)
              ? `<span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">${p.stock} in stock</span>`
              : `<span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold">Out of stock</span>`}
          </div>
        </div>

        <div class="mt-3 flex items-center justify-between">
          <div class="font-bold text-slate-900 tabular-nums">
            <span class="text-xs text-slate-500">LKR</span>
            <span class="text-lg leading-none">${p.price ?? '0'}</span>
          </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3">
          <a href="${editHref}"
             class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md">
            Update
          </a>
          <button onclick="deleteProduct(${p.id})"
                  class="inline-flex items-center justify-center px-4 py-3 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold shadow-md">
            Delete
          </button>
        </div>
      </div>
    `);
  });
}

/* ---------- category options + chip ---------- */
function rebuildCategoryOptions() {
  const sel = document.getElementById('categoryFilter');
  const keep = currentCategory;
  const set = new Set();
  cache.forEach(p => { if (p.category) set.add(String(p.category)); });

  // rebuild options
  sel.innerHTML = `<option value="">All categories</option>`;
  [...set].sort().forEach(name => {
    const opt = document.createElement('option');
    opt.value = name; opt.textContent = name;
    sel.appendChild(opt);
  });

  // restore selection if still present
  if (keep && set.has(keep)) {
    sel.value = keep;
  } else if (!set.has(keep)) {
    currentCategory = "";
    sel.value = "";
  }
  updateFilterChip();
}

function updateFilterChip() {
  const wrap = document.getElementById('filterChipWrap');
  const chipText = document.getElementById('chipCategory');
  if (currentCategory) {
    chipText.textContent = currentCategory;
    wrap.classList.remove('hidden');
  } else {
    wrap.classList.add('hidden');
  }
}

/* ---------- fetch + filter ---------- */
async function fetchProducts(page = 1) {
  try {
    const url = new URL(API_BASE + '/admin-products', window.location.origin);
    url.searchParams.set('page', page);
    if (INITIAL_CAT_ID) url.searchParams.set('category', INITIAL_CAT_ID);

    const res  = await axios.get(url.toString());
    const data = res.data;

    cache       = data.data || [];
    currentPage = data.current_page || 1;
    lastPage    = data.last_page || 1;

    rebuildCategoryOptions();
    applyFilterAndRender();
    document.getElementById('pageNum').textContent = currentPage;
  } catch (err) {
    console.error('Error fetching products:', err.response?.data || err.message);
    Swal.fire('Error', 'Failed to load products', 'error');
  }
}

function applyFilterAndRender() {
  const q = (document.getElementById('searchInput').value || '').toLowerCase().trim();
  let rows = cache.slice();

  if (q) {
    rows = rows.filter(p =>
      String(p.name || '').toLowerCase().includes(q) ||
      String(p.category || '').toLowerCase().includes(q)
    );
  }
  if (currentCategory) {
    rows = rows.filter(p => String(p.category || '').toLowerCase() === currentCategory.toLowerCase());
  }

  renderDesktop(rows);
  renderMobile(rows);
  updateFilterChip();
}

/* ---------- delete ---------- */
async function deleteProduct(id) {
  const c = await Swal.fire({
    icon: 'warning',
    title: 'Delete this product?',
    text: 'This cannot be undone.',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete',
    cancelButtonText: 'Cancel'
  });
  if (!c.isConfirmed) return;

  try {
    await axios.delete(`${API_BASE}/admin-products/${id}`);
    Toast.fire({ icon: 'success', title: 'Product deleted' });
    fetchProducts(currentPage);
  } catch (err) {
    console.error('Delete error:', err.response?.data || err.message);
    Swal.fire('Error', 'Failed to delete', 'error');
  }
}

/* ---------- init ---------- */
document.addEventListener('DOMContentLoaded', () => {
  fetchProducts(1);

  document.getElementById('searchInput').addEventListener('input', applyFilterAndRender);

  document.getElementById('categoryFilter').addEventListener('change', (e) => {
    currentCategory = e.target.value || "";
    applyFilterAndRender();
  });

  document.getElementById('clearCategory').addEventListener('click', () => {
    currentCategory = "";
    document.getElementById('categoryFilter').value = "";
    applyFilterAndRender();
  });

  document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) fetchProducts(currentPage - 1);
  });
  document.getElementById('nextPage').addEventListener('click', () => {
    if (currentPage < lastPage) fetchProducts(currentPage + 1);
  });

  document.getElementById('perPage').addEventListener('change', () => fetchProducts(1));
});
</script>
