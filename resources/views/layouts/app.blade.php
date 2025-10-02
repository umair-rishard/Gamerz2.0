<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GAMERZ') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    <!-- App assets (includes Alpine via Jetstream) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire styles MUST be in <head> -->
    @livewireStyles

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-black/5">

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    $user = Auth::user();
    // Try common fields first (Jetstream profile photo), then custom columns, then UI-Avatars
    $avatarUrl = null;
    if ($user) {
        // Jetstream
        if (!empty($user->profile_photo_url)) {
            $avatarUrl = $user->profile_photo_url;
        }
        // Custom absolute URL (e.g., avatar_url)
        elseif (!empty($user->avatar_url)) {
            $avatarUrl = $user->avatar_url;
        }
        // Custom stored path (e.g., avatar_path or photo)
        elseif (!empty($user->avatar_path)) {
            $avatarUrl = Storage::url($user->avatar_path);
        } elseif (!empty($user->photo)) {
            $avatarUrl = Storage::url($user->photo);
        }

        // Fallback to UI Avatars
        if (!$avatarUrl) {
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff';
        }
    }
@endphp

    {{-- ================== STICKY HEADER (page scrolls beneath) ================== --}}
    <header x-data="{ openSheet:false }" class="fixed top-0 inset-x-0 z-50">
        {{-- Top info glass bar (lighter) --}}
        <div class="bg-white/70 text-slate-900 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b border-black/10 text-xs sm:text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mon–Fri 09:00 – 18:00
                    </span>
                    <span class="hidden md:inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        support@gamerz.com
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h1.22a2 2 0 011.94 1.46l.57 2.01a2 2 0 01-.45 1.9l-1 1a16 16 0 006.36 6.36l1-1a2 2 0 011.9-.45l2.01.57A2 2 0 0121 18.78V20a2 2 0 01-2 2h-1C9.82 22 2 14.18 2 5V4a1 1 0 011-1z"/></svg>
                        +94 71 123 4567
                    </span>
                </div>

                {{-- Socials in small header --}}
                <div class="hidden md:flex items-center gap-3">
                    <a href="#" class="soc-top" aria-label="Twitter">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.26 4.26 0 001.88-2.36 8.3 8.3 0 01-2.65 1.02 4.19 4.19 0 00-7.13 3.82A11.9 11.9 0 013 4.9a4.19 4.19 0 001.3 5.59 4.18 4.18 0 01-1.9-.52v.05a4.19 4.19 0 003.36 4.1 4.23 4.23 0 01-1.89.07 4.19 4.19 0 003.91 2.91A8.39 8.39 0 012 19.54 11.82 11.82 0 008.29 21c7.55 0 11.68-6.25 11.68-11.68 0-.18-.01-.35-.02-.53A8.35 8.35 0 0022.46 6z"/></svg>
                    </a>
                    <a href="#" class="soc-top" aria-label="Facebook">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 4.96 3.63 9.07 8.36 9.86v-6.98H7.9v-2.88h2.5V9.93c0-2.47 1.48-3.83 3.74-3.83 1.08 0 2.2.2 2.2.2v2.42h-1.24c-1.23 0-1.62.77-1.62 1.56v1.87h2.77l-.44 2.88h-2.33v6.98c4.73-.79 8.36-4.9 8.36-9.86 0-5.5-4.46-9.96-9.96-9.96z"/></svg>
                    </a>
                    <a href="#" class="soc-top" aria-label="LinkedIn">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19.6 3H4.4A1.4 1.4 0 003 4.4v15.2A1.4 1.4 0 004.4 21h15.2a1.4 1.4 0 001.4-1.4V4.4A1.4 1.4 0 0019.6 3zM8.6 17.6H6V10h2.6v7.6zm-1.3-8.7c-.84 0-1.52-.68-1.52-1.52s.68-1.52 1.52-1.52S8.8 6.54 8.8 7.38 8.14 8.9 7.3 8.9zm11 8.7h-2.6v-3.9c0-.93-.02-2.13-1.3-2.13-1.3 0-1.5 1.02-1.5 2.06v3.97H10V10h2.5v1.04h.03c.35-.66 1.22-1.35 2.51-1.35 2.68 0 3.18 1.77 3.18 4.07v3.84z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main header: solid black --}}
        <div class="bg-black border-b border-white/10 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between relative">
                    {{-- Brand --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="GAMERZ" class="h-14 w-auto sm:h-16">
                        <div class="leading-tight">
                            <div class="text-2xl sm:text-[28px] font-extrabold tracking-wide uppercase">GAMERZ</div>
                            <div class="text-[11px] text-white/60 -mt-0.5">Play more. Pay less.</div>
                        </div>
                    </a>

                    {{-- Desktop nav --}}
                    <nav class="hidden md:flex items-center gap-10 text-[15px] font-semibold">
                        <a href="{{ route('home') }}" class="navlink text-white">Home</a>
                        <a href="{{ route('products.index') }}" class="navlink text-white">Products</a>
                        <a href="{{ route('contact') }}" class="navlink text-white">Contact</a>
                    </nav>

                    {{-- Right actions --}}
                    <div class="flex items-center gap-3">
                        @guest
                            {{-- Login dropdown --}}
                            <div x-data="{ open:false }" class="relative hidden md:block">
                                <button @click="open=!open"
                                        class="px-4 py-2.5 rounded-full bg-white text-black font-semibold shadow hover:shadow-lg transition active:scale-[.98]">
                                    Login
                                </button>
                                <div x-show="open"
                                     x-transition.opacity.scale.origin.top.right
                                     @click.away="open=false"
                                     class="absolute right-0 top-full mt-3 w-56 bg-black text-white border border-white/20 rounded-xl shadow-2xl overflow-hidden">
                                    <a href="{{ route('login') }}"
                                       class="block px-4 py-3 hover:bg-white/10 border-b border-white/10">User Login</a>
                                    <a href="{{ route('admin.login') }}"
                                       class="block px-4 py-3 hover:bg-white/10">Admin Login</a>
                                </div>
                            </div>
                        @endguest

                        @auth
                            <a href="/wishlist" class="iconbtn-white relative" aria-label="Wishlist" title="Wishlist">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21l-7.682-7.682a4.5 4.5 0 010-6.364z"/></svg>
                                <span id="wishlistCount" class="count-badge">0</span>
                            </a>
                            <a href="/cart" class="iconbtn-white relative" aria-label="Cart" title="Cart">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13l-1.293 1.293A1 1 0 007 16h10m-9 0a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 110 2 1 1 0 010-2z"/></svg>
                                <span id="cartCount" class="count-badge">0</span>
                            </a>

                            <div x-data="{ open:false }" class="relative hidden md:block">
                                <button @click="open=!open" class="flex items-center gap-2 focus:outline-none">
                                    {{-- Avatar (uploaded photo preferred, fallback to UI-Avatars) --}}
                                    <img src="{{ $avatarUrl }}"
                                         alt="avatar"
                                         class="w-9 h-9 rounded-full border border-white/20 object-cover">
                                    <span class="hidden sm:block font-semibold">{{ Auth::user()->name }}</span>
                                </button>
                                <div x-show="open" x-transition.opacity.scale.origin.top.right @click.away="open=false"
                                     class="absolute right-0 top-full mt-3 w-52 bg-black text-white border border-white/20 rounded-xl shadow-2xl overflow-hidden">
                                    <a href="{{ url('/dashboard') }}" class="block px-4 py-3 hover:bg-white/10 border-b border-white/10">Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-3 hover:bg-white/10 border-b border-white/10">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" onclick="window.clearAuthTokens()" class="w-full text-left px-4 py-3 hover:bg-white/10">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth

                        {{-- Mobile: compact login + hamburger --}}
                        <div class="flex md:hidden items-center gap-2">
                            @guest
                                <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-full bg-white text-black text-sm font-semibold">Login</a>
                            @endguest
                            <button @click="openSheet=true" class="rounded-full p-2.5 border border-white/20 hover:bg-white/10 active:scale-95" aria-label="Menu">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile right sheet + backdrop --}}
        <div x-show="openSheet" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 md:hidden" @click="openSheet=false"></div>
        <aside x-show="openSheet"
               x-transition:enter="transform transition ease-out duration-200"
               x-transition:enter-start="translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transform transition ease-in duration-150"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="translate-x-full"
               class="fixed right-0 top-0 h-full w-80 bg-black text-white border-l border-white/10 z-50 md:hidden">
            <div class="p-4 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-9" alt="GAMERZ">
                    <span class="font-extrabold tracking-wide uppercase">GAMERZ</span>
                </div>
                <button @click="openSheet=false" class="p-2 rounded-full hover:bg-white/10" aria-label="Close menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="p-4 space-y-2 text-base font-semibold">
                <a href="{{ route('home') }}" class="sheetlink">Home</a>
                <a href="{{ route('products.index') }}" class="sheetlink">Products</a>
                <a href="{{ route('contact') }}" class="sheetlink">Contact</a>

                <div class="pt-4 mt-4 border-t border-white/10">
                    <p class="text-xs uppercase tracking-widest text-white/50 mb-2">Account</p>
                    @guest
                        <a href="{{ route('login') }}" class="block mb-2 px-3 py-2 rounded-lg bg-white text-black text-center font-bold">Login</a>
                        <a href="{{ route('admin.login') }}" class="block px-3 py-2 rounded-lg border border-white/30 text-center hover:bg-white/10">Admin Login</a>
                    @endguest

                    @auth
                        <a href="{{ url('/dashboard') }}" class="sheetlink">Dashboard</a>
                        <a href="{{ route('profile.show') }}" class="sheetlink">Profile</a>
                        {{-- Visible Logout button on mobile --}}
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" onclick="window.clearAuthTokens()" class="w-full px-3 py-2 rounded-lg bg-white text-black font-bold hover:brightness-95 active:scale-95">
                                Log Out
                            </button>
                        </form>
                    @endauth
                </div>
            </nav>
        </aside>
    </header>

    {{-- CONTENT (offset below fixed header) --}}
    <main class="pt-[7.5rem]">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    {{-- ================== FOOTER (solid black & white) ================== --}}
    <footer class="mt-20 bg-black text-white border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid gap-12 sm:gap-14 md:gap-16 lg:gap-20
                        grid-cols-1 md:grid-cols-4 items-start
                        text-center md:text-left">
                {{-- Brand / newsletter --}}
                <div class="md:col-span-1">
                    <div class="flex items-center justify-center md:justify-start gap-4 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="GAMERZ" class="h-12 sm:h-14 w-auto">
                        <span class="text-2xl sm:text-3xl font-extrabold tracking-wide uppercase">GAMERZ</span>
                    </div>
                    <p class="text-sm text-white/70 mb-6 max-w-sm mx-auto md:mx-0">
                        Premium gaming destination with exclusive gear, lightning-fast delivery, and unbeatable prices for the ultimate gaming experience.
                    </p>
                    <form class="mx-auto md:mx-0 w-full max-w-sm flex">
                        <input type="email" placeholder="Your email address" class="w-full rounded-l-lg px-3 py-2 text-black focus:outline-none">
                        <button class="rounded-r-lg px-4 bg-white text-black font-semibold hover:brightness-90 transition">Subscribe</button>
                    </form>
                </div>

                {{-- Company --}}
                <div class="md:pl-12">
                    <h4 class="font-bold mb-5 text-white">Company</h4>
                    <ul class="space-y-3 text-sm text-white/85">
                        <li><a class="footlink" href="{{ route('products.index') }}">Products</a></li>
                        <li><a class="footlink" href="#careers">Careers</a></li>
                        <li><a class="footlink" href="#press">Press</a></li>
                        <li><a class="footlink" href="#blog">Blog</a></li>
                        <li><a class="footlink" href="#partnerships">Partnerships</a></li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h4 class="font-bold mb-5 text-white">Support</h4>
                    <ul class="space-y-3 text-sm text-white/85">
                        <li><a class="footlink" href="#help">Help Center</a></li>
                        <li><a class="footlink" href="#faqs">FAQs</a></li>
                        <li><a class="footlink" href="#shipping">Shipping Info</a></li>
                        <li><a class="footlink" href="#returns">Returns</a></li>
                        <li><a class="footlink" href="#privacy">Privacy Policy</a></li>
                        <li><a class="footlink" href="#terms">Terms of Service</a></li>
                    </ul>
                </div>

                {{-- Get the App + socials --}}
                <div class="md:pl-6">
                    <h4 class="font-bold mb-5 text-white">Get the App</h4>
                    <div class="space-y-4 max-w-xs mx-auto md:mx-0">
                        <a class="block rounded-lg border border-white/20 px-4 py-3 text-center hover:bg-white/10">App Store</a>
                        <a class="block rounded-lg border border-white/20 px-4 py-3 text-center hover:bg-white/10">Google Play</a>
                    </div>

                    <div class="mt-7 flex items-center gap-3 justify-center md:justify-start">
                        <a href="#" class="soc-round" aria-label="Twitter">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.26 4.26 0 001.88-2.36 8.3 8.3 0 01-2.65 1.02 4.19 4.19 0 00-7.13 3.82A11.9 11.9 0 013 4.9a4.19 4.19 0 001.3 5.59 4.18 4.18 0 01-1.9-.52v.05a4.19 4.19 0 003.36 4.1 4.23 4.23 0 01-1.89.07 4.19 4.19 0 003.91 2.91A8.39 8.39 0 012 19.54 11.82 11.82 0 008.29 21c7.55 0 11.68-6.25 11.68-11.68 0-.18-.01-.35-.02-.53A8.35 8.35 0 0022.46 6z"/></svg>
                        </a>
                        <a href="#" class="soc-round" aria-label="Facebook">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 4.96 3.63 9.07 8.36 9.86v-6.98H7.9v-2.88h2.5V9.93c0-2.47 1.48-3.83 3.74-3.83 1.08 0 2.2.2 2.2.2v2.42h-1.24c-1.23 0-1.62.77-1.62 1.56v1.87h2.77l-.44 2.88h-2.33v6.98c4.73-.79 8.36-4.9 8.36-9.86 0-5.5-4.46-9.96-9.96-9.96z"/></svg>
                        </a>
                        <a href="#" class="soc-round" aria-label="LinkedIn">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19.6 3H4.4A1.4 1.4 0 003 4.4v15.2A1.4 1.4 0 004.4 21h15.2a1.4 1.4 0 001.4-1.4V4.4A1.4 1.4 0 0019.6 3zM8.6 17.6H6V10h2.6v7.6zm-1.3-8.7c-.84 0-1.52-.68-1.52-1.52s.68-1.52 1.52-1.52S8.8 6.54 8.8 7.38 8.14 8.9 7.3 8.9zm11 8.7h-2.6v-3.9c0-.93-.02-2.13-1.3-2.13-1.3 0-1.5 1.02-1.5 2.06v3.97H10V10h2.5v1.04h.03c.35-.66 1.22-1.35 2.51-1.35 2.68 0 3.18 1.77 3.18 4.07v3.84z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row gap-3 items-center justify-between text-sm text-white/70">
                <p class="text-center sm:text-left">© {{ date('Y') }} GAMERZ. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#terms" class="footlink">Terms</a>
                    <a href="#privacy" class="footlink">Privacy</a>
                    <a href="#cookies" class="footlink">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ================== ORDER MATTERS BELOW ================== --}}
    @stack('modals')

    {{-- Livewire scripts MUST load before any custom JS --}}
    @livewireScripts

    <!-- jQuery is required by toastr 2.x -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>

    <!-- Toastr JS (keep after jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:"3000" };
    </script>

    {{-- Page-level scripts --}}
    @stack('scripts')

    {{-- Style helpers --}}
    <style>
        /* Top header socials */
        .soc-top{opacity:.8}
        .soc-top:hover{opacity:1}

        /* Desktop nav underline */
        .navlink{position:relative;transition:opacity .2s ease}
        .navlink::after{
            content:"";position:absolute;left:0;bottom:-8px;height:2px;width:0;background:#fff;
            transition:width .25s ease;
        }
        .navlink:hover::after{width:100%}
        .navlink:hover{opacity:.9}

        /* White circular icon buttons (cart/wishlist) */
        .iconbtn-white{
            display:inline-flex;align-items:center;justify-content:center;
            width:40px;height:40px;border-radius:9999px;border:1px solid rgba(255,255,255,.25);
            background:transparent;transition:all .2s ease;
        }
        .iconbtn-white:hover{background:rgba(255,255,255,.12)}

        /* Count badge */
        .count-badge{
            position:absolute;top:-6px;right:-6px;
            background:#ef4444;color:#fff;font-size:11px;font-weight:700;
            padding:2px 6px;border-radius:9999px;line-height:1;
            min-width:18px;text-align:center;
        }

        /* Mobile sheet links */
        .sheetlink{
            display:block;padding:.625rem .75rem;border-radius:.5rem;border:1px solid transparent
        }
        .sheetlink:hover{background-color:rgba(255,255,255,.08);border-color:rgba(255,255,255,.15)}

        /* Footer links */
        .footlink{color:rgba(255,255,255,.85)}
        .footlink:hover{color:#fff}

        /* Round social icons (footer) */
        .soc-round{
            display:inline-flex;align-items:center;justify-content:center;
            width:36px;height:36px;border-radius:9999px;
            border:1px solid rgba(255,255,255,.35);
            transition:all .2s ease;background:transparent;color:#fff;
        }
        .soc-round:hover{background:#fff;color:#000;border-color:#fff}

        /* Remove input autofill yellow */
        input:-webkit-autofill{
            -webkit-box-shadow:0 0 0 1000px white inset !important;
            -webkit-text-fill-color:#000 !important;
        }
        /* Ensure avatar crops correctly */
        img.object-cover{object-fit:cover}
    </style>

    {{-- ================== COUNTS + AUTH HELPERS ================== --}}
    <script>
        // Always-clear on logout buttons
        window.clearAuthTokens = function () {
            localStorage.removeItem("auth_token");
            localStorage.removeItem("admin_token");
            console.log("Auth tokens cleared on logout");
        };

        // One axios instance that always sends the Bearer token
        function makeApi() {
            const token = localStorage.getItem('auth_token');
            const base = (typeof axios !== 'undefined')
                ? axios.create({
                    baseURL: 'http://127.0.0.1:8000',
                    headers: {
                        Accept: 'application/json',
                        ...(token ? { Authorization: `Bearer ${token}` } : {})
                    }
                })
                : null;
            return base;
        }

        // Robust count extractor that tolerates different payload shapes
        function extractCount(resp) {
            const d = resp?.data;
            if (typeof d === 'number') return d;
            if (Array.isArray(d)) return d.length;

            if (d && typeof d === 'object') {
                if (Array.isArray(d.data)) return d.data.length;
                if (Array.isArray(d.items)) return d.items.length;
                if (Array.isArray(d.wishlist)) return d.wishlist.length;
                if (typeof d.total === 'number') return d.total;
                if (d.pagination && typeof d.pagination.total === 'number') return d.pagination.total;
                if (d.data && typeof d.data === 'object') {
                    if (Array.isArray(d.data.data)) return d.data.data.length;
                    if (typeof d.data.total === 'number') return d.data.total;
                }
            }
            return 0;
        }

        // Expose a single global to refresh the header counters from anywhere
        window.refreshHeaderCounts = async function () {
            if (typeof axios === 'undefined') return;
            const api = makeApi();
            if (!api) return;

            const set = (id, n) => {
                const el = document.getElementById(id);
                if (el) el.textContent = n;
            };

            try {
                const cart = await api.get('/api/cart');
                set('cartCount', extractCount(cart));
            } catch {
                set('cartCount', 0);
            }

            try {
                const wish = await api.get('/api/wishlist');
                set('wishlistCount', extractCount(wish));
            } catch {
                set('wishlistCount', 0);
            }
        };

        // Run once on load
        document.addEventListener('DOMContentLoaded', window.refreshHeaderCounts);

        // If the auth token changes in another tab, re-sync badges
        window.addEventListener('storage', (e) => {
            if (e.key === 'auth_token') window.refreshHeaderCounts();
        });
    </script>

</body>
</html>
