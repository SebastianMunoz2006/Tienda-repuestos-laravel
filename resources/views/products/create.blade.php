@extends('layouts.app')

@section('title', 'Crear Nuevo Producto - ' . config('app.name'))

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i> Crear Nuevo Producto
                        </h5>
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Productos
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i> 
                            Complete todos los campos obligatorios (*) para crear un nuevo producto.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-tag me-1"></i> Nombre del Producto *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="Ej: Filtro de Aceite Toyota Corolla 2020">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-lightbulb me-1"></i> Use un nombre descriptivo y específico
                                </small>
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
                                          placeholder="Describa detalladamente el producto...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-lightbulb me-1"></i> Incluya características, especificaciones y usos
                                </small>
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
                                           value="{{ old('price') }}" 
                                           required
                                           placeholder="0.00">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-calculator me-1"></i> Ejemplo: 15.99
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
                                       value="{{ old('stock') }}" 
                                       required
                                       placeholder="0">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-warehouse me-1"></i> Cantidad inicial en inventario
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
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            <i class="fas fa-folder-open me-1"></i> {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-sitemap me-1"></i> Seleccione la categoría adecuada
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="brand" class="form-label fw-bold">
                                    <i class="fas fa-trademark me-1"></i> Marca
                                </label>
                                <input type="text" 
                                       class="form-control @error('brand') is-invalid @enderror" 
                                       id="brand" 
                                       name="brand" 
                                       value="{{ old('brand') }}"
                                       placeholder="Ej: Toyota, Bosch, ACDelco, etc.">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-industry me-1"></i> Marca o fabricante (opcional)
                                </small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="vehicle_type" class="form-label fw-bold">
                                    <i class="fas fa-car me-1"></i> Tipo de Vehículo
                                </label>
                                <input type="text" 
                                       class="form-control @error('vehicle_type') is-invalid @enderror" 
                                       id="vehicle_type" 
                                       name="vehicle_type" 
                                       value="{{ old('vehicle_type') }}"
                                       placeholder="Ej: Sedan, SUV, Camioneta, etc.">
                                @error('vehicle_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="fas fa-car-side me-1"></i> Tipo de vehículo compatible (opcional)
                                </small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn btn-outline-warning px-4">
                                    <i class="fas fa-redo me-2"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-success px-4 ms-2">
                                    <i class="fas fa-save me-2"></i> Crear Producto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="fas fa-exclamation-triangle me-1"></i> 
                        Todos los campos marcados con * son obligatorios. Revise la información antes de crear.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-success {
        background: linear-gradient(135deg, #198754 0%, #157347 100%) !important;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
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
    
    .alert-info {
        background-color: #e7f3ff;
        border-color: #b6d4fe;
        color: #084298;
    }
</style>
@endsection