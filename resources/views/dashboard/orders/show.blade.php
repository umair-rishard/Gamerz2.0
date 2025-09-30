@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-8">

        {{-- Header --}}
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-black to-black bg-clip-text text-transparent">
                Order Details
            </h1>
            <p class="text-gray-600 text-lg">Track your order journey and review purchase information</p>
        </div>

        {{-- Order Timeline --}}
        <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Order Timeline
            </h2>
            <div class="relative">
                <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200 rounded-full" id="progressBar"></div>
                <div id="timelineContainer" class="relative flex justify-between items-start z-10"></div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20">
            <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Order Items
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-indigo-100">
                            <th class="py-4 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Product</th>
                            <th class="py-4 px-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                            <th class="py-4 px-4 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                            <th class="py-4 px-4 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody" class="divide-y divide-gray-100">
                        <tr><td colspan="4" class="py-8 text-center text-gray-400">Loading items...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            {{-- Order Summary --}}
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl shadow-lg text-white">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Order Summary
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                        <span class="text-emerald-50">Order Date</span>
                        <span class="font-semibold" id="orderDate">-</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                        <span class="text-emerald-50">Order Status</span>
                        <span class="font-semibold px-3 py-1 bg-white/20 rounded-full text-sm backdrop-blur-sm" id="orderStatus">-</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-white/20">
                        <span class="text-emerald-50">Payment Method</span>
                        <span class="font-semibold" id="orderPayment">-</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold">Total Amount</span>
                        <span class="text-2xl font-bold">LKR <span id="orderTotal">0</span></span>
                    </div>
                </div>
            </div>

            {{-- Actions Card --}}
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg border border-white/20 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Quick Actions
                    </h2>
                    <p class="text-gray-600 mb-6">Download your receipt or contact support if you need assistance</p>
                </div>
                <div class="space-y-3">
                    <a id="receiptBtn" href="#" 
                       class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Receipt
                    </a>
                    <a href="http://127.0.0.1:8000/dashboard" 
                       class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-gray-800 text-white rounded-xl font-semibold hover:bg-black transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Axios --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    let orderId = "{{ $id }}";
    try {
        let res = await axios.get(`/api/orders/${orderId}`);
        let order = res.data;

        // Summary
        document.getElementById('orderDate').innerText = new Date(order.created_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        document.getElementById('orderStatus').innerText = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        document.getElementById('orderTotal').innerText = Number(order.total).toLocaleString();
        document.getElementById('orderPayment').innerText = order.payment_method;
        document.getElementById('receiptBtn').href = `/orders/${order.id}/receipt`;

        // Items with enhanced styling
        let itemsBody = document.getElementById('itemsBody');
        itemsBody.innerHTML = '';
        order.items.forEach((item, index) => {
            itemsBody.innerHTML += `
                <tr class="group hover:bg-indigo-50/50 transition-colors duration-200">
                    <td class="py-5 px-4">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="${item.product?.image_url ?? '/images/placeholder.png'}" 
                                     alt="${item.product?.name ?? 'Product'}" 
                                     class="w-16 h-16 rounded-xl object-cover border-2 border-gray-100 group-hover:border-indigo-200 transition-colors shadow-sm">
                                <div class="absolute -top-1 -right-1 w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow">
                                    ${index + 1}
                                </div>
                            </div>
                            <span class="font-semibold text-gray-800 text-base">
                                ${item.product?.name ?? 'Unknown Product'}
                            </span>
                        </div>
                    </td>
                    <td class="py-5 px-4 text-center">
                        <span class="inline-flex items-center justify-center w-10 h-10 bg-indigo-100 text-indigo-700 font-bold rounded-lg">
                            ${item.quantity}
                        </span>
                    </td>
                    <td class="py-5 px-4 text-right font-semibold text-gray-700">
                        LKR ${Number(item.price).toLocaleString()}
                    </td>
                    <td class="py-5 px-4 text-right font-bold text-indigo-600 text-lg">
                        LKR ${(item.price * item.quantity).toLocaleString()}
                    </td>
                </tr>
            `;
        });

        // Enhanced Timeline with icons like the reference image
        const steps = [
            { 
                name: "placed", 
                label: "Order Placed",
                icon: '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
            },
            { 
                name: "confirmed", 
                label: "Processing",
                icon: '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>'
            },
            { 
                name: "shipped", 
                label: "Shipped",
                icon: '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>'
            },
            { 
                name: "delivered", 
                label: "Delivered",
                icon: '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>'
            }
        ];
        
        let timeline = document.getElementById('timelineContainer');
        let currentStepIndex = steps.findIndex(s => s.name === order.status);
        
        timeline.innerHTML = '';
        steps.forEach((step, index) => {
            let isActive = index <= currentStepIndex;
            let isComplete = index < currentStepIndex;
            let isCurrent = index === currentStepIndex;
            
            timeline.innerHTML += `
                <div class="flex flex-col items-center" style="width: ${100 / steps.length}%">
                    <div class="relative mb-3">
                        <div class="w-16 h-16 flex items-center justify-center rounded-full ${
                            isCurrent ? 'bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg' :
                            isComplete ? 'bg-emerald-500 shadow-md' :
                            'bg-gray-300 shadow'
                        } transition-all duration-500">
                            ${isComplete ? 
                                '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>' :
                                step.icon
                            }
                        </div>
                    </div>
                    <span class="text-sm font-bold ${isActive ? 'text-gray-800' : 'text-gray-400'} text-center">
                        ${step.label}
                    </span>
                    <span class="text-xs ${isActive ? 'text-gray-500' : 'text-gray-400'} mt-1">
                        ${isCurrent ? 'Just now' : index === 0 ? 'Completed' : index < currentStepIndex ? 'Completed' : `${index + 1}-${index + 3} days`}
                    </span>
                </div>
            `;
        });

        // Animate progress bar
        let progressPercent = ((currentStepIndex) / (steps.length - 1)) * 100;
        let progressBar = document.getElementById('progressBar');
        progressBar.style.background = `linear-gradient(to right, #10b981 0%, #14b8a6 ${progressPercent}%, #e5e7eb ${progressPercent}%, #e5e7eb 100%)`;

    } catch (err) {
        console.error(err);
        document.getElementById('itemsBody').innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-8">
                    <div class="text-red-500 font-semibold">Failed to load order details</div>
                    <div class="text-gray-500 text-sm mt-2">Please try refreshing the page</div>
                </td>
            </tr>
        `;
    }
});
</script>
@endsection