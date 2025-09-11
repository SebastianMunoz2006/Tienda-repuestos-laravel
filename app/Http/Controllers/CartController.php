<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
                        'image' => $product->image,
                        'brand' => $product->brand,
                        'max_stock' => $product->stock
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

        // Validar stock disponible
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $newQuantity = $cart[$product_id] + $quantity;
            // Validar que no exceda el stock al sumar
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'No hay suficiente stock disponible');
            }
            $cart[$product_id] = $newQuantity;
        } else {
            $cart[$product_id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function remove($product_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        // Recalcular el total
        $total = 0;
        foreach ($cart as $id => $qty) {
            $productItem = Product::find($id);
            if ($productItem) {
                $total += $productItem->price * $qty;
            }
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'total' => number_format($total, 2)
            ]);
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
                $product = Product::find($product_id);
                if ($product && $quantity > $product->stock) {
                    return redirect()->back()->with('error', "No hay suficiente stock para {$product->name}");
                }
                $cart[$product_id] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
    }

    // MÉTODO updateQuantity MEJORADO - CORREGIDO
    public function updateQuantity(Request $request, $product_id)
    {
        // Log para depuración
        Log::info('updateQuantity llamado', [
            'product_id' => $product_id,
            'quantity' => $request->input('quantity'),
            'is_ajax' => $request->ajax(),
            'all_data' => $request->all()
        ]);

        $cart = session()->get('cart', []);
        $newQuantity = (int) $request->input('quantity');
        
        // Validar que la cantidad sea válida
        if ($newQuantity <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cantidad inválida'
                ], 400);
            }
            return redirect()->back()->with('error', 'Cantidad inválida');
        }

        // Validar stock máximo
        $product = Product::find($product_id);
        if (!$product) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }
            return redirect()->back()->with('error', 'Producto no encontrado');
        }

        if ($newQuantity > $product->stock) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay suficiente stock disponible. Máximo: ' . $product->stock
                ], 400);
            }
            return redirect()->back()->with('error', 'No hay suficiente stock disponible. Máximo: ' . $product->stock);
        }

        // Verificar si el producto existe en el carrito
        if (!isset($cart[$product_id])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado en el carrito'
                ], 404);
            }
            return redirect()->back()->with('error', 'Producto no encontrado en el carrito');
        }

        // Actualizar la cantidad en el carrito
        $cart[$product_id] = $newQuantity;
        session()->put('cart', $cart);
        
        // Recalcular totales para la respuesta JSON - VERSIÓN MEJORADA
        $total = 0;
        $items_count = 0;

        // Calcular el subtotal del producto actual directamente
        $subtotal = $product->price * $newQuantity;

        foreach ($cart as $id => $qty) {
            $productItem = Product::find($id);
            if ($productItem) {
                $itemTotal = $productItem->price * $qty;
                $total += $itemTotal;
                $items_count += $qty;
            }
        }
        
        // Para solicitudes AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($total, 2),
                'items_count' => $items_count,
                'product_id' => $product_id,
                'product_price' => $product->price,
                'new_quantity' => $newQuantity
            ]);
        }

        // Para solicitudes normales (no AJAX) - REDIRECCIÓN
        return redirect()->route('cart.index')->with('success', 'Cantidad actualizada');
    }

    public function clear()
    {
        session()->forget('cart');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Carrito vaciado correctamente');
    }
}