<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- Use Vite when manifest contains compiled assets; otherwise fall back to CDN to avoid errors when Node/Vite build hasn't been run on this machine. --}}
        @php
            $manifestPath = public_path('build/manifest.json');
            $viteManifest = null;
            if (file_exists($manifestPath)) {
                try {
                    $viteManifest = json_decode(file_get_contents($manifestPath), true);
                } catch (\Exception $e) {
                    $viteManifest = null;
                }
            }
        @endphp

        @if (is_array($viteManifest) && array_key_exists('resources/css/app.css', $viteManifest))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            {{-- Vite build not found or manifest missing the expected entries. Use CDN fallback (Tailwind CDN) and skip app JS. --}}
            <script src="https://cdn.tailwindcss.com"></script>
            {{-- If you later install Node and run the Vite build, remove this fallback or it will be ignored when manifest exists. --}}
        @endif

    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex min-h-screen">
            {{-- Barra lateral fija --}}
             @include('layouts.sidebar')

            {{-- Contenido principal --}}
            <div class="flex-1 flex flex-col">
                {{-- Barra de navegación --}}
                <div class="sticky top-0 z-10">
                    @include('layouts.navigation')
                </div>

                {{-- Contenido principal --}}
                <main class="flex-1 p-8 bg-gray-50">
                    @if (isset($header))
                        <header class="bg-white shadow mb-4">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

            {{ $slot }}
        </main>
    </div>
</body>


</html>
