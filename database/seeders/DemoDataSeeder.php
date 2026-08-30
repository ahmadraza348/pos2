<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Repopulates the data that was deleted: categories, brands, units,
     * suppliers, customers and products. Safe to re-run - it only adds
     * rows when the table is empty, so it won't duplicate real data you've
     * since entered by hand.
     */
    public function run(): void
    {
        if (Category::count() === 0) {
            Category::factory()->count(8)->create();
        }

        if (Brand::count() === 0) {
            Brand::factory()->count(6)->create();
        }

        if (Unit::count() === 0) {
            Unit::factory()->count(10)->create();
        }

        if (Supplier::count() === 0) {
            Supplier::factory()->count(5)->create();
        }

        if (Customer::count() === 0) {
            Customer::factory()->count(15)->create();
        }

        if (Product::count() === 0) {
            Product::factory()->count(40)->create();
        }
    }
}
