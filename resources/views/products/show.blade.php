@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="position-relative">
                    <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" 
                         class="img-fluid rounded product-image w-100" 
                         alt="{{ $product->name }}"
                         style="height: 400px; object-fit: cover;">
                    
                    {{-- BADGE DE STOCK --}}
                    <div class="position-absolute top-0 end-0 m-3">
                        @if($product->stock > 10)
                            <span class="badge bg-success fs-6 py-2 px-3">
                                <i class="fas fa-check me-1"></i> En stock: {{ $product->stock }}
                            </span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark fs-6 py-2 px-3">
                                <i class="fas fa-exclamation-triangle me-1"></i> Poco stock: {{ $product->stock }}
                            </span>
                        @else
                            <span class="badge bg-danger fs-6 py-2 px-3">
                                <i class="fas fa-times me-1"></i> Agotado
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="mb-0">{{ $product->name }}</h3>
                        {{-- BOTONES DE ACCIÓN --}}
                        <div class="btn-group">
                            @can('editar productos')
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            @endcan
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm ms-2">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                    
                    <div class="price-container p-4 bg-light rounded mb-4">
                        <div class="text-center">
                            <h2 class="text-primary display-6 fw-bold mb-2">
                                ${{ number_format($product->price, 2) }} USD
                            </h2>
                            <h4 class="text-muted">
                                ${{ number_format($product->price * 4200, 0, ',', '.') }} COP
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h4 class="mb-3">
                    <i class="fas fa-info-circle text-primary me-2"></i> Información del Producto
                </h4>
                
                <div class="mb-4">
                    <h5 class="fw-bold mb-2">Descripción</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold">
                                    <i class="fas fa-folder text-primary me-2"></i> Categoría
                                </h6>
                                <p class="mb-0">{{ $product->category->name }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold">
                                    <i class="fas fa-trademark text-primary me-2"></i> Marca
                                </h6>
                                <p class="mb-0">{{ $product->brand ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($product->vehicle_type)
                    <div class="col-md-12 mb-3">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold">
                                    <i class="fas fa-car text-primary me-2"></i> Tipo de Vehículo
                                </h6>
                                <p class="mb-0">{{ $product->vehicle_type }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($product->stock > 0)
                <div class="card border-primary border-2 mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">
                            <i class="fas fa-shopping-cart me-2"></i> Agregar al Carrito
                        </h5>
                        <form action="{{ route('cart.add') }}" method="POST" class="row g-3 align-items-center">
                            @csrf
                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-bold">Cantidad:</label>
                                <input type="number" 
                                       class="form-control form-control-lg" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}">
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
                                </button>
                            </div>
                            <div class="col-12">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    Máximo disponible: {{ $product->stock }} unidades
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Este producto está actualmente agotado.
                </div>
                @endif
                
                {{-- BOTÓN ELIMINAR PARA JEFE --}}
                @can('eliminar productos')
                <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                          onsubmit="return confirm('¿Está SEGURO de eliminar este producto?\n\nProducto: {{ $product->name }}\n\nEsta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i> Eliminar Producto
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

{{-- Sección de comentarios --}}
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-gradient-purple text-white">
        <h5 class="mb-0">
            <i class="fas fa-comments me-2"></i> Comentarios y Sugerencias
        </h5>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Formulario para nuevo comentario --}}
        <div class="card border-0 bg-light mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-edit me-2"></i> Escribir un comentario
                </h6>
                
                @auth
                <p class="small text-muted mb-3">
                    <i class="fas fa-info-circle me-1"></i>
                    Comentarás como: <strong>{{ auth()->user()->name }}</strong>
                </p>
                
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-3">
                        <textarea name="content" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Escribe tu sugerencia o experiencia con este producto..." 
                                  required 
                                  maxlength="500"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Comentario
                        </button>
                    </div>
                </form>
                @else
                <div class="alert alert-info mb-0">
                    <i class="fas fa-lock me-2"></i>
                    <a href="{{ route('login') }}">Inicia sesión</a> para dejar un comentario
                </div>
                @endauth
            </div>
        </div>

        {{-- Listado de comentarios --}}
        @php
            $comments = $product->comments()->latest()->get();
        @endphp
        
        @if($comments->count())
            <h6 class="fw-bold mb-3">
                <i class="fas fa-comment-dots me-2"></i> Comentarios ({{ $comments->count() }})
            </h6>
            @foreach($comments as $comment)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold text-purple mb-0">
                                    <i class="fas fa-user-circle me-2"></i> {{ $comment->user_name }}
                                </h6>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <p class="mb-0">{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4">
                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">Sé el primero en comentar este producto</h6>
            </div>
        @endif
    </div>
</div>

<style>
    .bg-gradient-purple {
        background: linear-gradient(135deg, #6b46c1 0%, #553c9a 100%) !important;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-image {
        transition: transform 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.02);
    }
    
    .price-container {
        border-left: 5px solid #0d6efd;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .border-primary {
        border-color: #0d6efd !important;
    }
</style>
@endsection