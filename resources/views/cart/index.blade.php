@extends('layouts.app')

@section('title', 'Carrito de Compras - ' . config('app.name'))

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Carrito de Compras</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(!empty($products))
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        @foreach($products as $item)
                        <tr class="cart-item" data-id="{{ $item['id'] }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/' . ($item['image'] ?: 'default-product.jpg')) }}" 
                                         alt="{{ $item['name'] }}" 
                                         width="60" 
                                         height="60" 
                                         class="rounded me-3" 
                                         style="object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted">Marca: {{ $item['brand'] ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="price-container">
                                    <span class="price-usd fw-bold" data-price="{{ $item['price'] }}">${{ number_format($item['price'], 2) }} USD</span>
                                    <br>
                                    <small class="price-cop">${{ number_format($item['price'] * 4200, 0, ',', '.') }} COP</small>
                                </div>
                            </td>
                            <td class="align-middle">
    <div class="input-group" style="max-width: 130px;">
        <button class="btn decrease-quantity quantity-btn" type="button" data-id="{{ $item['id'] }}">
            <i class="fas fa-minus"></i>
        </button>
        <input type="number" 
               class="form-control quantity-input text-center" 
               value="{{ $item['quantity'] }}" 
               min="1" 
               max="{{ $item['max_stock'] ?? 100 }}"
               data-id="{{ $item['id'] }}"
               data-price="{{ $item['price'] }}"
               data-stock="{{ $item['max_stock'] ?? 100 }}">
        <button class="btn increase-quantity quantity-btn" type="button" data-id="{{ $item['id'] }}">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    @if(isset($item['max_stock']))
    <small class="text-muted d-block mt-1">Stock: {{ $item['max_stock'] }}</small>
    @endif
</td>
                            <td class="align-middle">
                                <div class="price-container">
                                    <span class="subtotal fw-bold price-usd" data-id="{{ $item['id'] }}">${{ number_format($item['total'], 2) }} USD</span>
                                    <br>
                                    <small class="price-cop">${{ number_format($item['total'] * 4200, 0, ',', '.') }} COP</small>
                                </div>
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger remove-item-ajax" data-id="{{ $item['id'] }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Seguir Comprando
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline ms-2" id="clear-cart-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-trash me-2"></i> Vaciar Carrito
                        </button>
                    </form>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Resumen de Compra</h5>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <div class="text-end">
                                    <span class="fw-bold price-usd" id="cart-subtotal">${{ number_format($total, 2) }} USD</span>
                                    <br>
                                    <small class="price-cop">${{ number_format($total * 4200, 0, ',', '.') }} COP</small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Envío:</span>
                                <div class="text-end">
                                    <span class="fw-bold price-usd" id="shipping-cost">$0.00 USD</span>
                                    <br>
                                    <small class="price-cop">$0 COP</small>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total:</strong>
                                <div class="text-end">
                                    <strong class="text-success price-usd" id="cart-total">${{ number_format($total, 2) }} USD</strong>
                                    <br>
                                    <small class="price-cop">${{ number_format($total * 4200, 0, ',', '.') }} COP</small>
                                </div>
                            </div>
                            
                            @auth
                                <!-- BOTÓN MODIFICADO: Ahora redirige al checkout -->
                                <a href="{{ route('cart.checkout') }}" class="btn btn-success w-100">
                                    <i class="fas fa-credit-card me-2"></i> Proceder al Pago
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-warning w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión para Comprar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
        <h3>Tu carrito está vacío</h3>
        <p>Agrega algunos productos para continuar.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="fas fa-shopping-bag me-2"></i> Ver Productos
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
// Variables globales para el control de notificaciones
let notificationCount = 0;
const notificationPositions = [
    { top: '20px', right: '20px' },
    { top: '20px', right: '340px' },
    { top: '110px', right: '20px' }
];

// Función para mostrar notificaciones - ESTILO UNIFICADO
function showNotification(message, type = 'success') {
    // Eliminar notificaciones anteriores
    const existingNotifications = document.querySelectorAll('.temp-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Obtener posición para esta notificación
    const position = notificationPositions[notificationCount % notificationPositions.length];
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show temp-notification`;
    notification.style.cssText = `top: ${position.top}; right: ${position.right}; z-index: 1060; min-width: 300px; position: fixed;`;
    
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Incrementar contador
    notificationCount++;
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            // Simular click en el botón de cerrar para usar la animación de Bootstrap
            const closeButton = notification.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            } else {
                notification.parentNode.removeChild(notification);
            }
        }
    }, 5000);
}

// Función auxiliar para formatear números con comas
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Función para actualizar el precio en el frontend (VERSIÓN ACTUALIZADA PARA USD Y COP)
function updatePrice(productId, newSubtotal, newTotal, newSubtotalCOP, newTotalCOP) {
    // Subtotal por producto
    const subtotalElement = document.querySelector(`.subtotal[data-id="${productId}"]`);
    if (subtotalElement) {
        subtotalElement.textContent = '$' + numberWithCommas(newSubtotal) + ' USD';
        // Busca el elemento COP dentro del mismo price-container
        const priceContainer = subtotalElement.closest('.price-container');
        if (priceContainer) {
            const copElement = priceContainer.querySelector('.price-cop');
            if (copElement) {
                copElement.textContent = '$' + numberWithCommas(newSubtotalCOP) + ' COP';
            }
        }
    }

    // Subtotal general
    const cartSubtotalElement = document.getElementById('cart-subtotal');
    if (cartSubtotalElement) {
        cartSubtotalElement.textContent = '$' + numberWithCommas(newTotal) + ' USD';
        const priceContainer = cartSubtotalElement.closest('.text-end');
        if (priceContainer) {
            const copSubtotal = priceContainer.querySelector('.price-cop');
            if (copSubtotal) {
                copSubtotal.textContent = '$' + numberWithCommas(newTotalCOP) + ' COP';
            }
        }
    }

    // Total general
    const cartTotalElement = document.getElementById('cart-total');
    if (cartTotalElement) {
        cartTotalElement.textContent = '$' + numberWithCommas(newTotal) + ' USD';
        const priceContainer = cartTotalElement.closest('.text-end');
        if (priceContainer) {
            const copTotal = priceContainer.querySelector('.price-cop');
            if (copTotal) {
                copTotal.textContent = '$' + numberWithCommas(newTotalCOP) + ' COP';
            }
        }
    }
}

// Función para actualizar la cantidad en el servidor
async function updateQuantity(productId, newQuantity) {
    console.log('Actualizando cantidad:', {productId, newQuantity});
    
    try {
        // Mostrar indicador de carga
        const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
        const buttons = document.querySelectorAll(`.quantity-btn[data-id="${productId}"]`);
        
        if (input) input.disabled = true;
        if (buttons) buttons.forEach(btn => btn.disabled = true);
        
        // Usar la ruta correcta
        const response = await fetch(`/cart/update-quantity/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ quantity: newQuantity })
        });

        // Verificar si la respuesta es JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const responseText = await response.text();
            console.error('Respuesta del servidor no es JSON:', responseText);
            throw new Error('Error en el servidor. Estado: ' + response.status);
        }

        const data = await response.json();
        console.log('Respuesta del servidor:', data);

        if (data.success) {
            updatePrice(productId, data.subtotal, data.total, data.subtotal_cop, data.total_cop);
            showNotification('Cantidad actualizada correctamente');
            
            // Actualizar contador del carrito
            const cartCount = document.querySelector('.cart-count');
            if (cartCount && data.items_count !== undefined) {
                cartCount.textContent = data.items_count;
            }
        } else {
            throw new Error(data.message || 'Error al actualizar la cantidad');
        }
    } catch (error) {
        console.error('Error en updateQuantity:', error);
        showNotification('Error: ' + error.message, 'danger');
        
        // Restaurar el valor anterior
        const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
        if (input && input.getAttribute('data-last-value')) {
            input.value = input.getAttribute('data-last-value');
        }
    } finally {
        // Habilitar el input y botones nuevamente
        const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
        const buttons = document.querySelectorAll(`.quantity-btn[data-id="${productId}"]`);
        if (input) input.disabled = false;
        if (buttons) buttons.forEach(btn => btn.disabled = false);
    }
}

