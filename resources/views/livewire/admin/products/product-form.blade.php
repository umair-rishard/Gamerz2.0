{{-- Admin > Products > Form (Create / Edit) --}}
<div class="min-h-screen bg-white pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-6">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $productId ? 'Edit Product' : 'Create Product' }}
                </h1>

                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold">
                    ← Back to Products
                </a>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="save"
                  class="bg-white/90 rounded-2xl border border-slate-200 shadow p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Product Name *</label>
                    <input type="text" wire:model.lazy="name"
                           class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Description</label>
                    <textarea wire:model.lazy="description" rows="4"
                              class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Price + Stock --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Price *</label>
                        <input type="number" step="0.01" wire:model.lazy="price"
                               class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('price') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Stock *</label>
                        <input type="number" wire:model.lazy="stock"
                               class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('stock') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Category *</label>
                    <select wire:model="category_id"
                            class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Image --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Product Image</label>
                        <input type="file" wire:model="image"
                               class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('image') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror

                        @if ($image)
                            <p class="mt-2 text-sm text-slate-600">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" class="mt-1 max-h-40 rounded-lg border">
                        @endif
                    </div>

                    @if ($existingImage)
                        <div>
                            <p class="text-sm text-slate-700">Current image</p>
                            <img src="{{ asset('storage/'.$existingImage) }}" class="mt-1 max-h-40 rounded-lg border">
                        </div>
                    @endif
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">
                        {{ $productId ? 'Update Product' : 'Create Product' }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
