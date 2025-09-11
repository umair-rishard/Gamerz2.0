<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Set a password for your Gamerz2.0 account. You will use this password for future logins.') }}
        </div>

        <!-- Show validation errors -->
        <x-validation-errors class="mb-4" />

        <!-- Set Password Form -->
        <form method="POST" action="{{ route('password.setup.store', $user->id) }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('New Password') }}" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation"
                         required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Save Password & Continue') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
