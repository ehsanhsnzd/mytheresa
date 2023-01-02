<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' =>  fake()->randomElement(['category', 'sku']),
            'key' => fake()->randomElement(['boots', 'sandals']),
            'value' => fake()->randomDigit(),
        ];
    }
}