// AJAX para eliminar producto del carrito
document.querySelectorAll('.remove-item-ajax').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const productId = this.getAttribute('data-id');
        if (!confirm('¿Eliminar producto del carrito?')) return;

        fetch(form.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Eliminar la fila del producto
                const row = document.querySelector(`.cart-item[data-id="${productId}"]`);
                if (row) row.remove();

                // Actualizar totales
                if (data.total !== undefined) {
                    document.getElementById('cart-subtotal').textContent = '$' + data.total + ' USD';
                    document.getElementById('cart-total').textContent = '$' + data.total + ' USD';
                    
                    // Actualizar COP también
                    const copSubtotal = document.getElementById('cart-subtotal').nextElementSibling;
                    const copTotal = document.getElementById('cart-total').nextElementSibling;
                    if (copSubtotal && copSubtotal.classList.contains('price-cop')) {
                        copSubtotal.textContent = '$' + numberWithCommas((data.total * 4200).toFixed(0)) + ' COP';
                    }
                    if (copTotal && copTotal.classList.contains('price-cop')) {
                        copTotal.textContent = '$' + numberWithCommas((data.total * 4200).toFixed(0)) + ' COP';
                    }
                }

                showNotification('Producto eliminado del carrito', 'danger');
            } else {
                showNotification('Error al eliminar el producto', 'danger');
            }
        })
        .catch(() => showNotification('Error al eliminar el producto', 'danger'));
    });
});

