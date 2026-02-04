@extends('layouts.app')

@section('title', 'Cambiar Contraseña - AutorepuestosPro')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <!-- Menú Lateral -->
            <div class="list-group mb-4">
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-user me-2"></i> Mi Información
                </a>
                <a href="{{ route('profile.change-password') }}" class="list-group-item list-group-item-action active">
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
                    <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Cambiar Contraseña</h5>
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

                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-key me-2"></i>Contraseña Actual
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Nueva Contraseña
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                            <small class="text-muted">Debe tener al menos 8 caracteres</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-2"></i>Confirmar Nueva Contraseña
                            </label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Importante:</strong> Por seguridad, se te pedirá que inicies sesión nuevamente después de cambiar tu contraseña.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cambiar Contraseña
                            </button>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
