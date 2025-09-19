{{-- Admin > Products > Form (Create / Edit) — Blue Glass Premium (compact + custom category dropdown) --}}
<div class="min-h-screen bg-[radial-gradient(1200px_600px_at_0%_0%,#e6f0ff_0%,#ffffff_50%,#f8fafc_100%)] pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-4xl mx-auto space-y-8">
            {{-- Title / Back --}}
            <div class="flex items-center justify-between">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-700 via-fuchsia-600 to-rose-500 bg-clip-text text-transparent">
                    {{ $productId ? 'Edit Product' : 'Create Product' }}
                </h1>

                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl
                          bg-white/80 backdrop-blur border border-slate-200
                          text-slate-700 shadow-sm hover:shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Products
                </a>
            </div>

            {{-- Flash --}}
            @if (session('success'))
                <div class="rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 px-5 py-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Glass Card --}}
            <form wire:submit.prevent="save" enctype="multipart/form-data"
                  class="relative overflow-hidden rounded-[24px] p-6 md:p-7 space-y-8
                         bg-white/80 backdrop-blur-xl
                         border border-slate-200 ring-1 ring-white/40
                         shadow-[0_14px_50px_rgba(30,41,59,0.12),0_2px_6px_rgba(30,41,59,0.06)]">

                {{-- Soft top sheen --}}
                <div class="pointer-events-none absolute inset-x-0 -top-10 h-16 bg-gradient-to-b from-white/70 to-transparent"></div>

                {{-- Name + Category --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Name (NO placeholder) --}}
                    <div class="group">
                        <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Product Name *</label>
                        <div class="relative mt-2">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18M3 19h18"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                wire:model.lazy="name"
                                class="peer w-full pl-10 pr-4 py-3 rounded-2xl
                                       bg-white/90 text-slate-900
                                       border-2 border-slate-200 shadow-inner
                                       focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20
                                       hover:border-indigo-200 transition">
                        </div>
                        @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Category (Custom dropdown; shows current selection on edit) --}}
                    <div
                        x-data="{
                            open: false,
                            selectedId: @entangle('category_id'),
                            labelMap: { @foreach($categories as $c) '{{ $c->id }}': @js($c->name), @endforeach },
                            isSelected(id){ return String(this.selectedId) === String(id); }
                        }"
                        @click.outside="open=false"
                        class="group"
                    >
                        <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Category *</label>

                        <button type="button"
                                @click="open = !open"
                                class="w-full mt-2 inline-flex items-center justify-between rounded-2xl px-4 py-3
                                       bg-white/90 text-slate-900 border-2 border-slate-200 shadow-inner
                                       focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20
                                       hover:border-indigo-200 transition">
                            <span x-text="selectedId ? labelMap[String(selectedId)] : '-- Select Category --'"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="relative">
                            <ul class="absolute z-20 mt-2 w-full max-h-60 overflow-auto
                                       rounded-2xl border border-slate-200 bg-white/95 backdrop-blur shadow-xl">
                                <li>
                                    <button type="button"
                                            @click="selectedId=null; open=false; $wire.set('category_id', null)"
                                            class="w-full text-left px-4 py-2.5 text-slate-500 hover:bg-indigo-50">
                                        -- Select Category --
                                    </button>
                                </li>

                                @foreach ($categories as $cat)
                                    <li>
                                        <button type="button"
                                                @click="selectedId='{{ $cat->id }}'; open=false; $wire.set('category_id', '{{ $cat->id }}')"
                                                class="w-full text-left px-4 py-2.5 hover:bg-indigo-50"
                                                :class="isSelected('{{ $cat->id }}') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700'">
                                            {{ $cat->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @error('category_id') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </section>

                {{-- Description --}}
                <section class="group">
                    <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Description</label>
                    <textarea
                        wire:model.lazy="description" rows="4"
                        class="mt-2 w-full rounded-2xl px-4 py-3
                               bg-white/90 text-slate-900 placeholder-slate-400
                               border-2 border-slate-200 shadow-inner
                               focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20
                               hover:border-indigo-200 transition"
                        placeholder="Short description for store listing..."></textarea>
                    @error('description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </section>

                {{-- Price + Stock --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Price --}}
                    <div class="group">
                        <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Price (LKR) *</label>
                        <div class="relative mt-2">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-indigo-600 font-semibold">LKR</span>
                            <input
                                type="number" step="0.01" min="0" wire:model.lazy="price"
                                class="w-full pl-16 pr-4 py-3 rounded-2xl
                                       bg-white/90 text-slate-900
                                       border-2 border-slate-200 shadow-inner
                                       focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20
                                       hover:border-indigo-200 transition"
                                placeholder="e.g. 29990.99">
                        </div>
                        @error('price') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="group">
                        <label class="block text-[13px] font-semibold tracking-wide text-slate-600">Stock *</label>
                        <div class="relative mt-2">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sky-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z"/>
                                </svg>
                            </span>
                            <input
                                type="number" min="0" wire:model.lazy="stock"
                                class="w-full pl-12 pr-4 py-3 rounded-2xl
                                       bg-white/90 text-slate-900
                                       border-2 border-slate-200 shadow-inner
                                       focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20
                                       hover:border-indigo-200 transition"
                                placeholder="e.g. 50">
                        </div>
                        @error('stock') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </section>

                {{-- Images --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Upload new (blue glass) --}}
                    <div
                        x-data="{ dragging: false }"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false"
                        class="rounded-2xl border-2 border-dashed transition"
                        :class="dragging ? 'border-indigo-300 bg-indigo-50/60' : 'border-indigo-200 bg-indigo-50/40'">

                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[13px] font-semibold tracking-wide text-slate-700">Upload Product Image</span>
                                <span class="text-[11px] text-slate-500">PNG / JPG / WEBP (max 2MB)</span>
                            </div>

                            <label class="flex flex-col items-center justify-center gap-3 w-full cursor-pointer rounded-xl
                                          bg-white/70 backdrop-blur border border-slate-200 px-6 py-6
                                          text-slate-700 shadow-sm hover:border-indigo-200 hover:shadow-md transition">
                                <svg class="w-10 h-10 text-indigo-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <div class="text-center leading-tight">
                                    <div class="font-semibold">Drop or click to browse</div>
                                    <p class="text-xs text-slate-500">High-res square image recommended</p>
                                </div>
                                <input type="file" class="hidden" wire:model="image" accept="image/*">
                            </label>

                            @error('image') <p class="mt-3 text-sm text-rose-600">{{ $message }}</p> @enderror

                            {{-- Uploading bar --}}
                            <div wire:loading wire:target="image" class="mt-4">
                                <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-2 w-1/2 bg-indigo-500 animate-pulse"></div>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Uploading…</p>
                            </div>

                            {{-- Preview --}}
                            @if ($image)
                                <div class="mt-4">
                                    <img src="{{ $image->temporaryUrl() }}"
                                         class="rounded-2xl border border-slate-200 shadow-md max-h-48 object-cover w-full">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Current image --}}
                    @if ($existingImage)
                        <div class="rounded-2xl border border-slate-200 bg-white/80 backdrop-blur p-5 shadow-sm">
                            <p class="text-[13px] font-semibold tracking-wide text-slate-700 mb-3">Current Image</p>
                            <div class="rounded-2xl overflow-hidden ring-1 ring-slate-200">
                                <img src="{{ asset('storage/'.$existingImage) }}" class="w-full h-48 object-cover">
                            </div>
                        </div>
                    @endif
                </section>

                {{-- Divider --}}
                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                {{-- Submit --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-6 py-3 rounded-2xl
                                   bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-rose-500
                                   hover:from-indigo-700 hover:via-fuchsia-700 hover:to-rose-600
                                   text-white font-semibold shadow-lg shadow-indigo-500/30 transition active:scale-[.99]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        <span>{{ $productId ? 'Update Product' : 'Create Product' }}</span>
                    </button>
                    <span wire:loading.delay class="text-xs text-slate-500">Saving…</span>
                </div>
            </form>
        </div>
    </main>
</div>
