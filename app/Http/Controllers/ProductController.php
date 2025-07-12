<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::query()
            ->when($request->brand, fn($q) => $q->where('brand', $request->brand))
            ->when($request->color, fn($q) => $q->where('color', $request->color))
            ->when($request->size, fn($q) => $q->where('size', $request->size))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
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
                'brand',
                'color',
                'size',
                'category',
                'letter',
                'search',
                'sort',
                'min_price',
                'max_price'
            ]),
        ]);
    }

    /*

        Maybe I will edit this :

        'colors' => $product->colors->pluck('name'),
        'sizes' => $product->sizes->pluck('name'),

    */

    public function show(Product $product)
    {
        $product->load('images');

        return Inertia::render('products/Show', [
            'product' => [
                ...$product->toArray(),
                'colors' => $product->colors,
                'sizes' => $product->sizes,
            ],
        ]);
    }
}
