@extends('layouts.app')

@section('title', 'Pedido Confirmado - AutorepuestosPro')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('order_id'))
            <div class="alert alert-info">
                <strong>Número de Pedido:</strong> #{{ session('order_id') }}
            </div>
            @endif

            <div class="card border-0 shadow-lg">
                <div class="card-body py-5">
                    <div class="text-success mb-4">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    <h2 class="card-title mb-3 text-success">¡Pedido Confirmado Exitosamente!</h2>
                    
                    <div class="mb-4">
                        <p class="card-text fs-5">
                            ¡<strong class="text-success">Éxito total</strong>! Tu pedido en <strong>AutorepuestosPro</strong> ha sido confirmado. 
                        </p>
                        <p class="text-muted mb-3">
                            🚗 <strong>Tu vehículo está más cerca de estar en perfecto estado</strong> 🛠️
                        </p>
                        <div class="alert alert-light border">
                            <p class="mb-2"><strong>💡 ¿Sabías que?</strong></p>
                            <p class="mb-0 small">Mantener tu vehículo con repuestos originales puede aumentar su vida útil hasta en un 40%.</p>
                        </div>
                    </div>

                    <p class="text-muted mb-4">
                        📋 <strong>Puedes revisar los detalles de tu pedido en tu</strong> 
                        <a href="{{ route('orders.index') }}" class="text-decoration-none fw-bold">historial de compras</a>.
                        <br>Si tienes alguna pregunta, no dudes en contactarnos.
                    </p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">✅ Orden Procesada</h6>
                                    <p class="small text-muted mb-0">Tu pedido #{{ session('order_id') ?? 'está' }} en proceso</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">🚚 Tiempo de Entrega</h6>
                                    <p class="small text-muted mb-0">3-5 días hábiles</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-3">
                        <p class="mb-0">
                            <strong>🎉 ¡Buen trabajo!</strong> Has tomado la mejor decisión para el cuidado de tu vehículo.
                        </p>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-info btn-lg me-md-2">
                            <i class="fas fa-history me-2"></i> Ver Mis Pedidos
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg me-md-2">
                            <i class="fas fa-shopping-bag me-2"></i> Seguir Comprando
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i> Volver al Inicio
                        </a>
                    </div>

                    <div class="mt-4">
                        <small class="text-muted">
                            ¿Necesitas ayuda? <a href="{{ route('home') }}#contact" class="text-decoration-none">Contáctanos</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Limpiar el carrito después de una compra exitosa
    setTimeout(() => {
        // Opcional: Aquí podrías hacer una llamada AJAX para limpiar el carrito
        // fetch('/cart/clear', { method: 'DELETE', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        
        // Actualizar el contador del carrito en el navbar
        const cartCount = document.querySelector('.cart-count');
        if (cartCount) {
            cartCount.textContent = '0';
        }
    }, 1000);
});
</script>
@endsection