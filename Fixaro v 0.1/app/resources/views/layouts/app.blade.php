<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials-head')

        <!-- Leaflet.js -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    </head>
    @php
        // Pantallas de foco (pedido y chat) ocultan la barra inferior
        $immersive = request()->routeIs('chat', 'client.problem.new');
    @endphp
    <body class="min-h-screen">
        @include('layouts.navigation')

        <!-- Encabezado de página -->
        @isset($header)
            <header class="mx-auto max-w-5xl px-4 pt-5 sm:px-6 sm:pt-8">
                {{ $header }}
            </header>
        @endisset

        <!-- Contenido (deja lugar para la barra inferior en el celu) -->
        <main class="{{ $immersive ? 'pb-6' : 'pb-28' }} sm:pb-12">
            {{ $slot }}
        </main>

        @unless($immersive)
            @include('layouts.bottom-nav')
        @endunless
    </body>
</html>
