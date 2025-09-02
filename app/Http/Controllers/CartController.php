<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            foreach ($cart as $product_id => $quantity) {
                $product = Product::find($product_id);
                if ($product) {
                    $itemTotal = $product->price * $quantity;
                    $total += $itemTotal;

                    $products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'total' => $itemTotal,
                        'image' => $product->image
                    ];
                }
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id] += $quantity;
        } else {
            $cart[$product_id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito');
    }

    public function remove($product_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $product_id => $quantity) {
            if ($quantity <= 0) {
                unset($cart[$product_id]);
            } else {
                $cart[$product_id] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
    }
}