{{-- Admin > Products List --}}
<div class="min-h-screen bg-white pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-6">
        <div class="max-w-7xl mx-auto space-y-6">
            {{-- Title + Create --}}
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-slate-900">Products</h1>

                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">
                    + Add Product
                </a>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Card --}}
            <section class="bg-white/90 rounded-2xl border border-slate-200 shadow p-4 md:p-6">
                {{-- Controls --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <input
                        type="text"
                        placeholder="Search products…"
                        class="w-full md:w-[36rem] rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                        wire:model.debounce.300ms="search"
                    />

                    <div class="flex items-center gap-2">
                        <label class="text-sm text-slate-600">Per page</label>
                        <select wire:model="perPage"
                                class="rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>

                {{-- Table --}}
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left border-collapse bg-white rounded-xl shadow-sm">
                        <thead>
                            <tr class="text-slate-600 text-sm border-b bg-slate-50">
                                <th class="py-3 px-4 font-semibold">ID</th>
                                <th class="py-3 px-4 font-semibold">Name</th>
                                <th class="py-3 px-4 font-semibold">Category</th>
                                <th class="py-3 px-4 font-semibold">Price</th>
                                <th class="py-3 px-4 font-semibold">Stock</th>
                                <th class="py-3 px-4 font-semibold">Created</th>
                                <th class="py-3 px-4 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($products as $product)
                                <tr class="text-slate-800 hover:bg-indigo-50 transition" wire:key="row-{{ $product->id }}">
                                    <td class="py-3 px-4">{{ $product->id }}</td>
                                    <td class="py-3 px-4 font-medium">{{ $product->name }}</td>
                                    <td class="py-3 px-4">
                                        {{ $product->category?->name ?? '—' }}
                                    </td>
                                    <td class="py-3 px-4">LKR {{ number_format($product->price, 2) }}</td>
                                    <td class="py-3 px-4">{{ $product->stock }}</td>
                                    <td class="py-3 px-4 text-slate-600">{{ $product->created_at?->format('Y-m-d') }}</td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                               class="px-3 py-1.5 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 text-sm font-semibold">
                                                Edit
                                            </a>
                                            <button
                                                x-data
                                                @click.prevent="if (confirm('Delete this product?')) { $wire.delete({{ $product->id }}) }"
                                                class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-slate-500">
                                        No products found. Try searching.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>
