@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8 text-center">Shop Products</h1>

    {{-- Product Grid --}}
    <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <p class="col-span-full text-center text-gray-500">Loading products...</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("auth_token");

    // axios instance pointing to /api
    const api = axios.create({
        baseURL: "http://127.0.0.1:8000/api",
        headers: {
            Authorization: token ? `Bearer ${token}` : undefined,
            Accept: "application/json"
        }
    });

    // Tiny helper: bump a header badge if it exists
    function bumpBadge(id, delta = 1) {
        const el = document.getElementById(id);
        if (!el) return;
        const current = parseInt(el.textContent, 10) || 0;
        el.textContent = current + delta;

        // quick pop animation (optional)
        el.style.transform = 'scale(1.2)';
        setTimeout(() => el.style.transform = 'scale(1)', 120);
    }

    // Load products from /api/products
    api.get("/products")
        .then(res => {
            const products = res.data.data ?? res.data; // handle pagination
            const grid = document.getElementById("productsGrid");
            grid.innerHTML = "";

            if (!products || !products.length) {
                grid.innerHTML = `<p class="col-span-full text-center text-gray-500">No products available</p>`;
                return;
            }

            products.forEach(product => {
                const imageUrl = product.image_url || `/${product.image_path}`;
                const card = `
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <!-- Whole card clickable (image + title) -->
                        <a href="/products/${product.id}">
                            <img src="${imageUrl}" alt="${product.name}" 
                                 class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="/products/${product.id}">
                                <h2 class="text-lg font-semibold mb-1 hover:text-indigo-600">
                                    ${product.name}
                                </h2>
                            </a>
                            <p class="text-gray-600 mb-2">
                                Rs. ${Number(String(product.price ?? 0).replace(/,/g, '')).toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                            </p>
                            <p class="text-sm text-gray-500 mb-4">Stock: ${product.stock}</p>
                            <div class="flex justify-between items-center">
                                <a href="/products/${product.id}" 
                                   class="text-sm font-medium text-blue-600 hover:underline">
                                    View Details
                                </a>
                                <div class="flex space-x-3">
                                    <button onclick="addToCart(${product.id})" 
                                        class="text-xl hover:text-green-600" title="Add to Cart">
                                        🛒
                                    </button>
                                    <button onclick="addToWishlist(${product.id})" 
                                        class="text-xl hover:text-red-500" title="Add to Wishlist">
                                        ❤️
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                grid.insertAdjacentHTML("beforeend", card);
            });
        })
        .catch(err => {
            console.error(err);
            document.getElementById("productsGrid").innerHTML =
                `<p class="col-span-full text-center text-red-500">Error loading products</p>`;
        });

    // Add to Cart → /api/cart
    window.addToCart = function (id) {
        if (!token) {
            Swal.fire({ icon: "info", title: "Please log in", text: "You need to login to add items to cart." });
            return;
        }
        api.post("/cart", { product_id: id, quantity: 1 })
            .then(() => {
                bumpBadge('cartCount', 1);
                Swal.fire({
                    icon: "success",
                    title: "Added to Cart 🛒",
                    showConfirmButton: false,
                    timer: 1200
                });
            })
            .catch(err => {
                console.error(err);
                const msg = err.response?.status === 401
                    ? "Your session expired. Please log in again."
                    : (err.response?.data?.message || "Could not add product to cart");
                Swal.fire({ icon: "error", title: "Failed", text: msg });
            });
    }

    // Add to Wishlist → /api/wishlist
    window.addToWishlist = function (id) {
        if (!token) {
            Swal.fire({ icon: "info", title: "Please log in", text: "You need to login to use wishlist." });
            return;
        }
        api.post("/wishlist", { product_id: id })
            .then(() => {
                bumpBadge('wishlistCount', 1);
                Swal.fire({
                    icon: "success",
                    title: "Added to Wishlist ❤️",
                    showConfirmButton: false,
                    timer: 1200
                });
            })
            .catch(err => {
                console.error(err);
                const msg = err.response?.status === 401
                    ? "Your session expired. Please log in again."
                    : (err.response?.data?.message || "Could not add product to wishlist");
                Swal.fire({ icon: "error", title: "Failed", text: msg });
            });
    }
});
</script>
@endpush
