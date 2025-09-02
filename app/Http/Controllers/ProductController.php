<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12); // ← CAMBIADO
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function byCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $products = Product::with('category')
                          ->where('category_id', $category_id)
                          ->paginate(12); // ← CAMBIADO
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories', 'category'));
    }
    
    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $products = Product::with('category')
                          ->where('name', 'like', "%{$keywords}%")
                          ->orWhere('description', 'like', "%{$keywords}%")
                          ->orWhere('brand', 'like', "%{$keywords}%")
                          ->paginate(12); // ← CAMBIADO
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories', 'keywords'));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}