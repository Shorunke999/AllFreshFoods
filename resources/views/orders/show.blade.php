@extends(
    auth()->user()->isAdmin()
        ? 'layouts.admin'
        : (auth()->user()->isVendor() ? 'layouts.vendor' : 'layouts.app')
)

@section('content')
<div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

    <a href="{{ auth()->user()->role->value == 'admin' ? url()->previous() : url('/products') }}"
        class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200
            text-gray-700 px-3 py-2 rounded-md text-sm mb-4">
        ← Finish
    </a>
    {{-- Order Header --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Order #{{ $order->id }}
                </h2>

                @if(isset($order->user))
                    <p class="text-sm text-gray-500">
                        Customer: {{ $order->user->name }} ({{ $order->user->email }})
                    </p>
                @endif
            </div>

            <span class="px-3 py-1 rounded text-sm
                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                @elseif($order->status === 'completed') bg-green-100 text-green-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <p class="mt-2 text-sm text-gray-500">
            Placed on {{ $order->created_at->format('M d, Y • H:i') }}
        </p>
    </div>

    {{-- Order Items --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Status</th>

                    @if(auth()->user()->isVendor())
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                    @endif
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $item->product->name }}
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $item->vendor->name ?? '—' }}
                    </td>

                    <td class="px-6 py-4 text-center text-sm">
                        {{ $item->quantity }}
                    </td>

                    <td class="px-6 py-4 text-right text-sm text-gray-700">
                        ${{ number_format($item->price * $item->quantity, 2) }}
                    </td>

                    <td class="px-6 py-4 text-right text-sm">
                        <span class="px-2 py-1 text-xs rounded
                            @if($item->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($item->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($item->status === 'completed') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($item->status->value) }}
                        </span>
                    </td>

                    {{-- Vendor status update --}}
                    @if(auth()->user()->isVendor())
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('vendor.order.item.update', $item) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <select name="status"
                                onchange="this.form.submit()"
                                class="text-sm rounded border-gray-300">
                                @foreach(['pending','processing','completed'] as $status)
                                    <option value="{{ $status }}"
                                        @selected($item->status === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Order Total --}}
    @if(!auth()->user()->isVendor())
    <div class="mt-6 text-right">
        <p class="text-lg font-semibold">
            Total: ${{ number_format($order->total, 2) }}
        </p>
    </div>
    @endif

</div>
@endsection
