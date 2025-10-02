@extends('layouts.app')

@section('content')
<div class="relative bg-gradient-to-br from-slate-50 via-white to-indigo-50 min-h-screen">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    {{-- ===== HERO ===== --}}
    <section class="relative">
        <div class="mx-auto max-w-7xl px-6 pt-20 pb-16">
            {{-- Breadcrumb --}}
            <nav class="text-sm mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center gap-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="text-gray-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li class="text-gray-900 font-medium">Contact</li>
                </ol>
            </nav>

            {{-- Hero Content --}}
            <div class="grid gap-12 lg:grid-cols-12 items-center">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-medium mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        We're online now
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-indigo-800 to-purple-800">
                        Let's Connect
                    </h1>
                    <p class="mt-6 text-xl text-gray-600 leading-relaxed max-w-2xl">
                        Have a question or want to work together? Drop us a message and we'll get back to you within 24 hours.
                    </p>
                    
                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="#contact-form" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transform hover:-translate-y-1 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Message
                        </a>
                        <a href="tel:+1234567890" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-900 font-semibold rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:shadow-lg transform hover:-translate-y-1 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Call Now
                        </a>
                    </div>
                </div>

                {{-- Stats Card --}}
                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl transform rotate-3"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-8 backdrop-blur-lg bg-white/95">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">24h</div>
                                    <div class="text-sm text-gray-600 mt-1">Response Time</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">98%</div>
                                    <div class="text-sm text-gray-600 mt-1">Satisfaction</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">24/7</div>
                                    <div class="text-sm text-gray-600 mt-1">Support</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">5★</div>
                                    <div class="text-sm text-gray-600 mt-1">Rating</div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex -space-x-2">
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=John&background=6366f1&color=fff" alt="">
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Sarah&background=ec4899&color=fff" alt="">
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://ui-avatars.com/api/?name=Mike&background=8b5cf6&color=fff" alt="">
                                    </div>
                                    <span class="text-sm text-gray-600">Support team ready</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CONTACT OPTIONS ===== --}}
    <section class="mx-auto max-w-7xl px-6 py-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Phone Card --}}
            <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform"></div>
                <div class="relative">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 text-white mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Phone</h3>
                    <p class="mt-2 text-gray-600">+1 (234) 567-890</p>
                    <a href="tel:+1234567890" class="mt-4 inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-purple-600 transition-colors">
                        Call now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Email Card --}}
            <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-pink-100 to-purple-100 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform"></div>
                <div class="relative">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Email</h3>
                    <p class="mt-2 text-gray-600">gamerz@gmail.com</p>
                    <a href="mailto:gamerz@gmail.com" class="mt-4 inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-purple-600 transition-colors">
                        Write to us
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Live Chat Card --}}
            <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform"></div>
                <div class="relative">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Live Chat</h3>
                    <p class="mt-2 text-gray-600">Instant support</p>
                    <button type="button" class="mt-4 inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-purple-600 transition-colors">
                        Start chat
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Office Card --}}
            <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 cursor-pointer overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full -mr-10 -mt-10 group-hover:scale-150 transition-transform"></div>
                <div class="relative">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Office</h3>
                    <p class="mt-2 text-gray-600">123 Gaming Street, CA</p>
                    <a href="#map" class="mt-4 inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-purple-600 transition-colors">
                        View map
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== MAP + FORM ===== --}}
    <section class="mx-auto max-w-7xl px-6 pb-20">
        <div class="grid gap-8 lg:grid-cols-2">
            {{-- Map --}}
            <div id="map" class="relative rounded-3xl overflow-hidden shadow-2xl h-[500px] lg:h-auto">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-600/10 z-10 pointer-events-none"></div>
                <iframe
                    title="Office Location"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.95373531531697!3d-37.81720997975153!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzfCsDQ5JzAyLjAiUyAxNDTCsDU3JzE0LjQiRQ!5e0!3m2!1sen!2s!4v1612911385285!5m2!1sen!2s"
                    width="100%" height="100%" style="border:0; min-height: 500px;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            {{-- Form --}}
            <div id="contact-form" class="bg-white rounded-3xl shadow-2xl p-8 lg:p-10">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Send us a message</h2>
                    <p class="mt-2 text-gray-600">We'll get back to you within 24 hours.</p>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Your Name</label>
                            <input id="name" name="name" type="text" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all"
                                   placeholder="John Doe">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input id="email" name="email" type="email" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all"
                                   placeholder="john@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <select id="subject" name="subject" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all">
                            <option>General Inquiry</option>
                            <option>Technical Support</option>
                            <option>Business Partnership</option>
                            <option>Feedback</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all resize-none"
                                  placeholder="Tell us how we can help you..."></textarea>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" id="copy" class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="copy" class="ml-3 text-sm text-gray-600">
                            Send me a copy of this message and subscribe to newsletter
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-indigo-500/25 transform hover:-translate-y-1 transition-all">
                        Send Message
                        <svg class="inline-block w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </form>

                <p class="mt-6 text-xs text-center text-gray-500">
                    By submitting this form, you agree to our 
                    <a href="#" class="text-indigo-600 hover:underline">Privacy Policy</a> and 
                    <a href="#" class="text-indigo-600 hover:underline">Terms of Service</a>
                </p>
            </div>
        </div>
    </section>

    {{-- ===== FAQ ===== --}}
    <section class="mx-auto max-w-4xl px-6 pb-20">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                FAQ
            </span>
            <h2 class="text-4xl font-bold text-gray-900">Frequently Asked Questions</h2>
            <p class="mt-3 text-xl text-gray-600">Everything you need to know</p>
        </div>

        <div class="space-y-4">
            <details class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                <summary class="flex cursor-pointer list-none items-center justify-between p-6 font-semibold text-gray-900">
                    <span>How quickly do you respond to messages?</span>
                    <span class="ml-6 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 group-open:bg-indigo-100 transition-colors">
                        <svg class="h-5 w-5 text-indigo-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6">
                    <p class="text-gray-600">We typically respond within 24 hours on business days. For urgent matters, please call us directly or use our live chat feature for immediate assistance.</p>
                </div>
            </details>

            <details class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                <summary class="flex cursor-pointer list-none items-center justify-between p-6 font-semibold text-gray-900">
                    <span>What are your support hours?</span>
                    <span class="ml-6 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 group-open:bg-indigo-100 transition-colors">
                        <svg class="h-5 w-5 text-indigo-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6">
                    <p class="text-gray-600">Our support team is available Monday through Friday, 9:00 AM to 6:00 PM PST. We also offer 24/7 emergency support for critical issues.</p>
                </div>
            </details>

            <details class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                <summary class="flex cursor-pointer list-none items-center justify-between p-6 font-semibold text-gray-900">
                    <span>Do you offer phone support?</span>
                    <span class="ml-6 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 group-open:bg-indigo-100 transition-colors">
                        <svg class="h-5 w-5 text-indigo-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6">
                    <p class="text-gray-600">Yes! You can reach us at +1 (234) 567-890 during business hours. We also offer scheduled phone consultations for complex issues.</p>
                </div>
            </details>

            <details class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all">
                <summary class="flex cursor-pointer list-none items-center justify-between p-6 font-semibold text-gray-900">
                    <span>Can I visit your office?</span>
                    <span class="ml-6 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 group-open:bg-indigo-100 transition-colors">
                        <svg class="h-5 w-5 text-indigo-600 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </summary>
                <div class="px-6 pb-6">
                    <p class="text-gray-600">Absolutely! Our office at 123 Gaming Street, CA is open for visits. Please schedule an appointment in advance to ensure someone is available to meet with you.</p>
                </div>
            </details>
        </div>
    </section>

    {{-- ===== SOCIAL CALLOUT ===== --}}
    <section class="bg-gradient-to-br from-indigo-50 to-purple-50">
        <div class="mx-auto max-w-7xl px-6 py-16">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-purple-600 p-8 md:p-12 shadow-2xl">
                <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
                
                <div class="relative grid gap-8 lg:grid-cols-2 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white">Connect on Social Media</h3>
                        <p class="mt-3 text-indigo-100 text-lg">Follow us for updates, tips, and quick support through DMs.</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-4 lg:justify-end">
                        <a href="#" class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-6 py-3 rounded-xl hover:bg-white hover:text-indigo-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </a>
                        
                        <a href="#" class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-6 py-3 rounded-xl hover:bg-white hover:text-indigo-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                            Instagram
                        </a>
                        
                        <a href="#" class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-lg text-white px-6 py-3 rounded-xl hover:bg-white hover:text-indigo-600 transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection