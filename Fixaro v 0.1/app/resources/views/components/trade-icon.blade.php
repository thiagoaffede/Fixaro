@props(['category' => null, 'size' => 'md'])

{{-- Ícono de rubro en un cuadrado de color. Mapea categorías actuales y futuras. --}}
@php
    $map = [
        'Plomero' => ['droplet', 'bg-sky-100 text-sky-700'],
        'Plomería' => ['droplet', 'bg-sky-100 text-sky-700'],
        'Gasista' => ['flame', 'bg-orange-100 text-orange-700'],
        'Electricista' => ['bolt', 'bg-amber-100 text-amber-700'],
        'Electricidad' => ['bolt', 'bg-amber-100 text-amber-700'],
        'Cerrajero' => ['key', 'bg-violet-100 text-violet-700'],
        'Cerrajería' => ['key', 'bg-violet-100 text-violet-700'],
        'Flete' => ['truck', 'bg-emerald-100 text-emerald-700'],
        'Fletes' => ['truck', 'bg-emerald-100 text-emerald-700'],
    ];
    [$icon, $colors] = $map[$category] ?? ['wrench', 'bg-brand-50 text-brand-700'];
    [$box, $ico] = match ($size) {
        'lg' => ['h-14 w-14 rounded-2xl', 'h-7 w-7'],
        'sm' => ['h-9 w-9 rounded-xl', 'h-4 w-4'],
        'xs' => ['h-6 w-6 rounded-full', 'h-3 w-3'],
        default => ['h-11 w-11 rounded-2xl', 'h-5 w-5'],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center $box $colors"]) }}>
    <x-icon :name="$icon" class="{{ $ico }}" />
</span>
