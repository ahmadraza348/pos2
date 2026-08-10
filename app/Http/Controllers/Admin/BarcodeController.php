<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class BarcodeController extends Controller
{
    public function index()
    {
        return view('backend.inventory.product.barcode-print', [
            'products'   => Product::with('category')
                ->active()
                ->orderBy('name')
                ->get(['id', 'name', 'sku', 'barcode', 'selling_price', 'category_id', 'image']),
            'categories' => Category::where('status', 1)->orderBy('name')->get(),
        ]);
    }
}