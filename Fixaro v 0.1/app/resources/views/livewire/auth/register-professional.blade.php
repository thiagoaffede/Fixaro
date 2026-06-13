<div>
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Registro de Profesional</h2>
    
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

        <!-- Birthdate -->
        <div class="mt-4">
            <x-input-label for="birthdate" :value="__('Fecha de Nacimiento')" />
            <x-text-input wire:model="birthdate" id="birthdate" class="block mt-1 w-full" type="date" required />
            <p class="text-xs text-gray-500 mt-1">Debes ser mayor de 18 años.</p>
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
        </div>

        <!-- License Number -->
        <div class="mt-4">
            <x-input-label for="license_number" :value="__('Matrícula (Opcional, pero recomendado)')" />
            <x-text-input wire:model="license_number" id="license_number" class="block mt-1 w-full" type="text" />
            <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
        </div>

        <!-- Professions -->
        <div class="mt-4">
            <x-input-label :value="__('¿Qué oficios realizas? (Elige de 1 a 3)')" />
            <div class="mt-2 grid grid-cols-2 gap-2">
                @foreach($availableProfessions as $profession)
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model="professions" value="{{ $profession }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-gray-600">{{ $profession }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('professions')" class="mt-2" />
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
