<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    public function __construct($order, $oldStatus, $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statusLabels = [
            'pending' => 'Pendiente',
            'processing' => 'En proceso',
            'delivered' => 'Enviado',
            'completed' => 'Confirmado'
        ];

        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Tu pedido #{$this->order->id} cambió de estado: {$statusLabels[$this->oldStatus]} → {$statusLabels[$this->newStatus]}",
            'total' => $this->order->total,
        ];
    }

    public function toMail($notifiable)
    {
        $statusLabels = [
            'pending' => 'Pendiente',
            'processing' => 'En proceso',
            'delivered' => 'Enviado',
            'completed' => 'Confirmado'
        ];

        return (new MailMessage)
                    ->subject("Cambio de estado en tu pedido #{$this->order->id}")
                    ->greeting("¡Hola {$notifiable->name}!")
                    ->line("Tu pedido #{$this->order->id} ha cambiado de estado.")
                    ->line("Anterior: {$statusLabels[$this->oldStatus]}")
                    ->line("Nuevo: {$statusLabels[$this->newStatus]}")
                    ->line("Total: \${$this->order->total} USD")
                    ->action('Ver Pedido', route('orders.show', $this->order->id))
                    ->line('¡Gracias por confiar en AutorepuestosPro!');
    }
}
