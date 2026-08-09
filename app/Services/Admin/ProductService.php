<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductService
{
    public function getAll()
    {
        return Product::with(['category', 'brand', 'unit'])->latest()->get();
    }

    public function getCreateData(): array
    {
        return [
            'categories' => Category::where('status', 1)->get(),
            'brands'     => Brand::where('status', 1)->get(),
            'units'      => Unit::all(),
        ];
    }

    public function getEditData(string $id): array
    {
        return [
            'pro_data'   => Product::findOrFail($id),
            'categories' => Category::where('status', 1)->get(),
            'brands'     => Brand::where('status', 1)->get(),
            'units'      => Unit::all(),
        ];
    }

    public function getTrashed()
    {
        return Product::onlyTrashed()->get();
    }

    public function store($request): Product
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage($request->file('image'));
            }

            // selling_price is intentionally NOT set here.
            // Product::boot() calculates it from cost_price + profit_margin
            // on every save, so there is exactly one place this math happens.
            return Product::create($data);
        });
    }

    public function update($request, string $id): Product
    {
        return DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $this->uploadImage($request->file('image'));
            }

            $product->update($data);

            return $product;
        });
    }

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
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();
    }

    public function bulkDelete(string $ids): void
    {
        Product::whereIn('id', explode(',', $ids))->delete();
    }

    public function import($request): void
    {
        $request->validate(['products_file' => 'required|mimes:xlsx,csv']);
        Excel::import(new ProductsImport, $request->file('products_file'));
    }

    protected function uploadImage($file): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('images/products', $imageName, 'public');
    }
}