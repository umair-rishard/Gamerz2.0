<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">

            <!-- Heading -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Verify Your Account
            </h2>

            <!-- Instructions -->
            <p class="text-sm text-gray-600 text-center mb-4">
                Please enter the 6-digit OTP we sent to your email. 
                <br>
                <span class="font-medium text-red-500" x-data="{ time: 300 }" x-init="setInterval(() => { if (time > 0) time-- }, 1000)">
                    Expires in 
                    <span x-text="Math.floor(time / 60) + ':' + String(time % 60).padStart(2, '0')"></span>
                </span>
            </p>

            <!-- Show errors -->
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-100 px-3 py-2 rounded">
                    {{ $errors->first('otp_code') }}
                </div>
            @endif

            <!-- Success messages -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 bg-green-100 px-3 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <!-- OTP form -->
            <form method="POST" action="{{ route('verify.otp.post') }}" class="space-y-4">
                @csrf

                <div>
                    <x-label for="otp_code" value="{{ __('OTP Code') }}" />
                    <x-input id="otp_code" class="block mt-1 w-full text-center text-lg tracking-widest"
                             type="text" name="otp_code" maxlength="6" required autofocus />
                </div>

                <div class="flex items-center justify-between">
                    <!-- Verify Button -->
                    <x-button class="bg-blue-600 hover:bg-blue-700 text-white">
                        {{ __('Verify OTP') }}
                    </x-button>

                    <!-- Resend OTP Button -->
                    <form method="POST" action="{{ route('verify.otp.resend') }}">
                        @csrf
                        <x-button type="submit" class="ml-4 bg-gray-500 hover:bg-gray-600 text-white">
                            {{ __('Resend OTP') }}
                        </x-button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
