<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Like;
use App\Models\Publicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Load paginated publicaciones with counts
        $publicaciones = $user->publicaciones()
            ->withCount(['likes', 'comentarios'])
            ->paginate(10);
        
        // Load liked posts (posts the user has liked)
        $likedPosts = Publicacion::whereHas('likes', function($query) use ($user) {
                $query->where('id_usuario', $user->id_usuario);
            })
            ->with(['usuario', 'likes', 'comentarios'])
            ->withCount(['likes', 'comentarios'])
            ->orderByDesc(
                Like::select('fecha')
                    ->whereColumn('likes.id_publicacion', 'publicacion.id_publicacion')
                    ->where('likes.id_usuario', $user->id_usuario)
                    ->limit(1)
            )
            ->paginate(10, ['*'], 'liked_page');

        return view('profile', [
            'user' => $user,
            'publicaciones' => $publicaciones,
            'likedPosts' => $likedPosts,
        ]);
    }

    /**
     * Show post-registration profile setup form.
     */
    public function setup(Request $request): View
    {
        return view('profile-setup', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Store profile setup data.
     */
    public function storeSetup(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'usuario' => ['required', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:50'],
            'apellido1' => ['nullable', 'string', 'max:50'],
            'apellido2' => ['nullable', 'string', 'max:50'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'foto_portada' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'],
        ]);

        // Update known fields
        $user->usuario = $request->input('usuario', $user->usuario);
        $user->nombre = $request->input('nombre', $user->nombre);
        $user->apellido1 = $request->input('apellido1', $user->apellido1);
        $user->apellido2 = $request->input('apellido2', $user->apellido2);
        $user->fecha_nacimiento = $request->input('fecha_nacimiento', $user->fecha_nacimiento);

        // Optional fields that may not exist in database
        if (\Illuminate\Support\Facades\Schema::hasColumn($user->getTable(), 'bio')) {
            $user->bio = $request->input('bio');
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn($user->getTable(), 'location')) {
            $user->location = $request->input('location');
        }

        if (\Illuminate\Support\Facades\Schema::hasColumn($user->getTable(), 'website')) {
            $user->website = $request->input('website');
        }

        // Profile photo upload
        if ($request->hasFile('foto_perfil') && $request->file('foto_perfil')->isValid()) {
            $path = $request->file('foto_perfil')->store('profiles', 'public');
            $user->foto_perfil = $path;
        }

        // Cover photo upload
        if ($request->hasFile('foto_portada') && $request->file('foto_portada')->isValid()) {
            $path = $request->file('foto_portada')->store('covers', 'public');
            $user->foto_portada = $path;
        }

        $user->save();

        return redirect()->route('feed')->with('status', 'profile-setup-complete');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
