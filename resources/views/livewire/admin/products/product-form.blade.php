{{-- Admin > Products > Form (Axios + API, SweetAlert2 toasts, live preview) --}}
<div class="min-h-screen bg-[radial-gradient(1200px_600px_at_0%_0%,#e6f0ff_0%,#ffffff_50%,#f8fafc_100%)] pt-28">
  @include('partials.admin.header')
  @include('partials.admin.sidebar')

  <main class="ml-0 md:ml-72 p-4 md:p-8">
    <div class="max-w-4xl mx-auto space-y-8">
      <div class="flex items-center justify-between">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-700 via-fuchsia-600 to-rose-500 bg-clip-text text-transparent">
          {{ isset($productId) && $productId ? 'Edit Product' : 'Create Product' }}
        </h1>

        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/80 backdrop-blur border border-slate-200 text-slate-700 shadow-sm hover:shadow-md transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Back to Products
        </a>
      </div>

      @if (session('success'))
        <div class="rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-4 shadow-sm">
          {{ session('success') }}
        </div>
      @endif

      <form id="productForm" enctype="multipart/form-data" onsubmit="saveProduct(event)"
            class="relative overflow-hidden rounded-[24px] p-6 md:p-7 space-y-8 bg-white/80 backdrop-blur-xl border border-slate-200 ring-1 ring-white/40 shadow-[0_14px_50px_rgba(30,41,59,0.12),0_2px_6px_rgba(30,41,59,0.06)]">
        <div class="pointer-events-none absolute inset-x-0 -top-10 h-16 bg-gradient-to-b from-white/70 to-transparent"></div>

        <input type="hidden" id="productId" name="productId" value="{{ $productId ?? '' }}">

        {{-- Name + Category --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="group">
            <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Product Name *</label>
            <div class="relative mt-2">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"/>
                </svg>
              </span>
              <input type="text" name="name" id="name" required
                     class="peer w-full pl-10 pr-4 py-3 rounded-2xl bg-white/90 text-slate-900 border-2 border-slate-200 shadow-inner focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 hover:border-indigo-200 transition">
            </div>
            <p id="err_name" class="mt-1 text-sm text-rose-600 hidden"></p>
          </div>

          <div class="group">
            <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Category *</label>
            <select name="category_id" id="category_id"
                    class="w-full mt-2 inline-flex items-center justify-between rounded-2xl px-4 py-3 bg-white/90 text-slate-900 border-2 border-slate-200 shadow-inner focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 hover:border-indigo-200 transition">
              <option value="">-- Select Category --</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
            <p id="err_category_id" class="mt-1 text-sm text-rose-600 hidden"></p>
          </div>
        </section>

        {{-- Description --}}
        <section class="group">
          <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Description</label>
          <textarea name="description" id="description" rows="4"
                    class="mt-2 w-full rounded-2xl px-4 py-3 bg-white/90 text-slate-900 placeholder-slate-400 border-2 border-slate-200 shadow-inner focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 hover:border-indigo-200 transition"
                    placeholder="Short description for store listing..."></textarea>
          <p id="err_description" class="mt-1 text-sm text-rose-600 hidden"></p>
        </section>

        {{-- Price + Stock --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="group">
            <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Price (LKR) *</label>
            <div class="relative mt-2">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 font-semibold">LKR</span>
              <input type="number" step="0.01" min="0" name="price" id="price" required
                     class="w-full pl-16 pr-4 py-3 rounded-2xl bg-white/90 text-slate-900 border-2 border-slate-200 shadow-inner focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 hover:border-indigo-200 transition"
                     placeholder="e.g. 29990.99">
            </div>
            <p id="err_price" class="mt-1 text-sm text-rose-600 hidden"></p>
          </div>

          <div class="group">
            <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Stock *</label>
            <div class="relative mt-2">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sky-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z"/>
                </svg>
              </span>
              <input type="number" min="0" name="stock" id="stock" required
                     class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white/90 text-slate-900 border-2 border-slate-200 shadow-inner focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 hover:border-indigo-200 transition"
                     placeholder="e.g. 50">
            </div>
            <p id="err_stock" class="mt-1 text-sm text-rose-600 hidden"></p>
          </div>
        </section>

        {{-- Images --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Upload new --}}
          <div id="uploadBox" class="rounded-2xl border-2 border-dashed border-indigo-200 bg-indigo-50/40">
            <div class="p-5">
              <div class="flex items-center justify-between mb-3">
                <span class="text-[13px] font-semibold tracking-wide text-slate-700">Upload Product Image</span>
                <span class="text-[11px] text-slate-500">PNG / JPG / WEBP (max 2MB)</span>
              </div>

              <label class="flex flex-col items-center justify-center gap-3 w-full cursor-pointer rounded-xl bg-white/70 backdrop-blur border border-slate-200 px-6 py-6 text-slate-700 shadow-sm hover:border-indigo-200 hover:shadow-md transition">
                <svg class="w-10 h-10 text-indigo-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <div class="text-center leading-tight">
                  <div class="font-semibold">Drop or click to browse</div>
                  <p class="text-xs text-slate-500">High-res square image recommended</p>
                </div>
                <input type="file" class="hidden" name="image" id="image" accept="image/*">
              </label>
              <p id="err_image" class="mt-3 text-sm text-rose-600 hidden"></p>

              {{-- Live preview target --}}
              <div id="newImagePreview" class="mt-3"></div>
            </div>
          </div>

          {{-- Current image --}}
          @if (!empty($existingImage))
            <div class="rounded-2xl border border-slate-200 bg-white/80 backdrop-blur p-5 shadow-sm">
              <p class="text-[13px] font-semibold tracking-wide text-slate-700 mb-3">Current Image</p>
              <div class="rounded-2xl overflow-hidden ring-1 ring-slate-200">
                <img src="{{ asset('storage/'.$existingImage) }}" class="w-full h-48 object-cover">
              </div>
            </div>
          @endif
        </section>

        <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

        <div class="flex items-center gap-3">
          <button type="submit"
                  class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-rose-500 hover:from-indigo-700 hover:via-fuchsia-700 hover:to-rose-600 text-white font-semibold shadow-lg shadow-indigo-500/30 transition active:scale-[.99]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
            <span>{{ isset($productId) && $productId ? 'Update Product' : 'Create Product' }}</span>
          </button>
          <span id="savingHint" class="text-xs text-slate-500 hidden">Saving…</span>
        </div>
      </form>
    </div>
  </main>
</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Axios save + (for edit) prefill + live preview --}}
<script>
let saving = false;

function setErrors(errors = {}) {
  const keys = ['name','price','stock','category_id','description','image'];
  keys.forEach(k => {
    const el = document.getElementById('err_' + k);
    if (!el) return;
    if (errors[k]) {
      el.textContent = Array.isArray(errors[k]) ? errors[k][0] : String(errors[k]);
      el.classList.remove('hidden');
    } else {
      el.textContent = '';
      el.classList.add('hidden');
    }
  });
}

async function saveProduct(e) {
  e.preventDefault();
  if (saving) return;
  saving = true;

  setErrors({});
  document.getElementById('savingHint').classList.remove('hidden');

  const id   = (document.getElementById('productId')?.value || '').trim();
  const form = document.getElementById('productForm');
  const fd   = new FormData(form);
  fd.delete('productId'); // not a DB column

  try {
    if (id) {
      // PATCH with multipart/form-data
      fd.append('_method', 'PATCH');
      await axios.post(`/api/admin-products/${id}`, fd, { headers: { 'Content-Type': 'multipart/form-data' }});
      await Swal.fire({ icon: 'success', title: 'Product updated', timer: 1500, showConfirmButton: false });
    } else {
      await axios.post(`/api/admin-products`, fd, { headers: { 'Content-Type': 'multipart/form-data' }});
      await Swal.fire({ icon: 'success', title: 'Product created', timer: 1500, showConfirmButton: false });
    }
    window.location.href = "{{ route('admin.products.index') }}";
  } catch (err) {
    const data = err.response?.data || {};
    if (data.errors) setErrors(data.errors);
    console.error('Save error:', data);
    Swal.fire('Error', data.message || 'Error saving product', 'error');
  } finally {
    saving = false;
    document.getElementById('savingHint').classList.add('hidden');
  }
}

document.addEventListener('DOMContentLoaded', async () => {
  // Prefill on edit
  const id = (document.getElementById('productId')?.value || '').trim();
  if (id) {
    try {
      const res = await axios.get(`/api/admin-products/${id}`);
      const p   = res.data;

      document.getElementById('name').value        = p.name ?? '';
      document.getElementById('description').value = p.description ?? '';
      document.getElementById('price').value       = (p.price || '').toString().replace(/,/g,'');
      document.getElementById('stock').value       = p.stock ?? 0;

      const catSelect = document.getElementById('category_id');
      if (catSelect) {
        if (p.category_id) {
          catSelect.value = p.category_id;
        } else if (p.category) {
          [...catSelect.options].forEach(opt => {
            if (opt.text.trim().toLowerCase() === String(p.category).trim().toLowerCase()) {
              catSelect.value = opt.value;
            }
          });
        }
      }
    } catch (e) {
      console.error('Prefill error:', e.response?.data || e.message);
    }
  }

  // Live preview when selecting a new file
  const imageInput = document.getElementById('image');
  const mount      = document.getElementById('newImagePreview');
  if (imageInput) {
    imageInput.addEventListener('change', function (ev) {
      if (!mount) return;
      const file = ev.target.files?.[0];
      if (!file) { mount.innerHTML = ''; return; }
      const url = URL.createObjectURL(file);
      mount.innerHTML = `
        <div class="mt-4 rounded-2xl overflow-hidden ring-1 ring-slate-200">
          <img src="${url}" class="w-full h-48 object-cover">
        </div>
      `;
    });
  }
});
</script>
