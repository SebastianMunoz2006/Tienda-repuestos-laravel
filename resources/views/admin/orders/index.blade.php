@extends('layouts.app')

@section('title', 'Gestión de Pedidos de Clientes - Administración')

@section('content')
<div class="container py-4">
    <!-- Aviso de Modo Administrador -->
    <div class="d-flex justify-content-center mb-4">
        <span class="badge fs-6 p-3 admin-mode-badge">
            <i class="fas fa-user-shield me-2"></i> Modo Administrador - Gestión de Pedidos
        </span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-boxes me-2"></i>Gestión de Pedidos de Clientes</h2>
                    <small class="text-muted">Panel de control para modificar estados de pedidos externos</small>
                </div>
                <span class="badge bg-primary fs-6 p-2">Total: {{ $orders->count() }} pedidos</span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($orders->count() > 0)
            <!-- Card con tabla de pedidos -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Cliente</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="order-row" data-order-id="{{ $order->id }}">
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>
                                        <small>{{ $order->customer_email }}</small>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-phone text-muted me-1"></i>
                                            {{ $order->customer_phone }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">${{ number_format($order->total, 2) }} USD</span>
                                        <br>
                                        <small class="text-muted">${{ number_format($order->total * 4200, 0, ',', '.') }} COP</small>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <select class="form-select form-select-sm status-select" data-order-id="{{ $order->id }}" style="max-width: 150px;">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pendiente
                                            </option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                En proceso
                                            </option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                Enviado
                                            </option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                Confirmado
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Ver detalles del pedido">
                                            <i class="fas fa-eye me-1"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @else
            <!-- Sin pedidos -->
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <p class="text-muted fs-5">No hay pedidos de clientes para mostrar</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i> Ver Productos
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Info box -->
    <div class="alert alert-info mt-4">
        <p class="mb-0">
            <strong>💡 Guía de Estados:</strong> 
            <br>
            <i class="fas fa-clock text-warning me-2"></i> <strong>Pendiente:</strong> Pedido recién creado
            <br>
            <i class="fas fa-spinner text-primary me-2"></i> <strong>En proceso:</strong> Se está preparando
            <br>
            <i class="fas fa-truck text-info me-2"></i> <strong>Enviado:</strong> En camino hacia el cliente
            <br>
            <i class="fas fa-check-circle text-success me-2"></i> <strong>Confirmado:</strong> Cliente confirmó recepción
        </p>
    </div>
</div>

<!-- Toast de confirmación -->
<div id="status-toast" class="position-fixed bottom-0 end-0 m-3" style="display: none; z-index: 1050;">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <span id="toast-message">Estado actualizado correctamente</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>

<style>
    .order-row {
        transition: all 0.2s ease;
    }
    .order-row:hover {
        background-color: #f8f9fa;
    }
    .status-select {
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }
    .status-select:hover {
        border-color: #6b46c1;
    }
    .status-select:focus {
        border-color: #6b46c1;
        box-shadow: 0 0 0 0.2rem rgba(107, 70, 193, 0.25);
    }
    .admin-mode-badge {
        animation: pulse-admin 1.5s infinite;
        background-color: #7c3aed !important;
        border: 2px solid #6d28d9 !important;
    }
    @keyframes pulse-admin {
        0%, 100% { 
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.8), 0 0 40px rgba(124, 58, 237, 0.4);
        }
        50% { 
            box-shadow: 0 0 40px rgba(124, 58, 237, 1), 0 0 80px rgba(124, 58, 237, 0.6);
        }
    }
</style>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.status-select').forEach(select => {
    select.addEventListener('change', function() {
        const orderId = this.dataset.orderId;
        const newStatus = this.value;
        const originalValue = this.value;

        // Mostrar loader
        this.disabled = true;
        this.style.opacity = '0.6';

        const url = `{{ url('/admin/orders') }}/${orderId}/status`;
        console.log('Enviando petición a:', url);
        console.log('Datos:', {status: newStatus});

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => {
            console.log('Respuesta status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            if(data.success) {
                // Re-habilitar select
                this.disabled = false;
                this.style.opacity = '1';
                
                // Mostrar toast
                const toast = document.getElementById('status-toast');
                const msg = document.getElementById('toast-message');
                msg.textContent = data.message || 'Estado actualizado correctamente';
                toast.style.display = 'block';
                
                // Auto-ocultar toast después de 4 segundos
                setTimeout(() => {
                    toast.style.display = 'none';
                }, 4000);
            } else {
                alert('Error: ' + (data.message || 'No se pudo actualizar el estado'));
                // Revertir el select al estado anterior
                this.value = originalValue;
                this.disabled = false;
                this.style.opacity = '1';
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            alert('Error al actualizar el estado: ' + error.message);
            // Revertir el select
            this.value = originalValue;
            this.disabled = false;
            this.style.opacity = '1';
        });
    });
});
</script>
@endsection

