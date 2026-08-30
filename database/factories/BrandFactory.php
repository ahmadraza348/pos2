<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        // NOTE: Brand::$fillable also lists 'slug' and 'website', but the
        // brands migration never actually created those columns - only
        // name, image, description, status exist on the table. Setting
        // them here would throw "Unknown column" on insert.
        return [
            'name' => ucfirst($this->faker->unique()->company()),
            'image' => null,
            'description' => $this->faker->sentence(),
            'status' => 1,
        ];
    }
}
