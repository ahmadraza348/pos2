<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\ProductImages;
use App\Models\RelationalCategory;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductService
{
    /* =========================
       BASIC FETCH METHODS
    ==========================*/

    public function getAll()
    {
        return Product::latest()->get();
    }

    public function getCreateData(): array
    {
        return [
            'categories' => Category::where('status', 1)
                ->whereNull('parent_id')
                ->with('subcategories')
                ->get(),

            'attributes' => Attribute::where('status', 1)
                ->with('attributevalue')
                ->get(),

            'brands' => Brand::where('status', 1)->get()
        ];
    }

    public function getEditData(string $id): array
    {
        $product = Product::findOrFail($id);

        return [
            'pro_data' => $product,
            'all_category_data' => Category::where('status', 1)
                ->whereNull('parent_id')
                ->with('subcategories.subcategories')
                ->get(),
            'selected_categories' => $product->categories->pluck('id')->toArray(),
            'attributes' => Attribute::where('status', 1)->with('attributevalue')->get(),
            'brands' => Brand::where('status', 1)->get(),
        ];
    }

    public function getTrashed()
    {
        return Product::onlyTrashed()->get();
    }

    /* =========================
       STORE / UPDATE
    ==========================*/

    public function store($request): Product
    {
        return DB::transaction(function () use ($request) {

            $data = $request->validated();

            if ($request->hasFile('video')) {
                $data['video'] = $this->uploadVideo($request->file('video'));
            }

            $product = Product::create($data);

            $this->syncCategories($product, $request);          

            return $product;
        });
    }

    public function update($request, string $id): Product
    {
        return DB::transaction(function () use ($request, $id) {

            $product = Product::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('video')) {
                if ($product->video) {
                    Storage::disk('public')->delete($product->video);
                }

                $data['video'] = $this->uploadVideo($request->file('video'));
            }

            $product->update($data);

            RelationalCategory::where('product_id', $product->id)->delete();
            $this->syncCategories($product, $request);
          
            return $product;
        });
    }

    /* =========================
       DELETE / RESTORE
    ==========================*/

    public function delete(string $id): void
    {
        Product::findOrFail($id)->delete();
    }

    public function restore(string $id): void
    {
        Product::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(string $id): void
    {
        Product::withTrashed()->findOrFail($id)->forceDelete();
    }

    public function bulkDelete(string $ids): void
    {
        $prodIds = explode(',', $ids);
        Product::whereIn('id', $prodIds)->delete();
    }

    /* =========================
       GALLERY
    ==========================*/

    public function deleteGalleryImage($imageId): array
    {
        try {
            $image = ProductImages::findOrFail($imageId);
            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete();

            return ['success' => true, 'message' => 'Deleted'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /* =========================
       ATTRIBUTE VALUES
    ==========================*/

    public function getAttributeValues($id)
    {
        return AttributeValue::where('attribute_id', $id)
            ->get(['id', 'name']);
    }

    /* =========================
       IMPORT
    ==========================*/

    public function import($request): void
    {
        $request->validate([
            'products_file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ProductsImport, $request->file('products_file'));
    }

    /* =========================
       HELPERS
    ==========================*/

    protected function uploadVideo($file): string
    {
        $videoName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        return $file->storeAs('videos/products', $videoName, 'public');
    }

    protected function syncCategories(Product $product, $request): void
    {
        $allCategories = array_merge(
            $request->category ?? [],
            $request->subcategory ?? [],
            $request->childcategory ?? [],
            $request->superchild ?? []
        );

        foreach ($allCategories as $categoryId) {
            RelationalCategory::create([
                'product_id'   => $product->id,
                'category_id'  => $categoryId,
                'metaable_id'  => $product->id,
                'metaable_type'=> Product::class,
            ]);
        }
    }

  
}
