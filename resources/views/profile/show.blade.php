<x-app-layout>
    {{-- HERO (colorful + soft shapes) --}}
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-3xl">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600"></div>
            <div class="absolute -top-24 -right-10 w-80 h-80 rounded-full bg-white/15 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-10 w-[28rem] h-[28rem] rounded-full bg-cyan-400/20 blur-3xl"></div>

            <div class="relative px-6 py-10 sm:px-10 flex items-center gap-5">
                <img
                    class="h-16 w-16 rounded-full ring-2 ring-white/80 shadow-lg object-cover"
                    src="{{ Auth::user()->profile_photo_url ?? 'https://www.gravatar.com/avatar/'.md5(strtolower(trim(Auth::user()->email))).'?s=200&d=identicon' }}"
                    alt="{{ Auth::user()->name ?? 'User' }}"
                />
                <div class="text-white">
                    <h1 class="text-3xl font-extrabold tracking-tight">Account Center</h1>
                    <p class="text-white/80 text-sm">Update your profile, security and sessions — all in one place.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8 space-y-10">

            {{-- SUMMARY CARD --}}
            <div class="relative">
                <div class="rounded-3xl border border-slate-200 bg-white/90 backdrop-blur-xl shadow-xl">
                    <div class="p-6 sm:p-8 flex items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <img
                                class="h-14 w-14 rounded-full ring-2 ring-white shadow"
                                src="{{ Auth::user()->profile_photo_url ?? 'https://www.gravatar.com/avatar/'.md5(strtolower(trim(Auth::user()->email))).'?s=200&d=identicon' }}"
                                alt="{{ Auth::user()->name ?? 'User' }}"
                            />
                            <div>
                                <div class="text-slate-900 font-semibold text-lg">
                                    {{ Auth::user()->name ?? 'User' }}
                                </div>
                                <div class="text-slate-500 text-sm">
                                    {{ Auth::user()->email ?? '' }}
                                </div>
                                <div class="text-slate-400 text-xs mt-1">
                                    Member since {{ optional(Auth::user()->created_at)->format('M Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT SIDE: Back button + pills --}}
                        <div class="flex flex-col items-end gap-3">
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
                                ← Back to Dashboard
                            </a>

                            <div class="hidden sm:flex gap-2">
                                <span class="rounded-xl bg-slate-50 text-slate-700 text-xs font-medium px-3 py-1 border border-slate-200">Profile</span>
                                <span class="rounded-xl bg-slate-50 text-slate-700 text-xs font-medium px-3 py-1 border border-slate-200">Security</span>
                                <span class="rounded-xl bg-slate-50 text-slate-700 text-xs font-medium px-3 py-1 border border-slate-200">Sessions</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STICKY SECTION NAV --}}
            <div class="sticky top-2 z-10">
                <div class="rounded-2xl bg-white/90 backdrop-blur border border-slate-200 shadow-sm px-3 py-2 flex gap-2 overflow-x-auto">
                    <a href="#profile"  class="px-3 py-1.5 text-sm rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition">Profile</a>
                    <a href="#password" class="px-3 py-1.5 text-sm rounded-xl bg-sky-50 text-sky-700 border border-sky-200 hover:bg-sky-100 transition">Password</a>
                    <a href="#twofa"    class="px-3 py-1.5 text-sm rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition">Two-Factor</a>
                    <a href="#sessions" class="px-3 py-1.5 text-sm rounded-xl bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition">Sessions</a>
                    <a href="#danger"   class="px-3 py-1.5 text-sm rounded-xl bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 transition">Danger Zone</a>
                </div>
            </div>

            {{-- SECTION: PROFILE INFO (Gradient Border Card) --}}
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <section id="profile" class="scroll-mt-24">
                    <div class="p-[1px] rounded-3xl bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 shadow-[0_0_0_1px_rgba(0,0,0,0.04)] hover:shadow-xl transition">
                        <div class="rounded-3xl bg-white">
                            <div class="px-6 py-4 sm:px-8 rounded-t-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600">
                                <h3 class="text-white text-lg font-semibold flex items-center gap-2">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm0 2c-4.4 0-8 2.2-8 5v3h16v-3c0-2.8-3.6-5-8-5z"/></svg>
                                    Profile Information
                                </h3>
                            </div>
                            <div class="p-6 sm:p-8">
                                @livewire('profile.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- SECTION: PASSWORD --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <section id="password" class="scroll-mt-24">
                    <div class="p-[1px] rounded-3xl bg-gradient-to-r from-sky-400 to-cyan-400 hover:shadow-xl transition">
                        <div class="rounded-3xl bg-white">
                            <div class="px-6 py-4 sm:px-8 rounded-t-3xl bg-gradient-to-r from-sky-500 to-cyan-500">
                                <h3 class="text-white text-lg font-semibold flex items-center gap-2">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17a2 2 0 110-4 2 2 0 010 4zm6-6V9a6 6 0 00-12 0v2H4v11h16V11h-2zm-2 0H8V9a4 4 0 118 0v2z"/></svg>
                                    Update Password
                                </h3>
                            </div>
                            <div class="p-6 sm:p-8">
                                @livewire('profile.update-password-form')
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- SECTION: TWO-FACTOR --}}
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <section id="twofa" class="scroll-mt-24">
                    <div class="p-[1px] rounded-3xl bg-gradient-to-r from-emerald-400 to-teal-400 hover:shadow-xl transition">
                        <div class="rounded-3xl bg-white">
                            <div class="px-6 py-4 sm:px-8 rounded-t-3xl bg-gradient-to-r from-emerald-500 to-teal-500">
                                <h3 class="text-white text-lg font-semibold flex items-center gap-2">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 00-7.07 17.07L12 22l7.07-2.93A10 10 0 0012 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
                                    Two-Factor Authentication
                                </h3>
                            </div>
                            <div class="p-6 sm:p-8">
                                @livewire('profile.two-factor-authentication-form')
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- SECTION: SESSIONS --}}
            <section id="sessions" class="scroll-mt-24">
                <div class="p-[1px] rounded-3xl bg-gradient-to-r from-amber-400 to-orange-400 hover:shadow-xl transition">
                    <div class="rounded-3xl bg-white">
                        <div class="px-6 py-4 sm:px-8 rounded-t-3xl bg-gradient-to-r from-amber-500 to-orange-500">
                            <h3 class="text-white text-lg font-semibold flex items-center gap-2">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v14H3V4zm2 2v10h14V6H5zm-2 14h18v2H3v-2z"/></svg>
                                Browser Sessions
                            </h3>
                        </div>
                        <div class="p-6 sm:p-8">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>
                    </div>
                </div>
            </section>

            {{-- SECTION: DANGER ZONE --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <section id="danger" class="scroll-mt-24">
                    <div class="p-[1px] rounded-3xl bg-gradient-to-r from-rose-500 to-pink-500 hover:shadow-xl transition">
                        <div class="rounded-3xl bg-white">
                            <div class="px-6 py-4 sm:px-8 rounded-t-3xl bg-gradient-to-r from-rose-600 to-pink-600">
                                <h3 class="text-white text-lg font-semibold flex items-center gap-2">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M9 3h6l1 2h5v2H3V5h5l1-2zM6 10h2v9H6v-9zm5 0h2v9h-2v-9zm5 0h2v9h-2v-9z"/></svg>
                                    Delete Account
                                </h3>
                                <p class="text-white/80 text-xs mt-1">This permanently removes your account and data.</p>
                            </div>
                            <div class="p-6 sm:p-8">
                                @livewire('profile.delete-user-form')
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- FOOTER HELP --}}
            <div class="text-center text-xs text-slate-500">
                Need help? <a class="underline hover:text-slate-700" href="mailto:support@gamerz.com">support@gamerz.com</a>
            </div>
        </div>
    </div>
</x-app-layout>
