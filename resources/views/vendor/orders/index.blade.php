@extends('layouts.vendor')

@section('vendor-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-2xl text-gray-800 mb-6">My Orders</h2>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            @if(isset($orderItems) && $orderItems->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orderItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $item->order_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->product->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->order->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($item->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($item->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($item->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($item->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <form action="{{ route('vendor.order.item.update', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="text-xs border-gray-300 rounded">
                                        <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $item->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $item->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $item->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12 text-gray-500">
                    No orders found
                </div>
            @endif
        </div>

        @if(isset($orderItems) && $orderItems->hasPages())
            <div class="mt-4">
                {{ $orderItems->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
