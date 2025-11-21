<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController; // <-- AGREGAR ESTA LÍNEA
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de productos
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category_id}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Rutas del carrito (CORREGIDAS - métodos HTTP correctos)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update-quantity/{product_id}', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Rutas de comentarios
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== RUTAS DE CHECKOUT (AGREGAR AL FINAL) ==========
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/confirm-order', [CartController::class, 'confirmOrder'])->name('cart.confirm-order');
Route::get('/cart/success', [CartController::class, 'success'])->name('cart.success');

// Rutas de pedidos del usuario
Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');