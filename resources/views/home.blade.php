@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gray-100 py-20 text-center">
        <h1 class="text-4xl font-bold text-gray-900">Welcome to {{ config('app.name', 'Gamerz2.0') }}</h1>
        <p class="mt-4 text-gray-600">Explore our products, add them to your cart, and manage your wishlist easily.</p>
        <a href="{{ route('products.index') }}" 
           class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            Shop Now
        </a>
    </section>

    <!-- Featured Products -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-semibold mb-6">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Example product (later loop from DB) -->
            <div class="bg-white shadow rounded-lg p-4">
                <img src="https://via.placeholder.com/300x200" alt="Product" class="w-full rounded">
                <h3 class="mt-3 font-semibold">Sample Product</h3>
                <p class="text-gray-600">$99.00</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <img src="https://via.placeholder.com/300x200" alt="Product" class="w-full rounded">
                <h3 class="mt-3 font-semibold">Another Product</h3>
                <p class="text-gray-600">$59.00</p>
            </div>
        </div>
    </section>
@endsection
