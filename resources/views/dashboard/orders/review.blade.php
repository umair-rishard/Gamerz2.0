@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50 py-10 px-6">
    <div class="max-w-4xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800">Write a Review</h1>
            <p class="text-gray-500 mt-2">Share your experience with the products you purchased</p>
        </div>

        {{-- Back to Dashboard --}}
        <div class="text-left">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-lg shadow hover:bg-gray-800">
                ← Back to Dashboard
            </a>
        </div>

        {{-- Summary (starts hidden; JS will add "flex") --}}
        <div id="summaryBox"
             class="hidden bg-gradient-to-r from-indigo-500 to-purple-500 text-white p-4 rounded-xl shadow items-center justify-between">
            <p class="font-medium">
                <span id="reviewedCount">0</span> / <span id="totalCount">0</span> products reviewed
            </p>
            <span id="statusBadge" class="px-3 py-1 bg-white text-indigo-700 font-semibold rounded-lg text-sm shadow"></span>
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
    const orderId = "{{ $id }}";
    let reviewedCount = 0;
    let totalCount = 0;

    try {
        const res = await axios.get(`/api/orders/${orderId}`);
        const order = res.data;

        if (!order || order.status !== 'delivered') {
            document.getElementById('reviewList').innerHTML = `
                <p class="text-red-500">You can only review products after this order is marked as Delivered.</p>
            `;
            return;
        }

        const reviewList = document.getElementById('reviewList');
        reviewList.innerHTML = '';
        totalCount = (order.items || []).length;

        for (const item of order.items) {
            const productName  = item.product?.name || item.product_name || "Unnamed Product";
            const productImage = item.product?.image_url || "/images/placeholder.png";
            const currentUser  = "{{ Auth::user()->name ?? 'Guest' }}";

            let myReview = null;
            try {
                const myRes = await axios.get(`/api/my-review/${item.product_id}`);
                myReview = myRes.data || null;
            } catch (_) {
                myReview = null;
            }

            // robust ID extraction
            const reviewId = myReview && (myReview._id?.$oid || myReview._id || myReview.id);

            if (reviewId) {
                reviewList.innerHTML += renderReviewCard(item, productName, productImage, myReview, reviewId);
                ratings[item.id] = myReview.rating || 0;
                reviewedCount++;
            } else {
                reviewList.innerHTML += renderFormCard(item, productName, productImage, currentUser);
            }
        }

        // Summary
        const summaryBox  = document.getElementById('summaryBox');
        document.getElementById('reviewedCount').textContent = reviewedCount;
        document.getElementById('totalCount').textContent    = totalCount;

        if (totalCount > 0) {
            summaryBox.classList.remove('hidden');
            summaryBox.classList.add('flex');
            document.getElementById('statusBadge').textContent =
                (reviewedCount === totalCount) ? "All Reviews Completed 🎉" : `${totalCount - reviewedCount} Pending`;
        }
    } catch (err) {
        console.error(err);
        document.getElementById('reviewList').innerHTML = `<p class="text-red-500">Failed to load order details.</p>`;
    }
});

let ratings = {};
const CURRENT_USER = "{{ Auth::user()->name ?? 'Guest' }}";

// ---- summary helper (no reload) ----
function updateSummary(deltaReviewed) {
  const reviewedEl = document.getElementById('reviewedCount');
  const totalEl    = document.getElementById('totalCount');
  const badge      = document.getElementById('statusBadge');

  let reviewed = parseInt(reviewedEl.textContent || '0', 10);
  const total  = parseInt(totalEl.textContent || '0', 10);
  reviewed += deltaReviewed;
  reviewedEl.textContent = reviewed;
  badge.textContent = (reviewed === total) ? "All Reviews Completed 🎉" : `${total - reviewed} Pending`;
}

// ---------- Renderers ----------
function renderFormCard(item, productName, productImage, currentUser) {
    return `
    <div class="border rounded-xl p-4 shadow-sm bg-slate-50" id="review-card-${item.id}">
        <div class="flex items-center gap-4 mb-3">
            <img src="${productImage}" class="w-20 h-20 rounded-lg object-cover border shadow" alt="">
            <div>
                <h3 class="font-semibold text-gray-800">${productName}</h3>
                <p class="text-sm text-gray-500">Reviewed by: <span class="font-medium">${currentUser}</span></p>
            </div>
        </div>

        <div class="flex space-x-1 mb-3" id="stars-${item.id}">
            ${[1,2,3,4,5].map(n => `
                <svg onclick="setRating(${item.id}, ${n})"
                     class="w-6 h-6 text-gray-300 cursor-pointer hover:text-yellow-400"
                     fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674h4.91c.97 0 1.371 1.24.588 1.81l-3.975 2.89 1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.975-2.89-3.975 2.89c-.785.57-1.84-.197-1.54-1.118l1.518-4.674-3.975-2.89c-.783-.57-.382-1.81.588-1.81h4.91L9.05 2.927z"/>
                </svg>
            `).join('')}
        </div>

        <textarea id="text-${item.id}" rows="3"
            class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500"
            placeholder="Write your review..."></textarea>

        <button onclick="submitReview(${item.product_id}, ${item.id})"
            class="mt-3 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Submit Review</button>
    </div>
    `;
}

