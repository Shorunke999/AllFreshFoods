<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CategoryService $service)
    {

    }

    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        try {
            $this->service->create($request->validated());
            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        try {
            $this->service->update($category, $request->validated());

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\RuntimeException $e) {
            return back()->with('error',$e->getMessage())->withInput();
        }
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        try {
            $this->service->delete($category);

            return back()->with('success', 'Category deleted successfully.');

        } catch (\RuntimeException $e) {
            return back()->with('error',$e->getMessage());
        }
    }
}

