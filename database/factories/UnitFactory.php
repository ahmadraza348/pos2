<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    // Kept short and fixed on purpose: this is a lookup table of real-world
    // measurement units, not something that should contain random words.
    // DemoDataSeeder creates at most one row per entry below.
    private static array $units = [
        'piece', 'kilogram', 'gram', 'liter', 'milliliter',
        'box', 'pack', 'dozen', 'meter', 'carton',
    ];

    public function definition(): array
    {
        static $index = 0;
        $name = self::$units[$index % count(self::$units)];
        $index++;

        return [
            'name' => $name,
        ];
    }
}
