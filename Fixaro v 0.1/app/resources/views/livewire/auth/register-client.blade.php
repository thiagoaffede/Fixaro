<div>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-ink-900">Creá tu cuenta</h1>
        <p class="mt-1 text-sm text-ink-500">Pedí ayuda en minutos cuando la necesites.</p>
    </div>
    
    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input wire:model="name" id="name" type="text" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Surname -->
        <div>
            <x-input-label for="surname" :value="__('Apellido')" />
            <x-text-input wire:model="surname" id="surname" type="text" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Celular')" />
            <x-text-input wire:model="phone" id="phone" type="tel" inputmode="tel" placeholder="291 555 0000" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email (opcional)')" />
            <x-text-input wire:model="email" id="email" type="email" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input wire:model="password" id="password" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Repetí la contraseña')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="btn btn-primary btn-lg w-full">{{ __('Crear cuenta') }}</button>
            <p class="mt-4 text-center text-sm text-ink-500">
                ¿Ya tenés cuenta? <a class="font-bold text-brand-600 hover:text-brand-700" href="{{ route('login') }}">Ingresá</a>
            </p>
        </div>
    </form>
</div>
