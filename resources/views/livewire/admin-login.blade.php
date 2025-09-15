<div class="flex flex-col justify-center items-center min-h-screen bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">

        {{-- 🔴 Global Error Box --}}
        @if(session()->has('error'))
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-3">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Show login form if not yet requiring 2FA --}}
        @if(!$requiresTwoFactor)
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Admin Login</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to access your dashboard</p>
            </div>
            
            <form wire:submit.prevent="login" class="space-y-5">
                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                        placeholder="admin@example.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input type="password" wire:model="password" id="passwordInput"
                            class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                            placeholder="Enter your password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-sm text-indigo-600 hover:underline">
                            Show
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Login Button --}}
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold shadow-md transition">
                    Login
                </button>
            </form>
        @else
            {{-- Show 2FA verification form --}}
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Two-Factor Verification</h1>
                <p class="text-sm text-gray-500 mt-1">Enter your authenticator code</p>
            </div>
            
            <form wire:submit.prevent="verifyCode" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Authenticator Code</label>
                    <input type="text" wire:model="code"
                        class="w-full mt-1 px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-400"
                        placeholder="123456">
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold shadow-md transition">
                    Verify Code
                </button>
            </form>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="mt-6 text-gray-500 text-xs text-center">
        © 2025 Gamerz Admin Panel. All rights reserved.
    </footer>
</div>

{{-- JS for show/hide password --}}
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
