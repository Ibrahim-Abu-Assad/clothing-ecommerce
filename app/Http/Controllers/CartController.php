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
        // dd($cart);
        $total = collect($cart)->sum(fn($item) => $item['quantity'] * ($item['price'] ?? 0));

        return Inertia::render('Cart/Index', [
            'cartItems' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $validated = $request->validate([
            'product_id' => 'required|integer',
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        // dd($product);

        $cart = session()->get('cart', []);

        $key = $validated['product_id'] . '_' . $validated['size'] . '_' . $validated['color'];

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $validated['quantity'];
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

        // dd($cart);

        session(['cart' => $cart]);

        // dd(session()->get('cart'));

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return redirect()->back();
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
