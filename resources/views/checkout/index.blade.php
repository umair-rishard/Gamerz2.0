@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Header --}}
<div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
  <div>
    <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Checkout</h1>
    <p class="mt-2 text-slate-600">Complete your order in just a few steps</p>
  </div>

  <div>
    {{-- Back to Cart --}}
    <a href="{{ route('cart.index') }}"
       class="px-5 py-3 rounded-xl bg-gradient-to-r from-slate-900 to-slate-800 text-white font-medium shadow-md hover:opacity-90 transition">
      ← Back to Cart
    </a>
  </div>
</div>


    

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
      {{-- ================= Left: Shipping & Payment ================= --}}
      <section class="lg:col-span-7">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
          {{-- Progress indicator --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-8 py-4">
            <div class="flex items-center justify-between text-white">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </div>
                <span class="font-semibold">Delivery Details</span>
              </div>
              <span class="text-sm text-white/80">Step 1 of 2</span>
            </div>
          </div>

          <form id="checkoutForm" class="p-8 space-y-8">
            @csrf

            {{-- Shipping --}}
            <div>
              <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                  </svg>
                </div>
                Shipping Information
              </h2>
              <p class="text-slate-600 mt-2">Where should we deliver your order?</p>
              
              <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                  <div class="relative">
                    <input name="name" type="text" required
                           class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400"
                           placeholder="John Doe">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                    </div>
                  </div>
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Phone Number</label>
                  <div class="relative">
                    <input name="phone" type="text" required
                           class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400"
                           placeholder="+94 77 123 4567">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                      </svg>
                    </div>
                  </div>
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Delivery Address</label>
                  <textarea name="address" rows="3" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400 resize-none"
                            placeholder="123 Main Street, Apartment 4B"></textarea>
                </div>

                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">City</label>
                  <input name="city" type="text" required
                         class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400"
                         placeholder="Colombo">
                </div>
                
                <div>
                  <label class="block text-sm font-semibold text-slate-700 mb-2">Postal Code</label>
                  <input name="postal" type="text" required
                         class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400"
                         placeholder="00100">
                </div>

                <div class="sm:col-span-2">
                  <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Delivery Instructions 
                    <span class="font-normal text-slate-500">(Optional)</span>
                  </label>
                  <textarea name="note" rows="2"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 placeholder-slate-400 resize-none"
                            placeholder="Gate code, building name, or special instructions..."></textarea>
                </div>
              </div>
            </div>

            {{-- Payment --}}
            <div class="pt-6 border-t border-slate-100">
              <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                  </svg>
                </div>
                Payment Method
              </h2>
              <p class="text-slate-600 mt-2">How would you like to pay?</p>
              
              <div class="mt-6 space-y-3">
                <label class="relative flex items-center p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-200 group">
                  <input type="radio" name="payment" value="cod" checked class="sr-only peer">
                  <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                      <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                      </div>
                      <div>
                        <p class="font-semibold text-slate-900">Cash on Delivery</p>
                        <p class="text-sm text-slate-600">Pay when you receive your order</p>
                      </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center">
                      <div class="w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                    </div>
                  </div>
                </label>

                <label class="relative flex items-center p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-200 group">
                  <input type="radio" name="payment" value="card" class="sr-only peer">
                  <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                      <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                      </div>
                      <div>
                        <p class="font-semibold text-slate-900">Credit/Debit Card</p>
                        <p class="text-sm text-slate-600">Secure payment with your card</p>
                      </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center">
                      <div class="w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                    </div>
                  </div>
                </label>

                <label class="relative flex items-center p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-200 group">
                  <input type="radio" name="payment" value="upi" class="sr-only peer">
                  <div class="flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                      <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                      </div>
                      <div>
                                                <p class="font-semibold text-slate-900">UPI Payment</p>
                        <p class="text-sm text-slate-600">Pay using your UPI app</p>
                      </div>
                    </div>
                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 flex items-center justify-center">
                      <div class="w-2 h-2 bg-white rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                    </div>
                  </div>
                </label>
              </div>
            </div>

            <div class="pt-6">
              <button id="placeOrderBtn" type="submit"
                      class="w-full relative overflow-hidden group bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed">
                <span class="relative z-10 flex items-center justify-center gap-3">
                  <svg id="spinner" class="hidden h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                  </svg>
                  <span id="btnText" class="text-lg">Complete Order</span>
                  <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                  </svg>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
              </button>
              <p id="checkoutError" class="hidden mt-3 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3"></p>
            </div>
          </form>
        </div>

        {{-- Security badges --}}
        <div class="mt-6 flex items-center justify-center gap-6 text-sm text-slate-500">
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span>Secure Checkout</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>SSL Encrypted</span>
          </div>
        </div>
      </section>

      {{-- ================= Right: Order Summary ================= --}}
      <aside class="lg:col-span-5">
        <div class="lg:sticky lg:top-8">
          <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-8 py-6">
              <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                  </svg>
                  Order Summary
                </h2>
                <button id="refreshCart" class="text-sm text-white/80 hover:text-white transition-colors flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                  Refresh
                </button>
              </div>
            </div>

            <div class="p-8">
              {{-- Loading --}}
              <div id="cartLoading" class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center gap-3">
                  <div class="w-12 h-12 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                  <p class="text-sm text-slate-500">Loading your items...</p>
                </div>
              </div>

              {{-- Items --}}
              <ul id="cartItems" class="hidden space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                {{-- injected by JS --}}
              </ul>

              {{-- Empty --}}
              <div id="cartEmpty" class="hidden text-center py-12">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p class="text-slate-500">Your cart is empty</p>
              </div>

              {{-- Totals --}}
              <div id="totalsBox" class="hidden mt-6 space-y-4">
                <div class="border-t border-slate-200 pt-6 space-y-3">
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600">Subtotal</span>
                    <span id="itemsTotal" class="font-semibold text-slate-900">0 LKR</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 flex items-center gap-2">
                      Discount
                      <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">SAVE</span>
                    </span>
                    <span id="discount" class="font-semibold text-green-600">-0 LKR</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-slate-600 flex items-center gap-2">
                      Shipping
                      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </span>
                    <span id="shipping" class="font-semibold text-slate-900">0 LKR</span>
                  </div>
                </div>
                
                <div class="border-t-2 border-slate-200 pt-4">
                  <div class="flex justify-between items-end">
                    <div>
                      <p class="text-sm text-slate-600">Total Amount</p>
                      <p class="text-2xl font-bold text-slate-900">Grand Total</p>
                    </div>
                    <div class="text-right">
                      <p id="grandTotal" class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">0 LKR</p>
                      <p class="text-xs text-slate-500 mt-1">Inclusive of all taxes</p>
                    </div>
                  </div>
                </div>

                {{-- Promo code --}}
                <div class="mt-6 p-4 bg-slate-50 rounded-xl">
                  <p class="text-sm font-semibold text-slate-700 mb-2">Have a promo code?</p>
                  <div class="flex gap-2">
                    <input type="text" placeholder="Enter code" class="flex-1 px-3 py-2 text-sm border border-slate-200 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                    <button class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition-colors">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Trust badges --}}
          <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Free Shipping</p>
                  <p class="text-sm text-slate-600">On orders over 5000 LKR</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                  </svg>
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Secure Payment</p>
                  <p class="text-sm text-slate-600">100% secure transactions</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                </div>
                <div>
                  <p class="font-semibold text-slate-900">Easy Returns</p>
                  <p class="text-sm text-slate-600">30-day return policy</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const token = localStorage.getItem('token');
  const headers = token ? { Authorization: `Bearer ${token}` } : {};

  const cartLoading = document.getElementById('cartLoading');
  const cartItemsEl = document.getElementById('cartItems');
    const cartEmptyEl = document.getElementById('cartEmpty');
  const totalsBox   = document.getElementById('totalsBox');
  const itemsTotal  = document.getElementById('itemsTotal');
  const discount    = document.getElementById('discount');
  const shipping    = document.getElementById('shipping');
  const grandTotal  = document.getElementById('grandTotal');

  const errorEl     = document.getElementById('checkoutError');
  const placeBtn    = document.getElementById('placeOrderBtn');
  const spinner     = document.getElementById('spinner');
  const btnText     = document.getElementById('btnText');

  function money(n, cur = 'LKR') {
    // basic formatter without Intl, keeps it lightweight
    const num = Number(n || 0);
    return `${num.toLocaleString('en-LK')} ${cur}`;
  }

  async function loadCheckout() {
    errorEl.classList.add('hidden');
    cartItemsEl.classList.add('hidden');
    cartEmptyEl.classList.add('hidden');
    totalsBox.classList.add('hidden');
    cartLoading.classList.remove('hidden');

    try {
      const res = await axios.get('/api/checkout', { headers });
      const data   = res?.data || {};
      const items  = Array.isArray(data.items) ? data.items : [];
      const totals = data.totals || { items_total:0, discount:0, shipping:0, grand_total:0, currency:'LKR' };

      if (!items.length) {
        cartEmptyEl.classList.remove('hidden');
        return;
      }

      let html = '';
      items.forEach(it => {
        const img  = it.image || '';
        const name = it.name || 'Product';
        const qty  = Number(it.quantity || 0);
        const unit = Number(it.unit_price || 0);
        const sub  = Number(it.subtotal || (qty * unit));

        html += `
          <li class="group flex gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
            <div class="relative h-20 w-20 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center overflow-hidden ring-1 ring-slate-200/50 group-hover:ring-slate-300 transition-all">
              ${img
                ? `<img src="${img}" alt="${name}" class="h-full w-full object-cover">`
                : `<svg viewBox="0 0 24 24" class="h-8 w-8 text-slate-400">
                    <path fill="currentColor" d="M21 7H7V3H3v18h18V7zM7 19H5V5h2v14zm2 0V9h10v10H9z"/>
                   </svg>`
              }
              <div class="absolute top-1 right-1 w-6 h-6 bg-slate-900 text-white text-xs font-bold rounded-full flex items-center justify-center">
                ${qty}
              </div>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-start justify-between gap-2">
                <div class="flex-1">
                  <p class="font-semibold text-slate-900 truncate">${name}</p>
                  <p class="text-sm text-slate-500 mt-1">Unit price: ${money(unit, totals.currency)}</p>
                </div>
                <div class="text-right">
                  <p class="font-bold text-slate-900">${money(sub, totals.currency)}</p>
                  <p class="text-xs text-slate-500 mt-1">× ${qty}</p>
                </div>
              </div>
            </div>
          </li>
        `;
      });

      cartItemsEl.innerHTML = html;
      itemsTotal.textContent = money(totals.items_total, totals.currency);
      discount.textContent   = totals.discount > 0 ? `-${money(totals.discount, totals.currency)}` : money(0, totals.currency);
      shipping.textContent   = money(totals.shipping, totals.currency);
      grandTotal.textContent = money(totals.grand_total, totals.currency);

      cartItemsEl.classList.remove('hidden');
      totalsBox.classList.remove('hidden');
    } catch (e) {
      console.error(e);
      errorEl.textContent = 'Could not load checkout summary. Please refresh.';
      errorEl.classList.remove('hidden');
    } finally {
      cartLoading.classList.add('hidden');
    }
  }

  document.getElementById('refreshCart').addEventListener('click', (e) => {
    e.preventDefault();
    loadCheckout();
  });

  loadCheckout();

  // Place order
  document.getElementById('checkoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    errorEl.classList.add('hidden');
    spinner.classList.remove('hidden');
    btnText.textContent = 'Processing...';
    placeBtn.disabled = true;

    const fd = new FormData(e.target);
    const data = {
      shipping_name:    fd.get('name'),
      shipping_phone:   fd.get('phone'),
      shipping_address: fd.get('address'),
      shipping_city:    fd.get('city'),
      shipping_postal:  fd.get('postal'),
      shipping_note:    fd.get('note'),
      payment_method:   fd.get('payment')
    };

    try {
      const res = await axios.post('/api/orders', data, { headers });
      const orderId = res?.data?.order?.id;
      if (!orderId) throw new Error('Order created but ID missing.');
      
      // Success animation before redirect
      btnText.textContent = 'Order Placed!';
      placeBtn.classList.add('bg-green-600', 'from-green-600', 'to-green-700');
      
      setTimeout(() => {
        window.location.href = `/orders/${orderId}/confirm`;
      }, 1000);
    } catch (err) {
      console.error(err);
      const msg = err?.response?.data?.message || err?.message || 'Order failed';
      errorEl.textContent = msg;
      errorEl.classList.remove('hidden');
      spinner.classList.add('hidden');
      btnText.textContent = 'Complete Order';
      placeBtn.disabled = false;
    }
  });

  // Radio button styling
  document.querySelectorAll('input[name="payment"]').forEach(radio => {
    radio.addEventListener('change', function() {
      // Reset all labels
      document.querySelectorAll('input[name="payment"]').forEach(r => {
        r.closest('label').classList.remove('border-indigo-500', 'bg-indigo-50/50');
        r.closest('label').classList.add('border-slate-200');
      });
      
      // Style selected label
      if (this.checked) {
        this.closest('label').classList.remove('border-slate-200');
        this.closest('label').classList.add('border-indigo-500', 'bg-indigo-50/50');
      }
    });
  });

  // Trigger initial styling
  document.querySelector('input[name="payment"]:checked')?.dispatchEvent(new Event('change'));
});
</script>
@endpush