@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 py-10 px-6">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800">Write a Review</h1>
            <p class="text-gray-500 mt-2">Share your experience with the products you purchased</p>
        </div>

        {{-- Products to Review --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Products in this Order</h2>
            <div id="reviewList" class="space-y-6">
                <p class="text-gray-400">Loading products...</p>
            </div>
        </div>

    </div>
</div>

{{-- Axios + SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    let orderId = "{{ $id }}";

    try {
        let res = await axios.get(`/api/orders/${orderId}`);
        let order = res.data;

        if (order.status !== 'delivered') {
            document.getElementById('reviewList').innerHTML = `
                <p class="text-red-500">You can only review products after this order is marked as Delivered.</p>
            `;
            return;
        }

        let reviewList = document.getElementById('reviewList');
        reviewList.innerHTML = '';

        order.items.forEach(item => {
            reviewList.innerHTML += `
                <div class="border rounded-xl p-4 shadow-sm">
                    <h3 class="font-medium text-gray-800 mb-2">${item.product_name}</h3>
                    
                    <!-- Rating -->
                    <div class="flex space-x-1 mb-3" id="stars-${item.product_id}">
                        ${[1,2,3,4,5].map(n => `
                            <svg onclick="setRating(${item.product_id}, ${n})"
                                 class="w-6 h-6 text-gray-300 cursor-pointer hover:text-yellow-400"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674h4.91c.97 0 1.371 1.24.588 1.81l-3.975 2.89 1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.975-2.89-3.975 2.89c-.785.57-1.84-.197-1.54-1.118l1.518-4.674-3.975-2.89c-.783-.57-.382-1.81.588-1.81h4.91L9.05 2.927z"/>
                            </svg>
                        `).join('')}
                    </div>

                    <!-- Textarea -->
                    <textarea id="text-${item.product_id}" rows="3"
                        class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500"
                        placeholder="Write your review..."></textarea>

                    <!-- Submit Button -->
                    <button onclick="submitReview(${item.product_id})"
                        class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
                        Submit Review
                    </button>
                </div>
            `;
        });

    } catch (err) {
        console.error(err);
        document.getElementById('reviewList').innerHTML =
            `<p class="text-red-500">Failed to load order details.</p>`;
    }
});

let ratings = {};

function setRating(productId, value) {
    ratings[productId] = value;
    let stars = document.querySelectorAll(`#stars-${productId} svg`);
    stars.forEach((star, index) => {
        if (index < value) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
}

async function submitReview(productId) {
    let text = document.getElementById(`text-${productId}`).value;
    let rating = ratings[productId] || 0;

    if (!rating || !text) {
        Swal.fire("Error", "Please select a rating and write a review.", "error");
        return;
    }

    try {
        await axios.post('/api/reviews', {
            product_id: productId,
            rating: rating,
            text: text
        });

        Swal.fire("Success", "Your review has been submitted!", "success");
        document.getElementById(`text-${productId}`).value = '';
        setRating(productId, 0);

    } catch (err) {
        console.error(err);
        Swal.fire("Error", "Failed to submit review. Try again later.", "error");
    }
}
</script>
@endsection
