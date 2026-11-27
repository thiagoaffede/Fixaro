<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#0A5CFF">
<meta name="description" content="Fixaro: plomero, electricista, cerrajero o flete en Bahía Blanca. Pedí ayuda en 3 toques y te asignamos el técnico verificado más cercano.">

<title>{{ isset($title) ? $title.' · ' : '' }}{{ config('app.name', 'Fixaro') }}</title>

<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/favicon.svg">

<!-- Fuente -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
