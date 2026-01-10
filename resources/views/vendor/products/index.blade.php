@extends('layouts.vendor')

@section('vendor-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-2xl text-gray-800">My Products</h2>
            <a href="{{ route('vendor.products.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Add Product
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6 p-4">
            <form method="GET" action="{{ route('vendor.products.index') }}" class="flex gap-3">
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
                        <p class="text-lg font-bold text-green-600 mt-2">${{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('vendor.products.edit', $product) }}"
                               class="bg-indigo-500 hover:bg-indigo-700 text-white text-sm py-1 px-3 rounded flex-1 text-center">
                                Edit
                            </a>

                            <form action="{{ route('vendor.products.destroy', $product) }}"
                                  method="POST"
                                  class="flex-1"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3 rounded w-full">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    You haven't created any products yet
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
