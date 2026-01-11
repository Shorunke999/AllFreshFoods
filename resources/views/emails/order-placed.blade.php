@component('mail::message')
# Order Confirmed!

Hi {{ $order->user->name }},

Your order has been successfully placed and is being processed.

## Order Details

**Order Number:** #{{ $order->id }}
**Order Date:** {{ $order->created_at->format('F d, Y h:i A') }}
**Status:** {{ ucfirst($order->status) }}

## Order Items

@foreach($order->items as $item)
**{{ $item->product->name }}**
Vendor: {{ $item->vendor->name }}
Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->price * $item->quantity, 2) }}

---
@endforeach

## Total Amount
**${{ number_format($order->total, 2) }}**

@component('mail::button', ['url' => route('orders.show', $order)])
View Order Details
@endcomponent

We'll send you another email when your order ships.

Thanks for shopping with AllFreshFoods!

{{ config('app.name') }}
@endcomponent
