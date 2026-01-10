<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    public function add(Product $product, int $qty = 1): void
    {
        $cart = session()->get('cart', []);

        $cart[$product->id]['quantity'] =
            ($cart[$product->id]['quantity'] ?? 0) + $qty;

        $cart[$product->id] += [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'vendor_id' => $product->vendor_id,
        ];

        session()->put('cart', $cart);
    }

    public function items(): array
    {
        return session('cart', []);
    }

    public function total(): float
    {
        return collect($this->items())
            ->sum(fn ($i) => $i['price'] * $i['quantity']);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }
}
