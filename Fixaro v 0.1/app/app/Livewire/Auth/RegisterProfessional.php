<?php

namespace App\Livewire\Auth;

use App\Models\Professional;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class RegisterProfessional extends Component
{
    public $name = '';
    public $surname = '';
    public $phone = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $birthdate = '';
    public $license_number = '';
    public $professions = [];

    public $availableProfessions = [
        'Plomero', 'Electricista', 'Gasista', 'Albañil', 'Pintor', 'Carpintero', 'Cerrajero', 'Técnico AC'
    ];

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birthdate' => ['required', 'date', 'before:18 years ago'], // Must be at least 18
            'license_number' => ['nullable', 'string', 'max:255', 'unique:'.Professional::class],
            'professions' => ['required', 'array', 'min:1', 'max:3'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?: null,
                'password' => Hash::make($validated['password']),
                'role' => 'professional',
            ]);

            Professional::create([
                'user_id' => $user->id,
                'birthdate' => $validated['birthdate'],
                'license_number' => $validated['license_number'] ?: null,
                'professions' => $validated['professions'],
            ]);

            Auth::login($user);
        });

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register-professional')->layout('layouts.guest');
    }
}
