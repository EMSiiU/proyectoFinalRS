<nav class="fixed top-0 left-0 h-screen w-64 bg-gray-800 text-gray-200 flex flex-col justify-between">

    <div>
        <!-- Logo -->
        <div class="p-4 flex items-center justify-center border-b border-gray-700">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-10 w-auto fill-current text-white" />
            </a>
        </div>

        <!-- Links principales -->
        <div class="mt-6 flex flex-col space-y-2">
            {{-- (Corrección menor: el hover debe ser 700, no 800, para que se note) --}}
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-6 py-2 hover:bg-gray-700 rounded-md">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="px-6 py-2 hover:bg-gray-700 rounded-md">
                {{ __('Perfil') }}
            </x-nav-link>
        </div>
    </div>

    <!-- Sección inferior -->
    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-6 py-2 hover:bg-gray-700 rounded-md">
                {{ __('Cerrar sesión') }}
            </button>
        </form>
    </div>
</nav>
