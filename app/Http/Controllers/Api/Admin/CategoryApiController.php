<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Services\Admin\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Api\Admin\{
    StoreCategoryRequest,
    UpdateCategoryRequest,
    ImportCategoryRequest,
    BulkDeleteCategoryRequest
};

class CategoryApiController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Category::with('parent')->ordered()->get()
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(['data' => $category]);
    }

    public function store(StoreCategoryRequest $request, CategoryService $service): JsonResponse
    {
        $category = $service->create($request->validated());

        return response()->json([
            'message' => 'Category created',
            'data' => $category
        ], 201);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category,
        CategoryService $service
    ): JsonResponse {
        $category = $service->update($category, $request->validated());

        return response()->json([
            'message' => 'Category updated',
            'data' => $category
        ]);
    }

    public function destroy(Category $category, CategoryService $service): JsonResponse
    {
        $service->delete($category);

        return response()->json([
            'message' => 'Category deleted'
        ]);
    }

    public function bulkDelete(
        BulkDeleteCategoryRequest $request,
        CategoryService $service
    ): JsonResponse {
        $service->bulkDelete($request->getCategoryIds());

        return response()->json([
            'message' => 'Categories deleted'
        ]);
    }

    public function import(
        ImportCategoryRequest $request,
        CategoryService $service
    ): JsonResponse {
        $service->importCategories($request->file('categories_file'));

        return response()->json([
            'message' => 'Categories imported'
        ], 201);
    }
}
