<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlaced extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nuevo pedido recibido')
                    ->greeting('Hola ' . ($notifiable->name ?? ''))
                    ->line('Se ha realizado un nuevo pedido (#' . $this->order->id . ').')
                    ->action('Ver Pedidos', url('/admin/orders'))
                    ->line('Revisa el panel para gestionar el pedido.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Nuevo pedido realizado por ' . ($this->order->customer_name ?? 'Cliente'),
            'total' => $this->order->total,
        ];
    }
}
