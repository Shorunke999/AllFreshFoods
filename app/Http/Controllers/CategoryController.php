<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service)
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->service->create($request->validated());

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $this->service->update($category, $request->validated());

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Category $category)
    {
        try {
            $this->service->delete($category);

            return back()->with('success', 'Category deleted successfully.');

        } catch (\RuntimeException $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}

