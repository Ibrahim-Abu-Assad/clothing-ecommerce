<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{

    public function index()
    {
        $cart = session()->get('cart', []);

        // foreach ($cart as $key => $item) {
        //     $product = Product::find($item['product_id']);
        //     $cart[$key]['stock'] = $product ? $product->stock : 0;
        // }

        foreach ($cart as $key => &$item) { // <--- CHANGE 1: Added '&' here
            $product = Product::find($item['product_id']);
            $item['stock'] = $product ? $product->stock : 0;

            // <--- CHANGE 2: Add this line to format the item's price
            $item['price'] = number_format((float)($item['price'] ?? 0), 2, '.', '');
        }
        unset($item); // <--- IMPORTANT: Add this line after the loop

        // $total = collect($cart)->sum(fn($item) => $item['quantity'] * ($item['price'] ?? 0));

        $total = collect($cart)->sum(fn($item) => (float)($item['quantity'] ?? 0) * (float)($item['price'] ?? 0));
        // <--- CHANGE 3: Add this line to format the overall total
        $total = number_format($total, 2, '.', '');

        return Inertia::render('Cart/Index', [
            'cartItems' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()
                ->with('error', 'Sorry, the quantity requested exceeds available stock.')
                ->withInput();
        }

        $cart = session()->get('cart', []);

        $key = $validated['product_id'] . '_' . $validated['size'] . '_' . $validated['color'];

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
                'size' => $validated['size'],
                'color' => $validated['color'],
                'quantity' => $validated['quantity'],
                'price' => $product->price,
                'name' => $product->name
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
