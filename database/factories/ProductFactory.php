<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = ucwords($this->faker->words(2, true));
        $cost = $this->faker->randomFloat(2, 50, 5000);

        return [
            'name' => $name,
            'sku' => strtoupper(Str::random(4)) . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'barcode' => $this->faker->unique()->ean13(),
            'description' => $this->faker->sentence(),
            'cost_price' => $cost,
            'profit_margin' => $this->faker->randomElement([10, 15, 20, 25, 30]),
            // selling_price is recalculated from cost_price + profit_margin
            // by Product::boot() on save, so the value here is a placeholder.
            'selling_price' => $cost,
            'stock' => $this->faker->numberBetween(0, 200),
            'minimum_stock' => $this->faker->numberBetween(5, 20),
            'category_id' => Category::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'unit_id' => Unit::inRandomOrder()->value('id'),
            'image' => null,
            'status' => 1,
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
