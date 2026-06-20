<?php

namespace App\Services\Admin;

use App\Models\Attribute;
use App\Models\RelationalCategory;
use Illuminate\Support\Facades\DB;

class AttributeService
{
    public function storeAttribute(array $data): Attribute
    {
        // Return the result of the transaction
        return DB::transaction(function () use ($data) {
            $attribute = new Attribute();
            $attribute->fill($data);
            $attribute->save();
            $this->syncCategories($attribute, $data);
            return $attribute;
        });
    }

    public function updateAttribute(Attribute $attribute, array $data): Attribute
    {
       return DB::transaction(
            function () use ($attribute, $data) {
                $attribute->update($data);
                $attribute->save();
                RelationalCategory::where('metaable_id', $attribute->id)
                    ->where('metaable_type', Attribute::class)
                    ->delete();

                $this->syncCategories($attribute, $data);

                return $attribute;
            }
        );
    }

    public function destroyAttribute(Attribute $attribute): void
    {
        DB::transaction(
            function () use ($attribute) {
                RelationalCategory::where('metaable_id', $attribute->id)
                    ->where('metaable_type', Attribute::class)
                    ->delete();

                $attribute->delete();
            }
        );
    }

    protected function syncCategories(Attribute $attribute, array $data): void
    {
        $categories = $data['category'] ?? [];
        $subcategories = $data['subcategory'] ?? [];
        $childcategories = $data['childcategory'] ?? [];
        $superchildcategory = $data['superchild'] ?? [];
        $allCategories = array_merge($categories, $subcategories, $childcategories, $superchildcategory);

        foreach ($allCategories as $categoryId) {
            RelationalCategory::create([
                'attribute_id' => $attribute->id,
                'category_id' => $categoryId,
                'metaable_id' => $attribute->id,
                'metaable_type' => Attribute::class,
            ]);
        }
    }
}
