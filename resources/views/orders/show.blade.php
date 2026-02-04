@extends('layouts.app')

@section('title', 'Detalles del Pedido #' . $order->id . ' - AutorepuestosPro')

@section('content')
<div class="container py-4">
    <!-- Aviso de Modo Administrador -->
    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('jefe')))
    <div class="d-flex justify-content-center mb-4">
        <span class="badge fs-6 p-3 admin-mode-badge">
            <i class="fas fa-user-shield me-2"></i> Modo Administrador Activado
        </span>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-file-invoice me-2"></i> Detalles del Pedido #{{ $order->id }}</h2>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Historial
                </a>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Productos del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('images/' . ($detail->product->image ?: 'default-product.jpg')) }}" 
                                                         alt="{{ $detail->product->name }}" 
                                                         width="50" 
                                                         height="50" 
                                                         class="rounded me-3" 
                                                         style="object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $detail->product->name }}</h6>
                                                        <small class="text-muted">{{ $detail->product->brand }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($detail->price, 2) }} USD</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>${{ number_format($detail->subtotal, 2) }} USD</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Resumen del Pedido</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Información del Cliente:</strong>
                                <p class="mb-1">{{ $order->customer_name }}</p>
                                <p class="mb-1">{{ $order->customer_email }}</p>
                                <p class="mb-0">{{ $order->customer_phone }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Dirección de Envío:</strong>
                                <p class="mb-0">{{ $order->shipping_address }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>Método de Pago:</strong>
                                <p class="mb-0">
                                    @if($order->payment_method == 'nequi')
                                        <i class="fas fa-mobile-alt text-primary"></i> Nequi
                                    @else
                                        <i class="fas fa-money-bill-wave text-success"></i> Efectivo
                                    @endif
                                </p>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }} USD</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>IVA (19%):</span>
                                <span>${{ number_format($order->tax, 2) }} USD</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span class="text-success">${{ number_format($order->total, 2) }} USD</span>
                            </div>

                            <div class="d-flex justify-content-between fw-bold mt-2">
                                <span>Total en COP:</span>
                                <span>${{ number_format($order->total * 4200, 0, ',', '.') }} COP</span>
                            </div>

                            <div class="mt-4">
                                <div class="alert alert-light border">
                                    <p class="mb-0 small">
                                        <strong>Estado del Pedido:</strong>
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning">⏳ Pendiente</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info">🔄 En proceso</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge bg-primary">📦 Enviado</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success">✅ Confirmado</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </p>
                                    <p class="mb-0 small mt-2">
                                        <strong>Fecha del pedido:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                {{-- Mostrar estado del envío y acciones --}}
                                @if(auth()->check() && auth()->id() == $order->user_id)
                                    @if($order->status == 'delivered')
                                    <div class="alert alert-info mt-3 border-start border-4 border-info">
                                        <i class="fas fa-truck me-2"></i>
                                        <strong>¡Tu pedido ha llegado!</strong>
                                        <p class="mt-2 mb-0">Por favor confirma que recibiste tu pedido.</p>
                                    </div>
                                    <form action="{{ route('orders.confirm-delivery', $order->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg w-100">
                                            <i class="fas fa-check-circle me-2"></i>Confirmar que recibí el pedido
                                        </button>
                                    </form>
                                    @elseif($order->status == 'completed')
                                    <div class="alert alert-success mt-3 border-start border-4 border-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>¡Pedido Confirmado!</strong>
                                        <p class="mt-2 mb-0">Gracias por verificar tu compra. Si tienes algún problema, contáctanos.</p>
                                    </div>
                                    @elseif($order->status == 'pending')
                                    <div class="alert alert-warning mt-3 border-start border-4 border-warning">
                                        <i class="fas fa-hourglass-start me-2"></i>
                                        <strong>Pedido Pendiente</strong>
                                        <p class="mt-2 mb-0">Estamos preparando tu pedido. Te notificaremos cuando esté en camino.</p>
                                    </div>
                                    @elseif($order->status == 'processing')
                                    <div class="alert alert-info mt-3 border-start border-4 border-info">
                                        <i class="fas fa-cogs me-2"></i>
                                        <strong>En Proceso</strong>
                                        <p class="mt-2 mb-0">Tu pedido se está preparando. Pronto estará listo para enviar.</p>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-3">
                        <p class="mb-0 text-center">
                            <strong>¡Gracias por confiar en AutorepuestosPro!</strong><br>
                            Tu vehículo está en buenas manos 🛠️
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection