@extends('layouts.app')

@section('title', (isset($category) ? $category->name : (isset($keywords) ? 'Búsqueda: ' . $keywords : 'Productos')) . ' - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Categorías</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('products.index') }}" class="list-group-item list-group-item-action">Todas las categorías</a>
                @foreach($categories as $categoryItem)
                <a href="{{ route('products.category', $categoryItem->id) }}" class="list-group-item list-group-item-action {{ isset($category) && $category->id == $categoryItem->id ? 'active' : '' }}">
                    {{ $categoryItem->name }}
                </a>
                @endforeach
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Buscar Productos</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="keywords" class="form-control" placeholder="Buscar..." value="{{ $keywords ?? '' }}">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <h2 class="mb-4">
            @if(isset($category))
                Productos - {{ $category->name }}
            @elseif(isset($keywords))
                Resultados de búsqueda: "{{ $keywords }}"
            @else
                Todos los Productos
            @endif
        </h2>
        
        <div class="row">
            @if($products->count() > 0)
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/' . ($product->image ?: 'default-product.jpg')) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="price-container">
                                <p class="card-text mb-1">
                                    <strong class="price-usd">${{ number_format($product->price, 2) }} USD</strong>
                                </p>
                                <p class="card-text mb-0">
                                    <small class="price-cop">${{ number_format($product->price * 4200, 0, ',', '.') }} COP</small>
                                </p>
                            </div>
                            <p class="card-text"><small class="text-muted">Marca: {{ $product->brand }}</small></p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver Detalles</a>
                            @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-success"><i class="fas fa-cart-plus"></i></button>
                            </form>
                            @else
                            <button class="btn btn-secondary" disabled>Agotado</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">No se encontraron productos.</div>
                </div>
            @endif
        </div>
        
        @if($products->count() > 0)
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination custom-pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($products->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">‹ Anterior</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}">‹ Anterior</a>
                </li>
            @endif

            {{-- Pagination Numbers --}}
            @php
                $current = $products->currentPage();
                $last = $products->lastPage();
                $start = max(1, $current - 2);
                $end = min($last, $current + 2);
            @endphp

            @if($start > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $products->url(1) }}">1</a>
                </li>
                @if($start > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $products->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($products->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}">Siguiente ›</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Siguiente ›</span>
                </li>
            @endif
        </ul>
    </nav>
</div>

{{-- Información de paginación --}}
<div class="text-center mt-2">
    <small class="text-muted">
        Mostrando {{ $products->firstItem() }} a {{ $products->lastItem() }} de {{ $products->total() }} resultados
    </small>
</div>
@endif
    </div>
</div>
@endsection