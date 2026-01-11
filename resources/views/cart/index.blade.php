@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
        <a href="{{ url()->previous() !== url()->current()
            ? url()->previous()
            : url('/products') }}"
        class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200
                text-gray-700 px-3 py-2 rounded-md text-sm mb-4">
            ← Back
        </a>
        <h2 class="font-semibold text-2xl text-gray-800 mb-6">Shopping Cart</h2>

        @if($total > 0)
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    @foreach($items as $item)
                        <div class="flex items-center gap-4 py-4 border-b last:border-b-0">
                            @if($item['product']->image_path)
                                <img src="{{ Storage::url($item['product']->image_path) }}"
                                     alt="{{ $item['product']->name }}"
                                     class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h3 class="font-semibold">{{ $item['product']->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $item['product']->category->name }}</p>
                                <p class="text-sm text-gray-500">Vendor: {{ $item['product']->vendor->name }}</p>
                                 <p class="text-xs text-gray-400">Stock: {{ $item['product']->stock }}</p>
                            </div>

                             <div class="flex items-center gap-2">
                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <label class="text-sm text-gray-600">Qty:</label>
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           max="{{ $item['product']->stock }}"
                                           class="w-20 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md text-sm"
                                           onchange="this.form.submit()">
                                </form>
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-600">Price</p>
                                <p class="font-bold text-green-600">${{ number_format($item['product']->price * $item['quantity'], 2) }}</p>
                            </div>

                            <form action="{{ route('cart.destroy', $item['product']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold">Total:</span>
                    <span class="text-2xl font-bold text-green-600">${{ number_format($total, 2) }}</span>
                </div>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-4 rounded-md font-semibold">
                        Proceed to Checkout
                    </button>
                </form>

                <a href="{{ url('/products') }}"
                   class="block text-center mt-3 text-indigo-600 hover:text-indigo-800">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-12 text-center">
                <p class="text-gray-500 mb-4">Your cart is empty</p>
                <a href="{{ url('/products') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md inline-block">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
