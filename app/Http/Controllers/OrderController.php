<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\DeliveryConfirmed;
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
        // Permitir al admin/jefe ver cualquier pedido
        $isAdmin = auth()->user()->hasRole(['jefe', 'admin']);
        
        // Si no es admin, verificar que el pedido pertenece al usuario autenticado
        if (!$isAdmin && $order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderDetails.product');
        
        return view('orders.show', compact('order'));
    }

    public function confirmDelivery(Order $order)
    {
        // El usuario debe ser el dueño del pedido
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Solo permitir confirmar si el estado es 'delivered'
        if ($order->status !== 'delivered') {
            return redirect()->back()->with('error', 'No se puede confirmar entrega en el estado actual');
        }

        $order->status = 'completed';
        $order->save();

        // Notificar al jefe/admin que el cliente confirmó la entrega
        $admins = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['jefe', 'admin']);
        })->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new DeliveryConfirmed($order, auth()->user()));
        }

        return redirect()->back()->with('success', 'Entrega confirmada. Gracias por su confirmación.');
    }
}