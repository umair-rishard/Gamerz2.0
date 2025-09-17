{{-- Admin > Categories > Form (Create / Edit) --}}
<div class="min-h-screen bg-white pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-6">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $categoryId ? 'Edit Category' : 'Create Category' }}
                </h1>

                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold">
                    ← Back to Categories
                </a>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="save" enctype="multipart/form-data"
                class="bg-white/90 rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(2,6,23,0.06)] p-6 space-y-5">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Category Name *</label>
                    <input type="text" wire:model.lazy="name"
                           class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Status (In Stock / Out of Stock) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Status *</label>
                    <select wire:model="status"
                            class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="1">In Stock</option>
                        <option value="0">Out of Stock</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Image --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Category Image (optional)</label>
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
                        {{ $categoryId ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
