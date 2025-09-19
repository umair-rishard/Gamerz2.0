{{-- Admin > Categories > Form (Create / Edit) --}}
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-3xl mx-auto space-y-8">
            {{-- Title + Back --}}
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-700 via-purple-600 to-pink-600 bg-clip-text text-transparent drop-shadow-sm">
                    {{ $categoryId ? 'Edit Category' : 'Create Category' }}
                </h1>

                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center px-5 py-2.5 rounded-2xl bg-gradient-to-r from-slate-200 to-slate-300 hover:from-slate-300 hover:to-slate-400 text-slate-800 font-semibold shadow-md hover:shadow-lg transition-all duration-300">
                    ← Back to Categories
                </a>
            </div>

            {{-- Flash message --}}
            @if (session('success'))
                <div class="rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-4 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Form --}}
            <form wire:submit.prevent="save" enctype="multipart/form-data"
                  class="bg-white/90 rounded-3xl border border-indigo-200 shadow-2xl shadow-indigo-100 p-8 space-y-6 backdrop-blur-sm">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Category Name *</label>
                    <input type="text" wire:model.lazy="name"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white/95 px-4 py-2.5 shadow-sm
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 transition-all duration-300">
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Status *</label>
                    <select wire:model="status"
                            class="mt-1 w-full rounded-xl border border-slate-300 bg-gradient-to-r from-slate-50 to-white px-4 py-2.5 text-slate-800 shadow-inner
                            focus:border-indigo-500 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1 hover:border-indigo-400 transition-all duration-300">
                        <option value="1">In Stock</option>
                        <option value="0">Out of Stock</option>
                    </select>
                    @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Image Upload --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- New Upload --}}
                    <div class="p-5 rounded-2xl border-2 border-dashed border-indigo-300 bg-indigo-50/40 hover:bg-indigo-50 transition shadow-sm">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Category Image</label>
                        <input type="file" wire:model="image"
                               class="block w-full text-sm text-slate-700 file:mr-4 file:py-2.5 file:px-4
                               file:rounded-xl file:border-0 file:text-sm file:font-semibold
                               file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer shadow-sm">
                        @error('image') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror

                        @if ($image)
                            <div class="mt-4">
                                <p class="text-sm text-slate-600 font-medium">Preview:</p>
                                <img src="{{ $image->temporaryUrl() }}"
                                     class="mt-2 rounded-2xl border border-slate-200 shadow-md max-h-44 object-cover">
                            </div>
                        @endif
                    </div>

                    {{-- Existing Image --}}
                    @if ($existingImage)
                        <div class="p-5 rounded-2xl border border-slate-200 bg-white shadow-lg">
                            <p class="text-sm text-slate-700 font-medium mb-2">Current Image</p>
                            <img src="{{ asset('storage/'.$existingImage) }}"
                                 class="rounded-2xl border border-slate-200 shadow-md max-h-44 object-cover">
                        </div>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="pt-6">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center px-6 py-3 rounded-2xl
                                   bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700
                                   text-white font-semibold shadow-xl hover:shadow-2xl transition-all duration-300">
                        {{ $categoryId ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
