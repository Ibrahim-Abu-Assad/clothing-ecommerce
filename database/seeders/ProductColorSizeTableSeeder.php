<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class ProductColorSizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products, colors, and sizes
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Check if you have any products, colors, or sizes
        if ($products->isEmpty() || $colors->isEmpty() || $sizes->isEmpty()) {
            $this->command->info('No products, colors, or sizes found. Please seed them first.');
            return;
        }

        // Attach random colors AND sizes to each product in combination
        foreach ($products as $product) {
            // Select a random subset of colors and sizes for each product
            $randomColors = $colors->random(rand(1, min(3, $colors->count())));
            $randomSizes = $sizes->random(rand(1, min(3, $sizes->count())));

            // Create combinations of selected colors and sizes for this product
            foreach ($randomColors as $color) {
                foreach ($randomSizes as $size) {
                    // Attach the color and also pass the size_id as pivot data
                    $product->colors()->attach($color->id, ['size_id' => $size->id]);
                }
            }
        }

        $this->command->info('Product colors and sizes attached successfully!');
    }
}
