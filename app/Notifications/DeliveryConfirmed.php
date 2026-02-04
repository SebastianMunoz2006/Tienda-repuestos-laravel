<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveryConfirmed extends Notification
{
    use Queueable;

    protected $order;
    protected $customer;

    public function __construct($order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'message' => "{$this->customer->name} confirmó que recibió el pedido #{$this->order->id}",
            'total' => $this->order->total,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("✅ Entrega Confirmada - Pedido #{$this->order->id}")
                    ->greeting("¡Hola {$notifiable->name}!")
                    ->line("{$this->customer->name} ha confirmado que recibió el pedido #{$this->order->id}.")
                    ->line("Cliente: {$this->customer->email}")
                    ->line("Total: \${$this->order->total} USD")
                    ->line("Estado actual: Confirmado ✅")
                    ->action('Ver Pedido', route('admin.orders.index'))
                    ->line('¡Transacción completada exitosamente!');
    }
}
