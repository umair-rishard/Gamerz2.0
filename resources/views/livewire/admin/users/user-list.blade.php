<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-50 pt-28">
    {{-- Header + Sidebar --}}
    @include('partials.admin.header')
    @include('partials.admin.sidebar')

    <main class="ml-0 md:ml-72 p-4 md:p-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- Title --}}
            <div class="flex items-center justify-between">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-600 to-purple-600 text-transparent bg-clip-text">
                    Manage Users
                </h1>
            </div>

            {{-- Search + Total --}}
            <section class="rounded-3xl p-6 md:p-8 border border-slate-200 bg-white/90 backdrop-blur-xl shadow-xl">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <input
                        type="text"
                        wire:model.live="search"
                        placeholder="Search users by name or email..."
                        class="w-full md:w-96 px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    />
                    <span class="shrink-0 px-4 py-2 rounded-full bg-slate-900 text-white text-xs font-semibold shadow">
                        Total: {{ $totalUsers }}
                    </span>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block overflow-x-auto">
                    <div class="rounded-3xl shadow-[0_10px_30px_-12px_rgba(0,0,0,0.25)] overflow-hidden border border-slate-200">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-900 text-white uppercase text-[11px] tracking-wider sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 text-left">User</th>
                                    <th class="px-6 py-4 text-left">Registered</th>
                                    <th class="px-6 py-4 text-left">Last Login</th>
                                    <th class="px-6 py-4 text-center">Total Orders</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @forelse ($users as $user)
                                    <tr class="odd:bg-white even:bg-slate-50 hover:bg-indigo-50 hover:shadow-sm transition">
                                        {{-- User --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($user->profile_photo_path)
                                                    <img src="{{ $user->profile_photo_url }}"
                                                        alt="{{ $user->name }}"
                                                        class="w-10 h-10 rounded-full object-cover shadow">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div>
                                                    <div class="font-semibold text-slate-800">{{ $user->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Registered --}}
                                        <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>

                                        {{-- Last Login --}}
                                        <td class="px-6 py-4">{{ $user->last_login?->format('d M Y H:i') ?? '—' }}</td>

                                        {{-- Total Orders with badges --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($user->orders_count == 0)
                                                <span class="px-3 py-1 rounded-full bg-slate-200 text-slate-600 text-xs font-semibold">0</span>
                                            @elseif($user->orders_count < 5)
                                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold">{{ $user->orders_count }}</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-xs font-semibold">{{ $user->orders_count }}</span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-4 text-center">
                                            <div x-data="{
                                                confirmDelete(id) {
                                                    const run = () => $wire.delete(id);
                                                    if (window.Swal) {
                                                        window.Swal.fire({
                                                            title: 'Delete this user?',
                                                            text: 'This action cannot be undone.',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#d33',
                                                            cancelButtonColor: '#6b7280',
                                                            confirmButtonText: 'Yes, delete'
                                                        }).then(r => { if (r.isConfirmed) run(); });
                                                    } else {
                                                        if (confirm('Delete this user?')) run();
                                                    }
                                                }
                                            }">
                                                <button
                                                    @click.prevent="confirmDelete({{ $user->id }})"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-500 text-white font-medium hover:bg-red-600 shadow transition"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h10"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            <div class="flex flex-col items-center">
                                                <img src="https://www.svgrepo.com/show/530428/empty-box.svg" class="w-24 h-24 mb-4 opacity-70" alt="empty">
                                                <p class="text-lg font-medium">No users found</p>
                                                <p class="text-sm text-slate-400">Try adjusting your search or filters</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>

                {{-- MOBILE CARDS --}}
                <div class="grid gap-4 md:hidden">
                    @forelse ($users as $user)
                        <div class="rounded-2xl border border-slate-200 bg-white shadow hover:shadow-lg transition transform hover:scale-[1.01] p-4">
                            <div class="flex items-center gap-3">
                                @if ($user->profile_photo_path)
                                    <img src="{{ $user->profile_photo_url }}"
                                        alt="{{ $user->name }}"
                                        class="w-12 h-12 rounded-full object-cover shadow">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <div class="text-base font-semibold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>

                            <div class="mt-3 text-sm text-slate-600 space-y-1">
                                <p>📅 <span class="font-medium">Registered:</span> {{ $user->created_at->format('d M Y') }}</p>
                                <p>🔑 <span class="font-medium">Last Login:</span> {{ $user->last_login?->format('d M Y H:i') ?? '—' }}</p>
                                <p>📦 <span class="font-medium">Total Orders:</span>
                                    <span class="font-semibold {{ $user->orders_count == 0 ? 'text-slate-500' : ($user->orders_count < 5 ? 'text-blue-600' : 'text-green-600') }}">
                                        {{ $user->orders_count }}
                                    </span>
                                </p>
                            </div>

                            <div class="mt-4 flex justify-end" x-data="{
                                confirmDelete(id) {
                                    const run = () => $wire.delete(id);
                                    if (window.Swal) {
                                        window.Swal.fire({
                                            title: 'Delete this user?',
                                            text: 'This action cannot be undone.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#6b7280',
                                            confirmButtonText: 'Yes, delete'
                                        }).then(r => { if (r.isConfirmed) run(); });
                                    } else {
                                        if (confirm('Delete this user?')) run();
                                    }
                                }
                            }">
                                <button
                                    @click.prevent="confirmDelete({{ $user->id }})"
                                    class="px-4 py-2 rounded-full bg-red-500 text-white font-medium hover:bg-red-600 shadow transition inline-flex items-center gap-2"
                                >
                                    🗑 Delete
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500">
                            <img src="https://www.svgrepo.com/show/530428/empty-box.svg" class="w-20 h-20 mx-auto mb-3 opacity-70" alt="empty">
                            <p class="text-lg font-medium">No users found</p>
                            <p class="text-sm text-slate-400">Try adjusting your search or filters</p>
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

{{-- Load SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('notify', (data) => {
            if (window.Swal) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert(data.message);
            }
        });
    });
</script>
