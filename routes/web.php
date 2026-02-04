<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// ====================
// RUTAS PÚBLICAS
// ====================

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas PÚBLICAS de productos (sin autenticación)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category_id}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Rutas de autenticación (PÚBLICAS)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // ← ESTA ES IMPORTANTE
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ====================
// RUTAS AUTENTICADAS (todos los usuarios)
// ====================
Route::middleware(['auth'])->group(function () {
    
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ====================
    // RUTAS SOLO PARA JEFE
    // ====================
    
    // Crear producto
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create')
        ->middleware('can:crear productos');
    
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store')
        ->middleware('can:crear productos');
    
    // Editar producto - DEBE IR ANTES que products/{id}
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
        ->name('products.edit')
        ->middleware('can:editar productos');
    
    Route::put('/products/{id}', [ProductController::class, 'update'])
        ->name('products.update')
        ->middleware('can:editar productos');
    
    // Eliminar producto
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])
        ->name('products.destroy')
        ->middleware('can:eliminar productos');
    
    // ====================
    // RUTAS PARA TODOS LOS AUTENTICADOS
    // ====================
    
    // Carrito de compras
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update-quantity/{product_id}', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/confirm-order', [CartController::class, 'confirmOrder'])->name('cart.confirm-order');
    Route::get('/cart/success', [CartController::class, 'success'])->name('cart.success');
    
    // Comentarios
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Pedidos del usuario
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/my-orders/{order}/confirm-delivery', [OrderController::class, 'confirmDelivery'])->name('orders.confirm-delivery');

    // Perfil del usuario
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Notificaciones: marcar leídas (AJAX)
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');

});

// Rutas para administración de pedidos (solo JEFE/ADMIN)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/admin/orders/{order}/status', [App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

// ====================
// RUTA PÚBLICA PARA VER PRODUCTO - DEBE IR AL FINAL
// ====================
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');