<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <a class="nav-link {{ request()->is('my-orders*') ? 'active' : '' }}" href="{{ url('/my-orders') }}">
                            <i class="fas fa-clipboard-list"></i> Mis Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link {{ request()->is('cart*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Carrito 
                            <span class="cart-count">{{ count(session('cart', [])) }}</span>
                        </a>
                    </li>
                    {{-- Menú Admin/Jefe --}}
                    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('jefe')))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-boxes"></i> Gestionar Pedidos
                        </a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    @auth
                        {{-- Notificaciones dropdown --}}
                        <li class="nav-item dropdown me-2">
                            <a class="nav-link position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                                @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                                @if($unread > 0)
                                    <span class="badge bg-danger position-absolute notif-count" style="top:0;right:0;transform:translate(30%,-30%);">{{ $unread }}</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="notifDropdown" style="min-width:320px;">
                                <div id="notif-list">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li class="dropdown-item notif-item" data-id="{{ $notification->id }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
                                                <div class="fw-semibold">{{ $notification->data['message'] ?? 'Nuevo evento' }}</div>
                                                <div class="small text-muted">Total: ${{ number_format($notification->data['total'] ?? 0, 2) }}</div>
                                            </div>
                                            <div class="ms-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary mark-notif-btn" data-id="{{ $notification->id }}">Marcar</button>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @empty
                                    <li class="dropdown-item text-center small text-muted notif-empty">Sin nuevas notificaciones</li>
                                @endforelse
                                </div>
                                <li class="mt-2 text-center">
                                    <button type="button" class="btn btn-sm btn-link mark-all-notif-btn">Marcar todas como leídas</button>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-history me-2"></i>Mis Pedidos
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
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
                        <li><a href="{{ url('/my-orders') }}">Mis Pedidos</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Cra. 5 #13-56, Puerto Boyacá, Boyacá</p>
                    <p><i class="fas fa-phone"></i> 318 250 8979</p>
                    <p><i class="fas fa-envelope"></i> info@autorepuestospro.com</p>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'AutoRepuestos Pro') }}. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')

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

    // AJAX para marcar notificación individual como leída
    document.querySelectorAll('.mark-notif-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notifId = this.dataset.id;
            const notifItem = document.querySelector(`[data-id="${notifId}"]`);

            fetch(`{{ url('/notifications') }}/${notifId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Remover la notificación y el hr del dropdown
                    if(notifItem) {
                        const hr = notifItem.nextElementSibling;
                        notifItem.remove();
                        if(hr && hr.tagName === 'HR') hr.remove();
                    }

                    // Actualizar contador
                    const countEl = document.querySelector('.notif-count');
                    if(data.unread_count > 0) {
                        if(countEl) countEl.textContent = data.unread_count;
                    } else {
                        if(countEl) countEl.remove();
                        // Mostrar "Sin nuevas notificaciones"
                        const list = document.getElementById('notif-list');
                        if(list && !list.querySelector('.notif-empty')) {
                            const empty = document.createElement('li');
                            empty.className = 'dropdown-item text-center small text-muted notif-empty';
                            empty.textContent = 'Sin nuevas notificaciones';
                            list.appendChild(empty);
                        }
                    }
                }
            })
            .catch(err => console.error('Error marcando notificación:', err));
        });
    });

    // AJAX para marcar todas como leídas
    document.querySelector('.mark-all-notif-btn')?.addEventListener('click', function(e) {
        e.preventDefault();

        fetch('{{ route("notifications.markAllRead") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Remover todas las notificaciones
                const list = document.getElementById('notif-list');
                list.innerHTML = '<li class="dropdown-item text-center small text-muted notif-empty">Sin nuevas notificaciones</li>';

                // Remover badge de contador
                const countEl = document.querySelector('.notif-count');
                if(countEl) countEl.remove();
            }
        })
        .catch(err => console.error('Error marcando todas:', err));
    });
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