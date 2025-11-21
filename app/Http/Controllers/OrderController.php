<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderDetails.product')
                      ->where('user_id', auth()->id())
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario autenticado
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderDetails.product');
        
        return view('orders.show', compact('order'));
    }
}