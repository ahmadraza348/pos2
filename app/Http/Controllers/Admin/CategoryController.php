<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use App\Http\Requests\Admin\{StoreCategoryRequest, ImportCategoryRequest, UpdateCategoryRequest, BulkDeleteCategoryRequest};

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

public function index()
{
    $data['categories_data'] = Category::ordered()->get();
    $data['editable_category'] = null;

    return view('backend.inventory.categories', $data);
}

    public function store(StoreCategoryRequest $request)
    {
        $this->service->create($request->validated());
        toastr()->success('Category created successfully');
        return redirect()->route('category.index');
    }

public function edit(Category $category)
{
    $data['categories_data'] = Category::ordered()->get();
    $data['editable_category'] = $category;

    return view('backend.inventory.categories', $data);
}

    public function update(UpdateCategoryRequest $request, Category $category) 
    {
        $this->service->update($category, $request->validated());
        toastr()->success('Category updated successfully');
        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $this->service->delete($category);
        toastr()->success('Category Deleted Successfully');
        return back();
    }

    public function bulkDelete(BulkDeleteCategoryRequest $request) 
    {
        $this->service->bulkDelete($request->getCategoryIds());
        toastr()->success('Categories deleted successfully');
        return back();
    }

    public function import(ImportCategoryRequest $request) 
    {
        try {
            $this->service->importCategories($request->file('categories_file'));
            toastr()->success('Categories imported successfully');
            return back();
        } catch (\Throwable $e) {
            toastr()->error('Import failed');
            return back();
        }
    }
}