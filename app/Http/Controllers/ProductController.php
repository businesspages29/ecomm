<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('products.product_details', compact('product'));
    }

    public function cart()
    {
        return view('products.cart');
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        try {
            // validate request
            if (! $product) {
                return redirect()->route('home')->with('error', 'Product not found!');
            }

            // available stocks
            if ($product->available_stocks <= 0) {
                return redirect()->route('home')->with('error', 'Product out of stock!');
            }

            // Add product to cart
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);

            return redirect()->route('home')->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    // Checkout
    public function checkout(Request $request)
    {
        // validate request
        $request->validate([
            'product_id.*' => 'required|integer|exists:products,id',
            'quantity.*' => 'required|integer|min:1',
            'total_amount' => 'required',
        ]);
        // insert order into orders table

        // only check stock availability after order is created
        foreach ($request->product_id as $key => $productId) {
            $product = Product::find($productId);
            if ($product->available_stocks < $request->quantity[$key]) {
                return redirect()->route('cart')->with('error', 'Product out of stock!');
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $request->total_amount,
        ]);

        foreach ($request->product_id as $key => $productId) {
            $product = Product::find($productId);
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $request->quantity[$key],
                'price' => $product->price,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }

    public function orders()
    {
        $orders = Order::with('items')->where('user_id', auth()->id())->get();

        return view('products.orders', compact('orders'));
    }
}
