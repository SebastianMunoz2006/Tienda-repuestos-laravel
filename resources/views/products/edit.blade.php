@extends('layouts.app')

@section('title', 'Editar Producto: ' . $product->name . ' - ' . config('app.name'))

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i> Editar Producto: <strong>{{ $product->name }}</strong>
                        </h5>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Volver al Producto
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i> Nombre del Producto *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $product->name) }}" 
                                       required
                                       placeholder="Ingrese el nombre completo del producto">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-1"></i> Descripción *
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          required
                                          placeholder="Describa detalladamente el producto...">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-1"></i> Precio (USD) *
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $product->price) }}" 
                                           required
                                           placeholder="0.00">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Ejemplo: 15.99
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">
                                    <i class="fas fa-boxes me-1"></i> Stock (Cantidad) *
                                </label>
                                <input type="number" 
                                       min="0" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock', $product->stock) }}" 
                                       required
                                       placeholder="0">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Cantidad disponible en inventario
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">
                                    <i class="fas fa-folder me-1"></i> Categoría *
                                </label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id" 
                                        required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" 
                                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                            <i class="fas fa-folder-open me-1"></i> {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label fw-bold">
                                    <i class="fas fa-trademark me-1"></i> Marca
                                </label>
                                <input type="text" 
                                       class="form-control @error('brand') is-invalid @enderror" 
                                       id="brand" 
                                       name="brand" 
                                       value="{{ old('brand', $product->brand) }}"
                                       placeholder="Ej: Toyota, Bosch, etc.">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-info-circle me-1"></i> Marca o fabricante del producto
                                </small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn btn-outline-warning px-4">
                                    <i class="fas fa-redo me-2"></i> Restablecer
                                </button>
                                <button type="submit" class="btn btn-primary px-4 ms-2">
                                    <i class="fas fa-save me-2"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> 
                                @if($product->created_at->diffInDays(now()) < 1)
                                    Creado hoy
                                @else
                                    Creado: {{ $product->created_at->format('d/m/Y') }}
                                @endif
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="fas fa-sync-alt me-1"></i> 
                                Última actualización: {{ $product->updated_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%) !important;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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
</style>
@endsection