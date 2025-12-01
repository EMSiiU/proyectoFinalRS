<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    /**
     * Follow a user.
     */
    public function store(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id_usuario === $user->id_usuario) {
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }

        if (!$currentUser->seguidos()->where('id_seguido', $user->id_usuario)->exists()) {
            // Attach relationship
            $currentUser->seguidos()->attach($user->id_usuario, ['fecha' => now()]);

            // Update counts manually since we are not using standard Eloquent events for this
            $currentUser->increment('seguidos_count');
            $user->increment('seguidores_count');
        }

        return back();
    }

    /**
     * Unfollow a user.
     */
    public function destroy(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->seguidos()->where('id_seguido', $user->id_usuario)->exists()) {
            // Detach relationship
            $currentUser->seguidos()->detach($user->id_usuario);

            // Update counts
            $currentUser->decrement('seguidos_count');
            $user->decrement('seguidores_count');
        }

        return back();
    }
}
