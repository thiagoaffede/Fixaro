<div>
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Registro de Cliente</h2>
    
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Surname -->
        <div class="mt-4">
            <x-input-label for="surname" :value="__('Apellido')" />
            <x-text-input wire:model="surname" id="surname" class="block mt-1 w-full" type="text" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Teléfono / Celular (Obligatorio)')" />
            <x-text-input wire:model="phone" id="phone" class="block mt-1 w-full" type="text" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email (Opcional)')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarme') }}
            </x-primary-button>
        </div>
    </form>
</div>
