@extends('layouts.app')

@section('title', 'Confirmar Pedido - AutorepuestosPro')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Confirmar Pedido</h2>
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Información del Cliente -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cart.confirm-order') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                       value="{{ auth()->user()->name ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                       value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">Teléfono *</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                                       placeholder="+57 300 123 4567" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">Método de Pago *</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Seleccionar método</option>
                                    <option value="nequi">Nequi</option>
                                    <option value="cash">Efectivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Instrucciones de pago (se muestran según el método seleccionado) -->
                        <div id="payment_instructions" class="mt-3" style="display: none;">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0" id="payment_title"></h6>
                                </div>
                                <div class="card-body">
                                    <p id="payment_description" class="card-text"></p>
                                    <div id="nequi_info" style="display: none;">
                                        <div class="alert alert-light border">
                                            <p class="mb-2"><strong>📱 Realiza el pago a nuestro Nequi:</strong></p>
                                            <p class="mb-1"><strong>Número:</strong> <span class="text-primary">300 123 4567</span></p>
                                            <p class="mb-1"><strong>Nombre:</strong> AutorepuestosPro</p>
                                            <p class="mb-0"><strong>Referencia:</strong> <span class="badge bg-primary" id="nequi_reference"></span></p>
                                        </div>
                                        <small class="text-muted">Una vez realizado el pago, guarda el comprobante.</small>
                                    </div>
                                    <div id="cash_info" style="display: none;">
                                        <div class="alert alert-light border">
                                            <p class="mb-2"><strong>💰 Pago en Efectivo:</strong></p>
                                            <p class="mb-1"><strong>Dirección:</strong> Calle 123 #45-67, Bogotá, Colombia</p>
                                            <p class="mb-1"><strong>Horario:</strong> Lunes a Viernes 8:00 AM - 6:00 PM</p>
                                            <p class="mb-0"><strong>Sábados:</strong> 9:00 AM - 2:00 PM</p>
                                        </div>
                                        <small class="text-muted">Trae tu número de pedido para facilitar el proceso.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Dirección de Envío *</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="3" placeholder="Ingresa tu dirección completa para el envío..." required></textarea>
                        </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Resumen del Pedido -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    @foreach($products as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h6 class="my-0">{{ $item['name'] }}</h6>
                            <small class="text-muted">Cantidad: {{ $item['quantity'] }}</small>
                        </div>
                        <span class="text-muted">${{ number_format($item['total'], 2) }} USD</span>
                    </div>
                    @endforeach
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }} USD</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>IVA (19%)</span>
                        <span>${{ number_format($tax, 2) }} USD</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }} USD</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold mt-2">
                        <span>Total en COP</span>
                        <span>${{ number_format($total * 4200, 0, ',', '.') }} COP</span>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mt-3">
                        <i class="fas fa-check-circle me-2"></i> Confirmar y Pagar
                    </button>
                    </form>
                    
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('payment_method');
    const paymentInstructions = document.getElementById('payment_instructions');
    const paymentTitle = document.getElementById('payment_title');
    const paymentDescription = document.getElementById('payment_description');
    const nequiInfo = document.getElementById('nequi_info');
    const cashInfo = document.getElementById('cash_info');
    const nequiReference = document.getElementById('nequi_reference');

    // Generar referencia única para Nequi
    function generateReference() {
        return Math.floor(100000 + Math.random() * 900000);
    }

    paymentMethod.addEventListener('change', function() {
        const method = this.value;
        
        if (method === 'nequi') {
            paymentInstructions.style.display = 'block';
            paymentTitle.textContent = '💳 Instrucciones para pago con Nequi';
            paymentDescription.textContent = 'Para completar tu pedido, realiza la transferencia a nuestro número de Nequi:';
            nequiInfo.style.display = 'block';
            cashInfo.style.display = 'none';
            nequiReference.textContent = generateReference();
        } 
        else if (method === 'cash') {
            paymentInstructions.style.display = 'block';
            paymentTitle.textContent = '💰 Instrucciones para pago en Efectivo';
            paymentDescription.textContent = 'Puedes acercarte a nuestra tienda física para realizar el pago:';
            nequiInfo.style.display = 'none';
            cashInfo.style.display = 'block';
        }
        else {
            paymentInstructions.style.display = 'none';
        }
    });

    // Validación básica del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const phone = document.getElementById('customer_phone').value;
        const address = document.getElementById('shipping_address').value;
        const payment = document.getElementById('payment_method').value;
        
        if (!phone || !address || !payment) {
            e.preventDefault();
            alert('Por favor completa todos los campos obligatorios.');
        }
    });
});
</script>
@endsection