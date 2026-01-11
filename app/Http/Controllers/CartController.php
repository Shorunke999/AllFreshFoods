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

    public function store(Product $product, CartService $cart,Request $request)
    {
        $validated = $request->validate([
            'quantity' =>['required', 'integer']
        ]);
        $cart->add($product,$validated['quantity']);
        return back()->with('success', 'Added to cart');
    }

    public function update(Request $request, Product $product, CartService $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $cart->update($product, $validated['quantity']);

        return back()->with('success', 'Cart updated');
    }
    public function destroy(Product $product)
    {
        session()->forget("cart.{$product->id}");
        return back();
    }
}
