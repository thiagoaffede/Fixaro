{{-- Mensajes flash de sesión (success / error) --}}
@if (session('success'))
    <div {{ $attributes->merge(['class' => 'alert-ok']) }} role="status">
        <x-icon name="check-circle" class="h-5 w-5" />
        <span>{{ session('success') }}</span>
    </div>
@endif
@if (session('error'))
    <div {{ $attributes->merge(['class' => 'alert-error']) }} role="alert">
        <x-icon name="x" class="h-5 w-5" />
        <span>{{ session('error') }}</span>
    </div>
@endif
