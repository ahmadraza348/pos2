<?php

namespace App\Services\Admin;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BrandService
{
    public function create(array $data): Brand
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('images/brands', 'public');
            }

            return Brand::create($data);
        });
    }

    public function update(Brand $brand, array $data): Brand
    {
        return DB::transaction(function () use ($brand, $data) {
            if (isset($data['image'])) {
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }
                $data['image'] = $data['image']->store('images/brands', 'public');
            }

            $brand->update($data);
            return $brand;
        });
    }

    public function delete(Brand $brand): void
    {
        DB::transaction(function () use ($brand) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
              $brand->delete();
        });
    }

   
}