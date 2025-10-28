<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_name' => 'required|string|max:100',
            'content' => 'required|string|max:500',
        ]);

        Comment::create($request->only('product_id', 'user_name', 'content'));

        return back()->with('success', 'Comentario enviado correctamente.');
    }
}