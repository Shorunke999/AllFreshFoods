<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AllFreshFoods - Multi-Vendor Grocery Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-green-600">AllFreshFoods</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/products') }}" class="text-gray-700 hover:text-green-600">Browse Products</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-gray-900 mb-4">
                    Fresh Groceries from Local Vendors
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Shop from multiple vendors in one place. Fresh, convenient, and delivered to your door.
                </p>
                <a href="{{ url('/products') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold inline-block">
                    Start Shopping
                </a>
            </div>

            <!-- Registration Options -->
            @guest
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Customer Registration -->
                    <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Shop as Customer</h3>
                            <p class="text-gray-600 mt-2">Browse products from multiple vendors and order fresh groceries</p>
                        </div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Shop from multiple vendors</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Track your orders</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Fast delivery</span>
                            </li>
                        </ul>
                        <a href="{{ route('register.customer') }}"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold">
                            Register as Customer
                        </a>
                    </div>

                    <!-- Vendor Registration -->
                    <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition border-2 border-green-500">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Sell as Vendor</h3>
                            <p class="text-gray-600 mt-2">Start selling your products and reach more customers</p>
                        </div>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Manage your products</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Track sales & orders</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                <span class="text-gray-700">Grow your business</span>
                            </li>
                        </ul>
                        <a href="{{ route('register.vendor') }}"
                           class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold">
                            Register as Vendor
                        </a>
                    </div>
                </div>

                <p class="text-center mt-8 text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold">Log in here</a>
                </p>
            @else
                <div class="text-center">
                    <a href="{{ route('dashboard') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold inline-block">
                        Go to Dashboard
                    </a>
                </div>
            @endguest
        </div>

        <!-- Features Section -->
        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-3xl font-bold text-center text-gray-900 mb-12">Why Choose AllFreshFoods?</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Fresh Products</h4>
                        <p class="text-gray-600">Direct from local vendors to ensure quality and freshness</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Best Prices</h4>
                        <p class="text-gray-600">Compare prices from multiple vendors in one place</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Fast Delivery</h4>
                        <p class="text-gray-600">Quick and reliable delivery to your doorstep</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
