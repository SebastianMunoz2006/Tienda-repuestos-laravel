<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener categorías para el menú
        $categories = Category::all();
        
        // Obtener productos destacados
        $featured_products = Product::with('category')->latest()->take(3)->get();
        
        // Pasar las variables a la vista
        return view('home', compact('categories', 'featured_products'));
    }
}