<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('03#########'),
            'email' => $this->faker->unique()->safeEmail(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'opening_balance' => $this->faker->randomFloat(2, 0, 2000),
            'balance_type' => $this->faker->randomElement(['receivable', 'payable']),
            'image' => null,
            'notes' => null,
            'status' => 1,
        ];
    }
}
