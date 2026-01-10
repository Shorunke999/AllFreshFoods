<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        $products = Product::forUser(auth()->user())->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->service->create(
                $request->validated(),
                auth()->user()->vendor->id
            );

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->service->update($product, $request->validated());

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->service->delete($product);

            return back()->with('success', 'Product deleted');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
