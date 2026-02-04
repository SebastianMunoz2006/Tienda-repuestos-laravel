<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'product_id' => $request->product_id,
            'user_name' => auth()->user()->name,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comentario enviado correctamente.');
    }
}