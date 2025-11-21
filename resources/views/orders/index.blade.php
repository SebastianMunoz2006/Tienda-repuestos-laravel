@extends('layouts.app')

@section('title', 'Mis Pedidos - AutorepuestosPro')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-history me-2"></i> Mis Pedidos</h2>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i> Seguir Comprando
                </a>
            </div>
            
            @if($orders->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Pedido #</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Método de Pago</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="fw-bold">${{ number_format($order->total, 2) }} USD</div>
                                            <small class="text-muted">${{ number_format($order->total * 4200, 0, ',', '.') }} COP</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                                {{ $order->status == 'pending' ? 'Pendiente' : 'Completado' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->payment_method == 'nequi')
                                                <i class="fas fa-mobile-alt text-primary"></i> Nequi
                                            @else
                                                <i class="fas fa-money-bill-wave text-success"></i> Efectivo
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i> Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <p class="mb-0">
                        <strong>💡 Tip:</strong> Recuerda que mantener tu vehículo con repuestos de calidad 
                        es la mejor inversión para su durabilidad y rendimiento.
                    </p>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h4>¡Aún no tienes pedidos!</h4>
                    <p class="text-muted mb-3">Descubre nuestros repuestos de calidad y realiza tu primera compra.</p>
                    <p class="text-muted mb-4">Tu vehículo merece lo mejor 🚗💨</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i> Explorar Productos
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection