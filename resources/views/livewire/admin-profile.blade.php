<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Page Title -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Profile</h1>

    <!-- Admin Info -->
    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-gray-700">
            <span class="font-semibold">Name:</span>
            {{ Auth::guard('admin')->user()->name }}
        </p>
        <p class="text-gray-700 mt-2">
            <span class="font-semibold">Email:</span>
            {{ Auth::guard('admin')->user()->email }}
        </p>
    </div>

    <!-- Two-Factor Authentication (optional) -->
    <div class="mt-8 bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Security</h2>

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div>
                @livewire('profile.two-factor-authentication-form')
            </div>
        @else
            <p class="text-gray-500">Two-Factor Authentication is not enabled for this application.</p>
        @endif
    </div>
</div>
