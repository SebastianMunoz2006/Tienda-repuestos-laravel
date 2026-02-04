<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ← CONSTRUCTOR PARA PROTEGER MÉTODOS
    public function __construct()
    {
        // Solo proteger métodos de creación/edición/eliminación
        $this->middleware('auth')->except(['index', 'show', 'byCategory', 'search']);
    }
    
    // ← MÉTODOS PARA JEFE
    public function create()
    {
        // Verifica si tiene permiso para crear productos
        if (!auth()->user()->can('crear productos')) {
            abort(403, 'No tienes permiso para crear productos');
        }
        
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        // Verifica si tiene permiso para crear productos
        if (!auth()->user()->can('crear productos')) {
            abort(403, 'No tienes permiso para crear productos');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
        ]);
        
        Product::create($request->all());
        
        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente!');
    }
    
    public function edit($id)
    {
        // Verifica si tiene permiso para editar productos
        if (!auth()->user()->can('editar productos')) {
            abort(403, 'No tienes permiso para editar productos');
        }
        
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        // Verifica si tiene permiso para editar productos
        if (!auth()->user()->can('editar productos')) {
            abort(403, 'No tienes permiso para editar productos');
        }
        
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'vehicle_type' => 'nullable|string|max:100',
        ]);
        
        $product->update($request->all());
        
        // CAMBIÉ ESTA LÍNEA: uso $id en lugar de $product->id
        return redirect()->route('products.show', $id)
            ->with('success', 'Producto actualizado exitosamente!');
    }
    
    public function destroy($id)
    {
        // Verifica si tiene permiso para eliminar productos
        if (!auth()->user()->can('eliminar productos')) {
            abort(403, 'No tienes permiso para eliminar productos');
        }
        
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente!');
    }
    
    // ← MÉTODOS ORIGINALES
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function byCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $products = Product::with('category')
                          ->where('category_id', $category_id)
                          ->paginate(12);
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
                          ->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories', 'keywords'));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}