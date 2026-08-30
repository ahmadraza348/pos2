<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()) . ' ' . $this->faker->numberBetween(1, 999),
            'image' => null,
            'description' => $this->faker->sentence(),
            'status' => 1,
        ];
    }
}
