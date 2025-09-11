<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Verify Your Account
            </h2>

            <p class="text-sm text-gray-600 text-center mb-4">
                Please enter the 6-digit OTP we sent to your email.
                <br>
                <span class="font-medium text-red-500"
                      x-data="{ time: 300 }"
                      x-init="setInterval(() => { if (time > 0) time-- }, 1000)">
                    Expires in
                    <span x-text="Math.floor(time / 60) + ':' + String(time % 60).padStart(2, '0')"></span>
                </span>
            </p>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 px-3 py-2 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 bg-green-100 px-3 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Verify OTP (ONLY form on the page) --}}
            <form method="POST" action="{{ route('verify.otp.post') }}" class="space-y-4">
                @csrf

                {{-- For Google flow we get user_id via query; for Register flow it’s empty --}}
                @if(!empty($user_id))
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                @endif

                {{-- If it’s a first-time Google login, carry the flag so controller sends to Set Password --}}
                @if(!empty($is_new))
                    <input type="hidden" name="new" value="1">
                @endif

                <div>
                    <x-label for="otp_code" value="{{ __('OTP Code') }}" />
                    <x-input id="otp_code"
                             class="block mt-1 w-full text-center text-lg tracking-widest"
                             type="text" name="otp_code" maxlength="6" required autofocus />
                </div>

                <div class="flex items-center justify-between">
                    <x-button class="bg-blue-600 hover:bg-blue-700 text-white">
                        {{ __('Verify OTP') }}
                    </x-button>
                </div>
            </form>

            {{-- Separate form to resend OTP (DO NOT NEST) --}}
            <form method="POST" action="{{ route('verify.otp.resend') }}" class="mt-4 text-right">
                @csrf
                @if(!empty($user_id))
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                @endif
                <x-button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white">
                    {{ __('Resend OTP') }}
                </x-button>
            </form>
        </div>
    </div>
</x-guest-layout>
