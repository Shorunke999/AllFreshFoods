@extends('layouts.vendor')

@section('vendor-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl text-gray-800 mb-6">Vendor Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- My Products -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">My Products</div>
                <div class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['product_count'] ?? 0 }}</div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Pending Orders</div>
                <div class="text-3xl font-bold text-orange-600 mt-2">{{ $stats['pending_orders'] ?? 0 }}</div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <div class="text-gray-500 text-sm font-medium">Total Revenue</div>
                <div class="text-3xl font-bold text-green-600 mt-2">${{ number_format($stats['revenue'] ?? 0, 2) }}</div>
            </div>
        </div>

        <!-- My Recent Products -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">My Recent Products</h3>
                    <a href="{{ route('vendor.products.create') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                        Add New Product
                    </a>
                </div>

                @if(isset($recent_products) && $recent_products->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recent_products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">You haven't created any products yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
