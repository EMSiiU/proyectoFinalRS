<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Search users by username or name
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'users' => [],
                'message' => 'Ingresa al menos 2 caracteres para buscar'
            ]);
        }

        $users = User::where('id_usuario', '!=', Auth::id())
            ->where(function($q) use ($query) {
                $q->where('usuario', 'LIKE', "%{$query}%")
                  ->orWhere('nombre', 'LIKE', "%{$query}%")
                  ->orWhere('apellido1', 'LIKE', "%{$query}%")
                  ->orWhere('apellido2', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function($user) {
                $isFollowing = Auth::user()->seguidos()
                    ->where('id_seguido', $user->id_usuario)
                    ->exists();
                
                return [
                    'id' => $user->id_usuario,
                    'name' => $user->name,
                    'usuario' => $user->usuario,
                    'foto_perfil' => $user->foto_perfil,
                    'is_following' => $isFollowing,
                ];
            });

        return response()->json([
            'users' => $users,
            'count' => $users->count()
        ]);
    }
}
