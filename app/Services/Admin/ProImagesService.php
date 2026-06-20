<?php

namespace App\Services\Admin;

use App\Models\ProductImages;
use App\Models\Product;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProImagesService
{
    public function allImages(int $product_id): array
    {
        $product = Product::findOrFail($product_id);

        return [
            'product' => $product,
            'colors'  => Color::where('status', 1)->get(),
            'images'  => ProductImages::where('product_id', $product_id)
                ->orderBy('sort_order')
                ->get(),
        ];
    }

    public function storeImages(array $data): void
    {
        DB::transaction(function () use ($data) {

            $productId = $data['product_id'];

            $lastSortOrder = ProductImages::where('product_id', $productId)->max('sort_order') ?? 0;

            foreach ($data['images'] as $file) {

                $path = $file->store('product-images', 'public');

                ProductImages::create([
                    'product_id'  => $productId,
                    'image'       => $path,
                    'color_id'    => $data['color_id'] ?? null,
                    'is_featured' => 0,
                    'is_back'     => 0,
                    'sort_order'  => ++$lastSortOrder,
                ]);
            }
        });
    }

    public function updateImages(int $productId, array $data): void
    {
        DB::transaction(function () use ($productId, $data) {
            $imagesData = $data['images'] ?? [];
            $featuredId = $data['featured_id'] ?? null;
            $backId     = $data['back_id'] ?? null;

            // 1. Reset all featured/back flags for this product first
            ProductImages::where('product_id', $productId)->update([
                'is_featured' => 0,
                'is_back'     => 0
            ]);

            // 2. Loop through and update individual row data (color and sort)
            foreach ($imagesData as $id => $value) {
                ProductImages::where('id', $id)->update([
                    'color_id'   => $value['color_id'] ?? null,
                    'sort_order' => $value['sort_order'] ?? 0,
                ]);
            }

            // 3. Set the single featured and back image
            if ($featuredId) {
                ProductImages::where('id', $featuredId)->update(['is_featured' => 1]);
            }
            if ($backId) {
                ProductImages::where('id', $backId)->update(['is_back' => 1]);
            }
        });
    }

    public function bulkDelete(array $ids): void
    {
        $images = ProductImages::whereIn('id', $ids)->get();

        foreach ($images as $img) {
            if ($img->image && Storage::disk('public')->exists($img->image)) {
                Storage::disk('public')->delete($img->image);
            }
            $img->delete();
        }
    }
}
