<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display the feed with all posts
     */
    public function index()
    {
        // Get posts from followed users and own posts
        $user = Auth::user();
        
        // Get IDs of users that the current user follows
        $followedUserIds = $user->seguidos()->pluck('id_usuario')->toArray();
        
        // Add current user's ID to show their own posts
        $followedUserIds[] = $user->id_usuario;
        
        // Get posts from followed users and self, ordered by date (most recent first)
        $publicaciones = Publicacion::whereIn('id_usuario', $followedUserIds)
            ->with(['usuario', 'likes', 'comentarios'])
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function($publicacion) use ($user) {
                // Check if current user has liked this post
                $publicacion->user_has_liked = $publicacion->likes()
                    ->where('id_usuario', $user->id_usuario)
                    ->exists();
                return $publicacion;
            });
        
        return view('feed', compact('publicaciones'));
    }

    /**
     * Store a new post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'texto' => 'required|string|max:1000',
        ], [
            'texto.required' => 'El texto de la publicación es requerido.',
            'texto.max' => 'El texto no puede exceder los 1000 caracteres.',
        ]);

        $publicacion = Publicacion::create([
            'id_usuario' => Auth::id(),
            'texto' => $validated['texto'],
            'fecha' => now(),
            'multimedia' => null, // For future implementation
        ]);

        return redirect()->route('feed')->with('success', '¡Publicación creada exitosamente!');
    }
}
