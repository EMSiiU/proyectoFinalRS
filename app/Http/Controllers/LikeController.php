<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like on a post (like if not liked, unlike if already liked)
     */
    public function toggle(Publicacion $publicacion)
    {
        $userId = Auth::id();
        
        // Check if user already liked this post
        $existingLike = Like::where('id_usuario', $userId)
            ->where('id_publicacion', $publicacion->id_publicacion)
            ->first();
        
        if ($existingLike) {
            // Unlike: remove the like
            $existingLike->delete();
            $liked = false;
            $message = 'Like removido';
        } else {
            // Like: create new like
            Like::create([
                'id_usuario' => $userId,
                'id_publicacion' => $publicacion->id_publicacion,
                'fecha' => now(),
            ]);
            $liked = true;
            $message = '¡Te gusta esta publicación!';
        }
        
        // Get updated like count
        $likesCount = $publicacion->likes()->count();
        
        // Return JSON for AJAX or redirect for form submission
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
                'message' => $message,
            ]);
        }
        
        return back()->with('success', $message);
    }
}
