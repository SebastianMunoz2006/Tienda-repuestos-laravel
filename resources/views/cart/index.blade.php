@extends('layouts.app')

@section('title', 'Carrito de Compras - ' . config('app.name'))

@section('content')
<h2 class="mb-4">Carrito de Compras</h2>

@if(!empty($products))
<form action="{{ route('cart.update') }}" method="POST">
    @csrf
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/' . ($item['image'] ?: 'default-product.jpg')) }}" alt="{{ $item['name'] }}" width="50" class="me-3">
                            <div>{{ $item['name'] }}</div>
                        </div>
                    </td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>
                        <input type="number" name="quantities[{{ $item['id'] }}]" value="{{ $item['quantity'] }}" min="1" class="form-control quantity-input">
                    </td>
                    <td>${{ number_format($item['total'], 2) }}</td>
                    <td>
                        <a href="{{ route('cart.remove', $item['id']) }}" class="btn btn-sm btn-danger">Eliminar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                    <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Seguir Comprando</a>
        <div>
            <button type="submit" name="update_cart" class="btn btn-secondary">Actualizar Carrito</button>
            @auth
                <a href="#" class="btn btn-success">Proceder al Pago</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning">Iniciar Sesión para Comprar</a>
            @endauth
        </div>
    </div>
</form>
@else
<div class="text-center py-5">
    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
    <h3>Tu carrito está vacío</h3>
    <p>Agrega algunos productos para continuar.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Ver Productos</a>
</div>
@endif
@endsection