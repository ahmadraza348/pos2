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
    /* =========================
       BASIC FETCH METHODS
    ==========================*/

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
        $product = Product::findOrFail($id);

        return [
            'pro_data'   => $product,
            'categories' => Category::where('status', 1)->get(),
            'brands'     => Brand::where('status', 1)->get(),
            'units'      => Unit::all(),
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

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage($request->file('image'));
            }

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
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->forceDelete();
    }

    public function bulkDelete(string $ids): void
    {
        $prodIds = explode(',', $ids);
        Product::whereIn('id', $prodIds)->delete();
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

    protected function uploadImage($file): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('images/products', $imageName, 'public');
    }
}