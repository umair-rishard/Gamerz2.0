<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">
                        Welcome, {{ Auth::guard('admin')->user()->name }}
                    </h1>
                    <p class="text-gray-600">You are now logged in as an admin.</p>

                    <form wire:submit.prevent="logout" class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
