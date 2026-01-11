<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private ProductService $service)
    {
    }

    public function index()
    {
        $products = $this->service->listProducts(auth()->user());
        $role = auth()->user()->role->value;

        return view($role.'.products.index', [
            'products' => $products,
            'categories' => Category::all(),
            'vendors' => $role === UserRole::ADMIN->value ? Vendor::all() : null,
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
    public function catalog(Request $request)
    {
        $query = Product::with(['vendor', 'category'])->where('stock', '>', 0);

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }
}
