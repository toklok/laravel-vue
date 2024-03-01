<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SavedCalculationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'actual_calculation' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000),
            'inputs' => json_encode([]),
            'category' => fake()->word(),
            'description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
