@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" class="img-fluid rounded product-image" alt="{{ $product->name }}">
    </div>
    <div class="col-md-6">
        <h2>{{ $product->name }}</h2>
        <p class="text-muted">Categoría: {{ $product->category->name }}</p>
        <p class="lead">${{ number_format($product->price, 2) }}</p>
        <p>{{ $product->description }}</p>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Marca:</strong> {{ $product->brand }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Tipo de Vehículo:</strong> {{ $product->vehicle_type }}</p>
            </div>
        </div>
        
        <p>
            <strong>Disponibilidad:</strong> 
            @if($product->stock > 0)
                <span class="text-success">En stock ({{ $product->stock }} unidades)</span>
            @else
                <span class="text-danger">Agotado</span>
            @endif
        </p>
        
        @if($product->stock > 0)
        <form action="{{ route('cart.add') }}" method="POST" class="row g-3 align-items-center">
            @csrf
            <div class="col-auto">
                <label for="quantity" class="col-form-label">Cantidad:</label>
            </div>
            <div class="col-auto">
                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 80px;">
            </div>
            <div class="col-auto">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary btn-lg">Agregar al Carrito</button>
            </div>
        </form>
        @endif
        
        <div class="mt-4"><a href="{{ route('products.index') }}" class="btn-volver">Volver a Productos</a>
        </div>
    </div>
</div>
@endsection