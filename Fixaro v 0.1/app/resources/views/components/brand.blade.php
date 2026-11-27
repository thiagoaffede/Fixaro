@props(['dark' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    <x-application-logo class="h-9 w-9" />
    <span class="text-xl font-extrabold tracking-tight {{ $dark ? 'text-white' : 'text-ink-900' }}">fixaro</span>
</span>
