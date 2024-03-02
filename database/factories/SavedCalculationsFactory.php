<?php

namespace Database\Factories;

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
        $number1 = fake()->numberBetween($min = 1, $max = 100);
        $number2 = fake()->numberBetween($min = 1, $max = 100);
        $operators = ['+', '-', '*', '/'];
        $operator = fake()->randomElement($operators);

        return [
            'name' => fake()->name(),
            'actual_calculation' => fake()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 1000),
            'inputs' => "{$number1} {$operator} {$number2}",
            'category' => fake()->word(),
            'description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
