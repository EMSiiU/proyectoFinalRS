<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment on a post
     */
    public function store(Request $request, Publicacion $publicacion)
    {
        $validated = $request->validate([
            'comentario' => 'required|string|max:500',
        ], [
            'comentario.required' => 'El comentario es requerido.',
            'comentario.max' => 'El comentario no puede exceder los 500 caracteres.',
        ]);

        Comentario::create([
            'id_usuario' => Auth::id(),
            'id_publicacion' => $publicacion->id_publicacion,
            'comentario' => $validated['comentario'],
            'fecha' => now(),
        ]);

        return back()->with('success', '¡Comentario agregado exitosamente!');
    }
}