function renderReviewCard(item, productName, productImage, myReview, reviewId) {
    return `
    <div class="border rounded-xl p-4 shadow-sm bg-green-50" id="review-card-${item.id}">
        <div class="flex items-center gap-4 mb-3">
            <img src="${productImage}" class="w-20 h-20 rounded-lg object-cover border shadow" alt="">
            <div>
                <h3 class="font-semibold text-gray-800">${productName}</h3>
                <p class="text-sm text-gray-500">Your Review</p>
            </div>
        </div>

        <div class="flex space-x-1 mb-3" id="stars-${item.id}">
            ${[1,2,3,4,5].map(n => `
                <svg onclick="setRating(${item.id}, ${n})"
                     class="w-6 h-6 cursor-pointer ${n <= (myReview.rating || 0) ? 'text-yellow-400' : 'text-gray-300'}"
                     fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674h4.91c.97 0 1.371 1.24.588 1.81l-3.975 2.89 1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.975-2.89-3.975 2.89c-.785.57-1.84-.197-1.54-1.118l1.518-4.674-3.975-2.89c-.783-.57-.382-1.81.588-1.81h4.91L9.05 2.927z"/>
                </svg>
            `).join('')}
        </div>

        <textarea id="text-${item.id}" rows="3"
            class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-indigo-500"
        >${(myReview.comment ?? '')}</textarea>

        <div class="mt-3 flex gap-2">
            <button onclick="updateReview('${reviewId}', ${item.id})"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Update</button>
            <button onclick="deleteReview('${reviewId}', ${item.id}, ${item.product_id})"
                class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">Delete</button>
        </div>
    </div>
    `;
}

// ---------- Stars ----------
function setRating(orderItemId, value) {
    ratings[orderItemId] = value;
    const stars = document.querySelectorAll(`#stars-${orderItemId} svg`);
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

// ---------- Create (no reload) ----------
async function submitReview(productId, orderItemId) {
    const text   = (document.getElementById(`text-${orderItemId}`).value || '').trim();
    const rating = ratings[orderItemId] || 0;

    if (!rating || !text) {
        Swal.fire("Error", "Please select a rating and write a review.", "error");
        return;
    }

    try {
        const resp = await axios.post('/api/reviews', {
            product_id: productId,
            order_item_id: orderItemId,
            rating,
            text
        });

        const review   = resp.data?.review || {};
        const reviewId = review._id?.$oid || review._id || review.id || '';

        // Flip card to "Your Review"
        const card = document.getElementById(`review-card-${orderItemId}`);
        if (card) {
            const productName  = card.querySelector('h3')?.textContent || 'Unnamed Product';
            const productImage = card.querySelector('img')?.src || '/images/placeholder.png';
            const myReview     = { rating, comment: text };
            card.outerHTML = renderReviewCard({ id: orderItemId, product_id: productId }, productName, productImage, myReview, reviewId);
        }

        updateSummary(+1);

        Swal.fire({ icon:"success", title:"Submitted", text:"Your review has been submitted!", timer:1200, showConfirmButton:false });
    } catch (err) {
        console.error(err);
        Swal.fire("Error", "Failed to submit review. Try again later.", "error");
    }
}

// ---------- Update (no reload) ----------
async function updateReview(reviewId, orderItemId) {
    if (!reviewId) {
        Swal.fire("Error", "Missing review ID. Please refresh and try again.", "error");
        return;
    }
    const text   = (document.getElementById(`text-${orderItemId}`).value || '').trim();
    const rating = ratings[orderItemId] || 0;

    try {
        await axios.put(`/api/reviews/${reviewId}`, { rating: rating || undefined, text });

        Swal.fire({ icon:"success", title:"Updated", text:"Your review has been updated.", timer:1200, showConfirmButton:false });
        const card = document.getElementById(`review-card-${orderItemId}`);
        if (card) { card.classList.add('ring-2','ring-indigo-300'); setTimeout(()=>card.classList.remove('ring-2','ring-indigo-300'), 900); }
    } catch (err) {
        console.error(err);
        Swal.fire("Error", "Could not update review.", "error");
    }
}

// ---------- Delete (no reload; send order_item_id so MySQL resets) ----------
async function deleteReview(reviewId, orderItemId, productId) {
    if (!reviewId) {
        Swal.fire("Error", "Missing review ID. Please refresh and try again.", "error");
        return;
    }

    try {
        await axios.delete(`/api/reviews/${reviewId}`, { data: { order_item_id: orderItemId } });

        // Flip back to form
        const card = document.getElementById(`review-card-${orderItemId}`);
        if (card) {
            const productName  = card.querySelector('h3')?.textContent || 'Unnamed Product';
            const productImage = card.querySelector('img')?.src || '/images/placeholder.png';
            card.outerHTML = renderFormCard({ id: orderItemId, product_id: productId }, productName, productImage, CURRENT_USER);
        }

        updateSummary(-1);

        Swal.fire({ icon:"success", title:"Deleted", text:"Your review has been removed.", timer:1200, showConfirmButton:false });
    } catch (err) {
        console.error(err);
        Swal.fire("Error", "Could not delete review.", "error");
    }
}
</script>
@endsection
