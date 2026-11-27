@props(['name' => '?', 'size' => 'md'])

@php
    $palette = ['bg-brand-100 text-brand-700', 'bg-urgent-100 text-urgent-700', 'bg-ok-100 text-ok-700', 'bg-violet-100 text-violet-700', 'bg-amber-100 text-amber-700'];
    $color = $palette[crc32((string) $name) % count($palette)];
    $box = $size === 'lg' ? 'h-14 w-14 text-xl' : ($size === 'sm' ? 'h-9 w-9 text-sm' : 'h-11 w-11 text-base');
@endphp

<span {{ $attributes->merge(['class' => "inline-flex shrink-0 items-center justify-center rounded-full font-extrabold $box $color"]) }}>
    {{ mb_strtoupper(mb_substr((string) $name, 0, 1)) }}
</span>
