<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ProductService $service)
    {
    }

    public function index()
    {
        $this->authorize('viewAny', Product::class);
        return view('vendor.products.index', [
            'products' => Product::forUser(auth()->user())->paginate(10),
            'categories' => Category::all(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Product::class);
        return view('vendor.products.create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);
        try {

            $this->service->create(
                $request->validated(),
                auth()->user()->vendor->id
            );

            return redirect()->route('vendor.products.index')
                ->with('success', 'Product created successfully');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('vendor.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        try {
            $this->service->update($product, $request->validated());

            return redirect()->route('vendor.products.index')
                ->with('success', 'Product updated successfully');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        try {
            $this->service->delete($product);

            return back()->with('success', 'Product deleted');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
