<?php

namespace App\Services\Admin;

use App\Models\Brand;
Use App\Models\RelationalCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    public function createBrand(array $data): Brand
    {
        return DB::transaction(function () use ($data) {
            // Mass assign fillable fields
            $brand = new Brand();
            $brand->fill($data);

            if (isset($data['image'])) {
                $brand->image = $this->uploadImage($data['image']);
            }

            $brand->save();
            $this->syncCategories($brand, $data);

            return $brand;
        });
    }

    public function updateBrand(Brand $brand, array $data): Brand
    {
        return DB::transaction(function () use ($brand, $data) {
            $brand->fill($data);

            if (isset($data['image'])) {
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }
                $brand->image = $this->uploadImage($data['image']);
            }

            $brand->save();

            // Cleanup old relations
            RelationalCategory::where('metaable_id', $brand->id)
                ->where('metaable_type', Brand::class)
                ->delete();

            $this->syncCategories($brand, $data);

            return $brand;
        });
    }

    protected function uploadImage($file): string
    {
        $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('images/brands', $name, 'public');
    }

    protected function syncCategories(Brand $brand, array $data): void
    {
        // Merge all potential category levels into one unique array
        $allCategoryIds = array_unique(array_merge(
            $data['category'] ?? [],
            $data['subcategory'] ?? [],
            $data['childcategory'] ?? [],
            $data['superchild'] ?? []
        ));

        foreach ($allCategoryIds as $id) {
            RelationalCategory::create([
                'brand_id'      => $brand->id,
                'category_id'   => $id,
                'metaable_id'   => $brand->id,
                'metaable_type' => Brand::class,
            ]);
        }
    }
}