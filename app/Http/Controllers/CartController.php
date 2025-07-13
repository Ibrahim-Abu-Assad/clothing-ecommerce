<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $key => &$item) {
            $product = Product::find($item['product_id']);
            $item['stock'] = $product ? $product->stock : 0;

            $item['price'] = number_format((float)($item['price'] ?? 0), 2, '.', '');
        }
        unset($item);

        $total = collect($cart)->sum(fn($item) => (float)($item['quantity'] ?? 0) * (float)($item['price'] ?? 0));
        $total = number_format($total, 2, '.', '');

        return Inertia::render('Cart/Index', [
            'cartItems' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'color_id' => 'required|integer|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $size = Size::findOrFail($validated['size_id']);
        $color = Color::findOrFail($validated['color_id']);

        $productHasColor = $product->colors()->where('color_id', $color->id)->exists();
        $productHasSize = $product->sizes()->where('size_id', $size->id)->exists();

        if (!$productHasColor || !$productHasSize) {
            return redirect()->back()
                ->with('error', 'Selected color or size is not available for this product.')
                ->withInput();
        }

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()
                ->with('error', 'Sorry, the quantity requested exceeds available stock.')
                ->withInput();
        }

        $cart = session()->get('cart', []);

        $key = $validated['product_id'] . '_' . $validated['size_id'] . '_' . $validated['color_id'];

        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $validated['quantity'];

            if ($newQuantity > $product->stock) {
                return redirect()->back()
                    ->with('error', 'Sorry, total quantity in cart exceeds available stock.')
                    ->withInput();
            }

            $cart[$key]['quantity'] = $newQuantity;
        } else {
            $cart[$key] = [
                'product_id' => $validated['product_id'],
                'size_id' => $validated['size_id'],
                'color_id' => $validated['color_id'],
                'size_name' => $size->name,
                'color_name' => $color->name,
                'quantity' => $validated['quantity'],
                'price' => $product->price,
                'name' => $product->name,
                'image_path' => $product->firstImage ? $product->firstImage->image_path : 'https://via.placeholder.com/100x100?text=No+Image',
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $key)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$key])) {
            return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
        }

        $productId = $cart[$key]['product_id'];
        $product = Product::findOrFail($productId);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->route('cart.index')
                ->with('error', 'Sorry, quantity exceeds available stock.');
        }

        $cart[$key]['quantity'] = $validated['quantity'];

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }

        return redirect()->back();
    }
}
