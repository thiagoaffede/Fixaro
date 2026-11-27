@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-2 rounded-xl bg-brand-50 px-3 py-2 text-sm font-bold text-brand-700 transition'
            : 'inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-ink-500 hover:bg-ink-100 hover:text-ink-900 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
