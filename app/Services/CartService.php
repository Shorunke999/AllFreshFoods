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
        $cart = session('cart', []);

        if (empty($cart)) {
            return [];
        }

        $products = Product::with(['category', 'vendor'])
            ->whereIn('id', collect($cart)->pluck('product_id'))
            ->get()
            ->keyBy('id');

        return collect($cart)->map(function ($item) use ($products) {
            return [
                'product' => $products[$item['product_id']],
                'quantity' => $item['quantity'],
            ];
        })->values()->all();
    }

    public function update(Product $product, int $quantity): void
    {
        if ($quantity > $product->stock) {
            throw new \RuntimeException('Quantity exceeds available stock');
        }

        session()->put("cart.{$product->id}.quantity", $quantity);
    }
    public function total(): float
    {
        return collect(session('cart', []))
            ->sum(fn ($i) => $i['price'] * $i['quantity']);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }
}
