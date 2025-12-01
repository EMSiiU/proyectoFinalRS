<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /*
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'usuario' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'contrasena' => ['required','string','min:4'],
            'nombre' => ['required', 'string', 'max:255'],
            'appellido1' => ['required', 'string', 'max:255'],
            'appellido2' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date'],
        ]);

        $user = User::create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'contrasena' => Hash::make($request->contrasena),
            'nombre' => $request->nombre,
            'appellido1' => $request->appellido1,
            'appellido2' => $request->appellido2,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);
        echo'estoy aqui';


        event(new Registered($user));

    Auth::login($user);

    // After registration, redirect user to profile setup to complete their profile
    return redirect(route('profile.setup', absolute: false));
    }
        */

    // Pega esto en app/Http/Controllers/Auth/RegisteredUserController.php

public function store(Request $request): RedirectResponse
{
    try {
        $request->validate([
            'usuario' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:'.User::class],
            'nombre' => ['required', 'string', 'max:50'],
            'apellido1' => ['required', 'string', 'max:50'],
            'apellido2' => ['nullable', 'string', 'max:50'],
            'fecha_nacimiento' => ['required', 'date'],
            'contrasena' => ['required', 'string', 'min:4'],
        ]);

        $user = User::create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'contrasena' => $request->contrasena, // Model will hash via setPasswordAttribute
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('profile.setup', absolute: false));

    } catch (ValidationException $e) {
        throw $e; // Re-throw validation exceptions to show errors in form
    } catch (\Exception $e) {
        \Log::error('Registration error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Error al registrar usuario. Por favor intenta de nuevo.'])->withInput();
    }
}
}
