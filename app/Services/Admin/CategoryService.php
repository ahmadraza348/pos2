<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Imports\CategoriesImport;
use App\Models\RelationalCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CategoryService
{
    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('images/categories', 'public');
            }

            return Category::create($data);
        });
    }

    public function update(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data) {
            if (isset($data['image'])) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = $data['image']->store('images/categories', 'public');
            }

            $category->update($data);
            return $category;
        });
    }

    public function delete(Category $category): void
    {
        DB::transaction(function () use ($category) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            RelationalCategory::where('category_id', $category->id)->delete();
            $category->delete();
        });
    }

    public function bulkDelete(array $categoryIds): void
    {
        DB::transaction(function () use ($categoryIds) {
            $categories = Category::whereIn('id', $categoryIds)->get();
            
            foreach ($categories as $category) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
            }

            RelationalCategory::whereIn('category_id', $categoryIds)->delete();
            Category::whereIn('id', $categoryIds)->delete();
        });
    }

    public function importCategories($file): void
    {
        DB::transaction(function () use ($file) {
            Excel::import(new CategoriesImport, $file);
        });
    }
}