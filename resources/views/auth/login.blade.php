@extends('layouts.app')

@section('title', 'Iniciar Sesión - ' . config('app.name'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Iniciar Sesión</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </form>
                
                <div class="text-center mt-3">
                    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection