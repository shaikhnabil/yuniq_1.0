<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
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
            'image' => fake()->imageUrl(),
            'price' => fake()->numberBetween(500, 1000),
            'description' => fake()->text(100),
            'slug' => fake()->slug(),
            'category_id' => fake()->numberBetween(1, 5)
        ];
    }
}
