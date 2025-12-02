<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ConnectCat - Red Social para Gatos</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap');
            body {
                font-family: 'Poppins', sans-serif;
            }
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .float-animation {
                animation: float 3s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-purple-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
        <header class="w-full backdrop-blur-sm bg-white/70 dark:bg-gray-900/70 border-b border-purple-200 dark:border-purple-900/50">
            @if (Route::has('login'))
                <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="ConnectCat Logo" class="h-10 w-10">
                        <span class="text-2xl font-bold gradient-text">ConnectCat</span>
                    </div>
                    @auth
                        <div class="flex items-center gap-3">
                            <a href="{{ route('feed') }}" class="px-4 py-2 text-purple-700 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100 font-semibold">
                                Ir al Feed
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 font-semibold">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Logo Animado -->
                <div class="mb-8 float-animation">
                    <img src="{{ asset('images/logo.png') }}" alt="ConnectCat Logo" class="h-32 w-32 mx-auto drop-shadow-2xl">
                </div>

                <!-- Título Principal -->
                @auth
                    <h1 class="text-5xl md:text-6xl font-bold mb-6">
                        ¡Hola, <span class="gradient-text">{{ Auth::user()->name }}</span>!
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                        Ya tienes una sesión activa. ¿Quieres continuar al feed?
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                        <a href="{{ route('feed') }}" class="px-8 py-4 gradient-bg text-white rounded-full hover:shadow-2xl transform hover:scale-105 transition font-semibold text-lg w-64">
                            Ir a mi Feed
                        </a>
                    </div>
                @else
                    <h1 class="text-6xl md:text-7xl font-bold mb-6">
                        Bienvenido a <span class="gradient-text">ConnectCat</span>
                    </h1>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                        <a href="{{ route('register') }}" class="px-8 py-4 gradient-bg text-white rounded-full hover:shadow-2xl transform hover:scale-105 transition font-semibold text-lg w-64">
                            Únete Ahora
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white dark:bg-gray-800 text-purple-700 dark:text-purple-300 border-2 border-purple-500 rounded-full hover:shadow-lg transform hover:scale-105 transition font-semibold text-lg w-64">
                            Iniciar Sesión
                        </a>
                    </div>
                @endauth

            </div>
        </main>

        <footer class="border-t border-purple-200 dark:border-purple-900/50 backdrop-blur-sm bg-white/70 dark:bg-gray-900/70 p-6 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; 2024 <span class="font-semibold text-purple-700 dark:text-purple-300">ConnectCat</span>. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>
