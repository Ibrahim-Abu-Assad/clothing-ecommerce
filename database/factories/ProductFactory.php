<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ucfirst(fake()->unique()->words(2, true)),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 10, 300), // Price BETWEEN 10 AND 300;
            'stock' => fake()->numberBetween(0, 50),    // Random Stock
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'sizes' => ['S', 'M', 'L', 'XL'], // Random sizes
            'colors' => ['Red', 'Blue', 'Green', 'Black', 'White'], // Random colors
        ];
    }
}
