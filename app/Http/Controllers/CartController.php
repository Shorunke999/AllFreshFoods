<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        return view('cart.index', [
            'items' => $cart->items(),
            'total' => $cart->total(),
        ]);
    }

    public function store(Product $product, CartService $cart)
    {
        $cart->add($product);
        return back()->with('success', 'Added to cart');
    }

    public function destroy(Product $product)
    {
        session()->forget("cart.{$product->id}");
        return back();
    }
}
