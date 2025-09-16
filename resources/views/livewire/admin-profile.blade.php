<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    {{-- Back button (no header/sidebar on this page) --}}
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center px-3 py-2 rounded bg-gray-800 text-white hover:bg-gray-900">
            ← Back to Dashboard
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Profile</h1>

    {{-- Flash messages --}}
    @if (session('success_profile'))
        <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
            {{ session('success_profile') }}
        </div>
    @endif
    @if (session('success_password'))
        <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
            {{ session('success_password') }}
        </div>
    @endif

    {{-- Account Info --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Account Info</h2>

        <form wire:submit.prevent="updateProfile" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" wire:model.defer="name"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                />
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model.defer="email"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
                    Save changes
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Change Password</h2>

        <form wire:submit.prevent="updatePassword" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Current password</label>
                <input type="password" wire:model.defer="current_password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New password</label>
                <input type="password" wire:model.defer="password"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm new password</label>
                <input type="password" wire:model.defer="password_confirmation"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                    Update password
                </button>
            </div>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4 text-red-700">Danger Zone</h2>
        <p class="text-gray-600 mb-4">Deleting your admin account is permanent.</p>

        <form wire:submit.prevent="deleteAccount" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm with password</label>
                <input type="password" wire:model.defer="confirm_password_for_delete"
                       class="mt-1 w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                @error('confirm_password_for_delete') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                Delete account
            </button>
        </form>
    </div>

    {{-- Optional: keep Jetstream/Fortify 2FA section below if it works for your Admin model --}}
    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Two Factor Authentication</h2>
            @livewire('profile.two-factor-authentication-form')
        </div>
    @endif
</div>
