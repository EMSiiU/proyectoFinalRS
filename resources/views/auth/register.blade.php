<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- User Name -->
        <div>
            <x-input-label for="usuario" :value="__('Nombre de Usuario')" />
            <x-text-input id="usuario" class="block mt-1 w-full" type="text" name="usuario" :value="old('usuario')" required autofocus autocomplete="usuario" />
            <x-input-error :messages="$errors->get('usuario')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="contrasena" :value="__('Contraseña')" />

            <x-text-input id="contrasena" class="block mt-1 w-full"
                            type="password"
                            name="contrasena"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('contrasena')" class="mt-2" />
        </div>

        <!-- First Name -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- last Name 1 -->
        <div>
            <x-input-label for="apellido1" :value="__('Apellido Paterno')" />
            <x-text-input id="apellido1" class="block mt-1 w-full" type="text" name="apellido1" :value="old('apellido1')" required autofocus autocomplete="apellido1" />
            <x-input-error :messages="$errors->get('apellido1')" class="mt-2" />
        </div>

        <!-- last Name 2-->
        <div>
            <x-input-label for="apellido2" :value="__('Apellido Materno')" />
            <x-text-input id="apellido2" class="block mt-1 w-full" type="text" name="apellido2" :value="old('apellido2')"  autofocus autocomplete="apellido2" />
            <x-input-error :messages="$errors->get('apellido2')" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div>
            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" required autofocus autocomplete="fecha_nacimiento" />
            <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
