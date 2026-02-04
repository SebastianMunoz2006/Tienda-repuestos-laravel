@extends('layouts.app')

@section('title', 'Mi Perfil - AutorepuestosPro')

@section('content')
<div class="container py-4">
    <!-- Aviso de Modo Administrador -->
    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('jefe')))
    <div class="d-flex justify-content-center mb-4">
        <span class="badge fs-6 p-3 admin-mode-badge">
            <i class="fas fa-user-shield me-2"></i> Modo Administrador Activado
        </span>
    </div>
    @endif

    <div class="row">
        <div class="col-md-3">
            <!-- Menú Lateral -->
            <div class="list-group mb-4">
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">
                    <i class="fas fa-user me-2"></i> Mi Información
                </a>
                <a href="{{ route('profile.change-password') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-lock me-2"></i> Cambiar Contraseña
                </a>
                <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-history me-2"></i> Mis Pedidos
                </a>
            </div>

            <!-- Información del Usuario -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                    </div>
                    <h6 class="mb-2">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                    <div class="mt-3">
                        <span class="badge bg-primary">{{ auth()->user()->getRoleNames()->implode(', ') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Contenido Principal -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Información Personal</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Por favor corrige los errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre Completo
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Teléfono
                                </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+57...">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-pin me-2"></i>Dirección
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       id="address" name="address" value="{{ old('address', auth()->user()->address) }}" 
                                       placeholder="Calle, número, apartamento">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ciudad -->
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">
                                    <i class="fas fa-city me-2"></i>Ciudad
                                </label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', auth()->user()->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- País -->
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">
                                    <i class="fas fa-globe me-2"></i>País
                                </label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                       id="country" name="country" value="{{ old('country', auth()->user()->country) }}" placeholder="Colombia">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Código Postal -->
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">
                                    <i class="fas fa-mailbox me-2"></i>Código Postal
                                </label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-4">
                <p class="mb-0">
                    <strong>💡 Información importante:</strong> 
                    <br>
                    Mantén tus datos de contacto actualizados para que podamos notificarte sobre tus pedidos y ofertas especiales.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
