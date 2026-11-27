<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-ink-900">Hola de nuevo</h1>
        <p class="mt-1 text-sm text-ink-500">Ingresá con tu celular para pedir o recibir trabajos.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="phone" :value="__('Celular')" />
            <x-text-input id="phone" type="tel" inputmode="tel" name="phone" :value="old('phone')" placeholder="291 555 0000" required autofocus autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Contraseña')" />
                @if (Route::has('password.request'))
                    <a class="mb-1.5 text-xs font-bold text-brand-600 hover:text-brand-700" href="{{ route('password.request') }}">¿La olvidaste?</a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-200" name="remember">
            <span class="text-sm text-ink-600">{{ __('Recordarme') }}</span>
        </label>

        <button type="submit" class="btn btn-primary btn-lg w-full">{{ __('Ingresar') }}</button>

        <p class="text-center text-sm text-ink-500">
            ¿Primera vez? <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-700">Creá tu cuenta</a>
        </p>
    </form>
</x-guest-layout>