// AJAX para vaciar el carrito
const clearCartForm = document.getElementById('clear-cart-form');
if (clearCartForm) {
    clearCartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!confirm('¿Estás seguro de que quieres vaciar el carrito?')) return;

        fetch(this.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Vaciar la tabla y actualizar totales
                document.getElementById('cart-items').innerHTML = '';
                document.getElementById('cart-subtotal').textContent = '$0.00 USD';
                document.getElementById('cart-total').textContent = '$0.00 USD';
                
                // Actualizar COP también
                const copSubtotal = document.getElementById('cart-subtotal').nextElementSibling;
                const copTotal = document.getElementById('cart-total').nextElementSibling;
                if (copSubtotal && copSubtotal.classList.contains('price-cop')) {
                    copSubtotal.textContent = '$0 COP';
                }
                if (copTotal && copTotal.classList.contains('price-cop')) {
                    copTotal.textContent = '$0 COP';
                }
                
                showNotification('Carrito vaciado correctamente', 'warning');
            } else {
                showNotification('Error al vaciar el carrito', 'danger');
            }
        })
        .catch(() => showNotification('Error al vaciar el carrito', 'danger'));
    });
}

// Event listeners cuando el documento está listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('Carrito JavaScript cargado correctamente');
    
    // Botones de incremento (+)
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Botón aumentar clickeado');
            const productId = this.getAttribute('data-id');
            const input = this.closest('.input-group').querySelector('.quantity-input');
            
            if (!input) {
                console.error('No se encontró el input para el producto:', productId);
                return;
            }
            
            const max = parseInt(input.getAttribute('max')) || 100;
            let newQuantity = parseInt(input.value) + 1;
            
            if (newQuantity <= max) {
                input.value = newQuantity;
                input.setAttribute('data-last-value', newQuantity);
                updateQuantity(productId, newQuantity);
            } else {
                showNotification('Stock máximo: ' + max, 'warning');
            }
        });
    });

    // Botones de decremento (-)
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Botón disminuir clickeado');
            const productId = this.getAttribute('data-id');
            const input = this.closest('.input-group').querySelector('.quantity-input');
            
            if (!input) {
                console.error('No se encontró el input para el producto:', productId);
                return;
            }
            
            let newQuantity = Math.max(1, parseInt(input.value) - 1);
            
            if (newQuantity !== parseInt(input.value)) {
                input.value = newQuantity;
                input.setAttribute('data-last-value', newQuantity);
                updateQuantity(productId, newQuantity);
            }
        });
    });

    // Cambios manuales en el input
    document.querySelectorAll('.quantity-input').forEach(input => {
        // Guardar valor inicial
        input.setAttribute('data-last-value', input.value);
        
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-id');
            let newQuantity = parseInt(this.value);
            const max = parseInt(this.getAttribute('max')) || 100;
            const min = parseInt(this.getAttribute('min')) || 1;
            
            if (isNaN(newQuantity) || newQuantity < min) {
                newQuantity = min;
                this.value = newQuantity;
                showNotification('Cantidad mínima: ' + min, 'warning');
            } else if (newQuantity > max) {
                newQuantity = max;
                this.value = newQuantity;
                showNotification('Stock máximo: ' + max, 'warning');
            }
            
            if (newQuantity !== parseInt(this.getAttribute('data-last-value'))) {
                this.setAttribute('data-last-value', newQuantity);
                updateQuantity(productId, newQuantity);
            }
        });
    });
    
    console.log('Event listeners configurados correctamente');
});
</script>

<style>
/* Ocultar flechas de input number */
.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-input {
    -moz-appearance: textfield;
    appearance: textfield;
    border-left: 1px solid #dee2e6 !important;
    border-right: 1px solid #dee2e6 !important;
    text-align: center !important;
    font-weight: 600 !important;
}

.subtotal {
    transition: color 0.3s ease;
}

/* Estilo para notificaciones - Mismo estilo que las notificaciones de actualización */
.temp-notification {
    animation: slideInRight 0.3s ease;
    z-index: 1060;
    min-width: 300px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.375rem;
    padding: 1rem 1rem 1rem 1rem;
    border: 1px solid transparent;
}

/* Estilo para el botón de cerrar en notificaciones */
.temp-notification .btn-close {
    padding: 0.75rem;
    margin: -0.5rem -0.5rem -0.5rem auto;
    background-size: 0.75rem;
    position: static;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Estilo para inputs deshabilitados durante la carga */
.quantity-input:disabled,
.quantity-btn:disabled {
    background-color: #f8f9fa;
    opacity: 0.7;
    cursor: not-allowed;
}

/* Asegurar que los botones sean visibles */
.input-group .btn {
    visibility: visible !important;
    opacity: 1 !important;
    z-index: 5 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    position: relative !important;
}

/* Botones de cantidad visibles */
.increase-quantity, .decrease-quantity {
    background-color: #6b46c1 !important;
    color: white !important;
    border: 1px solid #6b46c1 !important;
    padding: 0.5rem 0.75rem !important;
    visibility: visible !important;
    opacity: 1 !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    z-index: 5 !important;
}

.increase-quantity:hover, .decrease-quantity:hover {
    background-color: #553c9a !important;
    border-color: #553c9a !important;
    color: white !important;
    transform: scale(1.05) !important;
}

/* Iconos dentro de los botones */
.increase-quantity i, .decrease-quantity i {
    font-size: 0.875rem !important;
    display: block !important;
}

/* Forzar visibilidad de iconos FontAwesome */
.fa-plus, .fa-minus {
    display: inline-block !important;
    font-family: 'Font Awesome 6 Free' !important;
    font-weight: 900 !important;
}
</style>
@endsection