<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                return redirect()->route('cart.index')->with('error', "Product not found.");
            }

            if ($item['quantity'] > $product->stock) {
                return redirect()->route('cart.index')->with('error', "Quantity for product {$product->name} exceeds stock.");
            }
        }

        DB::beginTransaction();

        try {
            $totalPrice = collect($cart)->sum(function ($item) {
                return $item['quantity'] * ($item['price'] ?? 0);
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => null,
            ]);

            foreach ($cart as $key => $item) {
                $product = Product::find($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('cart.index')->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    public function index()
    {
        $user = auth()->user();

        $orders = $user->orders()
            ->withCount('orderItems')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }
}
