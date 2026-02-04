<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check()) {
                return redirect('/login');
            }
            
            if (!auth()->user()->hasRole(['jefe', 'admin'])) {
                abort(403, 'No tienes permiso para acceder a esta sección.');
            }
            
            return $next($request);
        });
    }

    public function index()
    {
        // Obtener todos los pedidos EXCEPTO los del admin/jefe actual
        $orders = Order::with('orderDetails.product', 'user')
                       ->where('user_id', '!=', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:pending,processing,delivered,completed'
            ]);

            $oldStatus = $order->status;
            
            // Solo actualizar si el estado cambió
            if ($oldStatus !== $validated['status']) {
                $order->status = $validated['status'];
                $order->save();

                // Enviar notificación al usuario (cliente dueño del pedido)
                if ($order->user) {
                    $order->user->notify(new OrderStatusChanged($order, $oldStatus, $validated['status']));
                }
            }

            // Si es petición AJAX (JSON), responder con JSON
            if($request->expectsJson()) {
                $statusLabels = [
                    'pending' => 'Pendiente',
                    'processing' => 'En proceso',
                    'delivered' => 'Enviado',
                    'completed' => 'Confirmado'
                ];

                return response()->json([
                    'success' => true,
                    'message' => "Pedido #{$order->id} actualizado de '{$statusLabels[$oldStatus]}' a '{$statusLabels[$validated['status']]}'",
                    'order_id' => $order->id,
                    'status' => $validated['status']
                ]);
            }

            // Si es petición tradicional, redirigir con mensaje
            return redirect()->back()->with('success', 'Estado del pedido actualizado');
        } catch (\Exception $e) {
            if($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error al actualizar el estado');
        }
    }
}
