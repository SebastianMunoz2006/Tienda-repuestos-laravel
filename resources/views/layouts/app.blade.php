<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR MEJORADO -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-car"></i> {{ config('app.name', 'AutoRepuestos Pro') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link {{ request()->is('cart*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Carrito 
                            <span class="cart-count">{{ count(session('cart', [])) }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">Hola, {{ Auth::user()->name }}</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <!-- FOOTER MEJORADO -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-car"></i> {{ config('app.name', 'AutoRepuestos Pro') }}</h5>
                    <p>Tu tienda confiable para repuestos de vehículos de calidad.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}">Inicio</a></li>
                        <li><a href="{{ route('products.index') }}">Productos</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Cra. 5 #13-56, Puerto Boyacá, Boyacá</p>
                    <p><i class="fas fa-phone"></i> (123) 456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@autorepuestospro.com</p>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'AutoRepuestos Pro') }}. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')  <!-- AGREGA ESTA LÍNEA -->

    <script>
    // Función para mostrar notificaciones destacadas
    function showNotification(message, type = 'success') {
        // Eliminar notificaciones anteriores
        const existingNotifications = document.querySelectorAll('.temp-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show temp-notification notification-pop position-fixed`;
        notification.style.top = '30px';
        notification.style.right = '30px';
        notification.style.zIndex = '2000';

        notification.innerHTML = `
            <button type="button" class="btn-close" onclick="this.parentElement.remove()" aria-label="Cerrar"></button>
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto-eliminar después de 5 segundos
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }
    </script>

    <style>
    /* Notificación destacada para el carrito */
    .notification-pop {
        animation: popIn 0.4s cubic-bezier(.68,-0.55,.27,1.55);
        border: 2px solid #6b46c1 !important;
        box-shadow: 0 8px 32px rgba(107,70,193,0.18), 0 2px 8px rgba(0,0,0,0.08) !important;
        background: linear-gradient(135deg, #f7fafc 80%, #d6bcfa 100%) !important;
        color: #44337a !important;
        border-radius: 16px !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        padding: 1.2rem 2.5rem 1.2rem 1.5rem !important; /* Más espacio a la derecha */
        position: relative;
        min-width: 340px;
        max-width: 400px;
    }

    .notification-pop .fa-check-circle {
        color: #38a169 !important;
        text-shadow: 0 2px 8px #d6bcfa;
    }

    .notification-pop .btn-close {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 1.2rem;
        height: 1.2rem;
        opacity: 0.7;
        z-index: 10;
    }

    .notification-pop .btn-close:hover {
        opacity: 1;
    }

    @keyframes popIn {
        0% { transform: scale(0.7) translateY(-30px); opacity: 0; }
        80% { transform: scale(1.05) translateY(5px); opacity: 1; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
    </style>
</body>
</html>