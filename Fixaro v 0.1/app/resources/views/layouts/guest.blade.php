<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials-head')
    </head>
    <body class="min-h-screen">
        <div class="relative flex min-h-screen flex-col items-center overflow-hidden px-4 pb-10 pt-8 sm:justify-center sm:pt-0">
            {{-- Fondo de marca --}}
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-72 bg-gradient-to-b from-brand-600 to-brand-700 sm:h-96"></div>
            <div class="pointer-events-none absolute -right-24 -top-24 -z-10 h-72 w-72 rounded-full bg-white/10"></div>

            <a href="/" class="mb-6">
                <x-brand dark />
            </a>

            <div class="card w-full p-6 sm:max-w-md sm:p-8">
                {{ $slot }}
            </div>

            <p class="mt-6 flex items-center gap-1.5 text-xs font-medium text-ink-400">
                <x-icon name="shield" class="h-4 w-4" /> Técnicos verificados en Bahía Blanca
            </p>
        </div>
    </body>
</html>
