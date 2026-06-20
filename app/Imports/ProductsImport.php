<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Validate foreign key existence
        $brand = Brand::find($row['brand_id']);
        if (!$brand) {
            throw new \Exception("Brand with ID {$row['brand_id']} does not exist.");
        }

        // Handle slug auto-generation
        $slug = $row['slug'] ?? Str::slug($row['name'], '-');

        // Handle null or default values
        $isFeatured = isset($row['is_featured']) ? (int)$row['is_featured'] : 0;
        $status = isset($row['status']) ? (int)$row['status'] : 1;

        // Create or update product
        return new Product([
            'brand_id'           => $row['brand_id'],
            'name'               => $row['name'],
            'slug'               => $slug,
            'sku'                => $row['sku'] ?? null,
            'status'             => $status,
            'sale_price'         => $row['sale_price'],
            'previous_price'     => $row['previous_price'] ?? null,
            'purchase_price'     => $row['purchase_price'],
            'barcode'            => $row['barcode'] ?? null,
            'stock'              => $row['stock'],
            'tags'               => $row['tags'] ?? null,
            'label'              => $row['label'] ?? null,
            'is_featured'        => $isFeatured,
            'short_description'  => $row['short_description'] ?? null,
            'long_description'   => $row['long_description'] ?? null,
            'featured_image'     => $row['featured_image'] ?? null,
            'back_image'         => $row['back_image'] ?? null,
            'video'              => $row['video'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'brand_id'       => 'required|exists:brands,id',
            'name'           => 'required|string|max:255',
            'sale_price'     => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'stock'          => 'required|integer',
            'status'         => 'nullable|integer|in:0,1',
            'is_featured'    => 'nullable|integer|in:0,1',
        ];
    }
}
