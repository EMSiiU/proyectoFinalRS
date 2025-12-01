<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the messages view with followed users and selected conversation.
     */
    public function index(Request $request, ?int $id = null): View
    {
        $user = Auth::user();
        
        // Get users that the current user follows
        $seguidos = $user->seguidos()->get();
        
        $selectedUser = null;
        $messages = collect();

        if ($id) {
            $selectedUser = \App\Models\User::find($id);
            
            if ($selectedUser) {
                // Fetch messages between current user and selected user
                $messages = \App\Models\Mensaje::where(function($query) use ($user, $id) {
                        $query->where('id_emisor', $user->id_usuario)
                              ->where('id_receptor', $id);
                    })
                    ->orWhere(function($query) use ($user, $id) {
                        $query->where('id_emisor', $id)
                              ->where('id_receptor', $user->id_usuario);
                    })
                    ->orderBy('fecha', 'asc')
                    ->get();
            }
        }

        return view('messages', [
            'seguidos' => $seguidos,
            'selectedUser' => $selectedUser,
            'messages' => $messages
        ]);
    }

    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_receptor' => 'required|exists:usuario,id_usuario',
            'mensaje' => 'required|string|max:1000',
        ]);

        \App\Models\Mensaje::create([
            'id_emisor' => Auth::id(),
            'id_receptor' => $request->id_receptor,
            'mensaje' => $request->mensaje,
            'fecha' => now(),
            'leido' => false,
        ]);

        return back();
    }
}
