@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-4 mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-4 mt-4">
                {{ session('error') }}
            </div>
        @endif
        @php
            $cartCount = collect(session('cart',[]))->count();
        @endphp
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-2xl text-gray-800">Products</h2>
            <a href="{{ url('/cart') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md relative">
                   🛒
            @if($cartCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-600 text-white
                            text-xs w-5 h-5 flex items-center justify-center rounded-full">
                    {{ $cartCount }}
                </span>
            @endif
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6 p-4">
            <form method="GET" class="flex gap-3">
                <input type="text"
                       name="search"
                       placeholder="Search products..."
                       value="{{ request('search') }}"
                       class="flex-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                <select name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    Filter
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 60) }}</p>
                        <p class="text-lg font-bold text-green-600 mt-2">${{ number_format($product->price, 2) }}</p>

                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="flex items-center gap-2 mb-2">
                                    <label class="text-sm text-gray-600">Qty:</label>
                                    <input type="number"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="{{ $product->stock }}"
                                           class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md text-sm">
                                    <span class="text-xs text-gray-500">{{ $product->stock }} available</span>
                                </div>
                                <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-2 px-4 rounded">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-600 text-sm py-2 px-4 rounded mt-4">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No products found
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
