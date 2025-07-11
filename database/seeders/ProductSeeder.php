<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Product::factory()
        ->count(20)
        ->create()
        ->each(function ($product) {
            // Add 3 images to each product
            ProductImage::factory()->count(3)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
