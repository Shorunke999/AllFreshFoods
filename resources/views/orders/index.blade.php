@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            <p class="font-bold">Order Placed Successfully!</p>
            <p class="text-sm">Thank you for your order. We'll send you updates via email.</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-xl mb-4">Order Details</h2>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600">Order Number</p>
                    <p class="font-semibold">#{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Order Date</p>
                    <p class="font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="font-semibold">
                        <span class="px-2 py-1 text-xs rounded
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Amount</p>
                    <p class="font-bold text-lg text-green-600">${{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
            <h3 class="font-semibold text-lg mb-4">Order Items</h3>

            @foreach($order->items as $item)
                <div class="flex items-center gap-4 py-4 border-b last:border-b-0">
                    @if($item->product->image_path)
                        <img src="{{ Storage::url($item->product->image_path) }}"
                             alt="{{ $item->product->name }}"
                             class="w-16 h-16 object-cover rounded">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No Image</span>
                        </div>
                    @endif

                    <div class="flex-1">
                        <h4 class="font-semibold">{{ $item->product->name }}</h4>
                        <p class="text-sm text-gray-600">Vendor: {{ $item->vendor->name }}</p>
                        <p class="text-sm text-gray-500">
                            Status:
                            <span class="px-2 py-1 text-xs rounded
                                @if($item->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($item->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($item->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($item->status === 'delivered') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">Qty</p>
                        <p class="font-semibold">{{ $item->quantity }}</p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-600">Price</p>
                        <p class="font-bold">${{ number_format($item->price, 2) }}</p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-600">Subtotal</p>
                        <p class="font-bold text-green-600">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 text-center">
            <a href="{{ url('/products') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md inline-block">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
