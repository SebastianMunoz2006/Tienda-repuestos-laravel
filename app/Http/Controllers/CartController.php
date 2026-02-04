<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Notifications\OrderPlaced;
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
            $subtotalCOP = $subtotal * 4200;
            $totalCOP = $total * 4200;
            return response()->json([
                'success' => true,
                'subtotal' => round($subtotal, 2),
                'total' => round($total, 2),
                'subtotal_cop' => round($subtotalCOP),
                'total_cop' => round($totalCOP),
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

    // ========== MÉTODOS DE CHECKOUT (AGREGAR AL FINAL) ==========

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }
        
        $products = [];
        $subtotal = 0;

        foreach ($cart as $product_id => $quantity) {
            $product = Product::find($product_id);
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $subtotal += $itemTotal;

                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'image' => $product->image,
                    'brand' => $product->brand
                ];
            }
        }

        $tax = $subtotal * 0.19; // 19% de IVA
        $total = $subtotal + $tax;

        return view('cart.checkout', compact('products', 'subtotal', 'tax', 'total'));
    }

    public function confirmOrder(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string',
        ]);

        // Obtener el carrito
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        // Calcular totales
        $subtotal = 0;
        $products = [];

        foreach ($cart as $product_id => $quantity) {
            $product = Product::find($product_id);
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $subtotal += $itemTotal;

                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $itemTotal
                ];
            }
        }

        $tax = $subtotal * 0.19;
        $total = $subtotal + $tax;

        // Crear el pedido en la base de datos
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending'
            ]);

            // Crear los detalles del pedido
            foreach ($products as $item) {
                OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['quantity'],
                'subtotal' => $item['subtotal']
            ]);

                // Actualizar el stock del producto
                $item['product']->decrement('stock', $item['quantity']);
            }

            // Limpiar el carrito después de la compra
            session()->forget('cart');

            // Notificar a los usuarios con rol 'jefe' (si existen)
            try {
                $jefes = User::role('jefe')->get();
                foreach ($jefes as $jefe) {
                    $jefe->notify(new OrderPlaced($order));
                }
            } catch (\Exception $e) {
                // No bloquear el flujo si la notificación falla
                Log::error('Error notificando a jefes: ' . $e->getMessage());
            }

            return redirect()->route('cart.success')->with([
                'success' => 'Pedido confirmado exitosamente',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('cart.success');
    }
}