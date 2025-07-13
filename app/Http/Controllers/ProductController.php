<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            // Join brands and categories tables for filtering by name
            ->when($request->brand, function ($query, $brandName) {
                $query->whereHas('brand', function ($q) use ($brandName) {
                    $q->where('name', $brandName);
                });
            })
            ->when($request->category, function ($query, $categoryName) {
                $query->whereHas('category', function ($q) use ($categoryName) {
                    $q->where('name', $categoryName);
                });
            })
            // Use whereHas for many-to-many relationships (colors, sizes)
            ->when($request->color, function ($query, $colorName) {
                $query->whereHas('colors', function ($q) use ($colorName) {
                    $q->where('name', $colorName);
                });
            })
            ->when($request->size, function ($query, $sizeName) {
                $query->whereHas('sizes', function ($q) use ($sizeName) {
                    $q->where('name', $sizeName);
                });
            })
            ->when($request->letter, fn($q) => $q->where('name', 'LIKE', $request->letter . '%'))
            ->when($request->min_price && $request->max_price, fn($q) =>
                $q->whereBetween('price', [$request->min_price, $request->max_price]))
            ->when($request->search, fn($q) =>
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%'))
            ->when($request->sort === 'az', fn($q) => $q->orderBy('name'))
            ->when($request->sort === 'za', fn($q) => $q->orderByDesc('name'))
            ->with('firstImage')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('products/Index', [
            'products' => $products,
            'filters' => $request->only([
                'brand', 'color', 'size', 'category', 'letter', 'search', 'sort', 'min_price', 'max_price'
            ]),
            'brands' => Brand::select('name')->distinct()->pluck('name'),
            'colors' => Color::select('name')->distinct()->pluck('name'),
            'sizes' => Size::select('name')->distinct()->pluck('name'),
            'categories' => Category::select('name')->distinct()->pluck('name'),
        ]);
    }

    public function show(Product $product)
    {
        // Eager load images, colors, and sizes
        $product->load('images', 'colors', 'sizes');

        // Safely get collections, defaulting to empty if null (shouldn't happen with Eloquent)
        $colors = $product->colors ?? collect();
        $sizes = $product->sizes ?? collect();

        // Ensure uniqueness of colors and sizes based on their 'id' before mapping
        $uniqueColors = $colors->unique('id'); // ADD THIS LINE
        $uniqueSizes = $sizes->unique('id');   // ADD THIS LINE

        return Inertia::render('products/Show', [
            'product' => [
                ...$product->toArray(),
                'colors' => $uniqueColors->map(fn($color) => ['id' => $color->id, 'name' => $color->name])->values()->all(),
                'sizes' => $uniqueSizes->map(fn($size) => ['id' => $size->id, 'name' => $size->name])->values()->all(),
            ],
        ]);
    }

}
