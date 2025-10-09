@extends('layouts.app')

@section('title', 'Inicio - ' . config('app.name'))

@section('content')
<!-- Hero Section Mejorado -->
<section class="hero-section py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3 text-dark">Encuentra los mejores repuestos para tu vehículo</h1>
                <p class="lead mb-4 text-secondary">Calidad garantizada y precios competitivos en todos nuestros productos. Todo lo que necesita tu auto en un solo lugar.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>Ver Productos
                    </a>
                    <a href="#categories" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-list me-2"></i>Ver Categorías
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Repuestos de vehículos" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Estadísticas -->
<section class="stats-section py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="text-primary fw-bold">500+</h3>
                    <p class="text-muted">Productos Disponibles</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="text-primary fw-bold">7</h3>
                    <p class="text-muted">Categorías</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="text-primary fw-bold">1000+</h3>
                    <p class="text-muted">Clientes Satisfechos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3 class="text-primary fw-bold">5</h3>
                    <p class="text-muted">Años de Experiencia</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categorías Populares -->
<section id="categories" class="categories-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Categorías Populares</h2>
            <p class="text-muted">Explora nuestras principales categorías de repuestos</p>
        </div>
        
        <div class="row">
            @foreach($categories->take(3) as $category)
            <div class="col-md-4 mb-4">
                <div class="card category-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="category-icon mb-3">
                            <i class="fas fa-cog fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title fw-bold text-dark">{{ $category->name }}</h5>
                        <p class="card-text text-muted">{{ $category->description }}</p>
                        <a href="{{ route('products.category', $category->id) }}" class="btn btn-outline-primary">
                            Explorar Productos
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Ver Todas las Categorías
            </a>
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="featured-products py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">Productos Destacados</h2>
            <p class="text-muted">Los repuestos más populares de nuestra tienda</p>
        </div>
        
        <div class="row">
            @foreach($featured_products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="position-relative">
                        <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" 
                             class="card-img-top product-image" alt="{{ $product->name }}">
                        @if($product->stock > 0)
                        <span class="badge bg-success position-absolute top-0 end-0 m-2">En Stock</span>
                        @else
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Agotado</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                        <div class="price-container">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="h5 text-primary fw-bold mb-0 price-usd">${{ number_format($product->price, 2) }} USD</span>
                                <span class="badge bg-secondary">{{ $product->brand }}</span>
                            </div>
                            <div class="text-start">
                                <small class="price-cop fw-bold">${{ number_format($product->price * 4200, 0, ',', '.') }} COP</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>Ver Detalles
                            </a>
                            @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Agregar al Carrito
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="fas fa-times me-2"></i>Agotado
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-list me-2"></i>Ver Todos los Productos
            </a>
        </div>
    </div>
</section>

<!-- Por qué elegirnos -->
<section class="why-choose-us py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark">¿Por qué elegirnos?</h2>
            <p class="text-muted">Las razones para confiar en nosotros</p>
        </div>
        
        <div class="row">
            <div class="col-md-3 text-center mb-4">
                <div class="feature-item">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5 class="text-dark">Calidad Garantizada</h5>
                    <p class="text-muted">Todos nuestros productos tienen garantía</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="feature-item">
                    <i class="fas fa-truck-fast fa-3x text-primary mb-3"></i>
                    <h5 class="text-dark">Envío Rápido</h5>
                    <p class="text-muted">Entregas en todo el país</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="feature-item">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5 class="text-dark">Soporte 24/7</h5>
                    <p class="text-muted">Atención al cliente siempre disponible</p>
                </div>
            </div>
            <div class="col-md-3 text-center mb-4">
                <div class="feature-item">
                    <i class="fas fa-dollar-sign fa-3x text-primary mb-3"></i>
                    <h5 class="text-dark">Mejores Precios</h5>
                    <p class="text-muted">Precios competitivos en el mercado</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection