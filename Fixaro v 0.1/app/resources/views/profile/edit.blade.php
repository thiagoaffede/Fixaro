<x-app-layout>
    <div class="mx-auto max-w-2xl space-y-4 px-4 pt-5 sm:px-6 sm:pt-8">
        <div class="mb-2 flex items-center gap-4">
            <x-avatar :name="Auth::user()->name" size="lg" />
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-ink-900">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h1>
                <p class="text-sm text-ink-400">{{ Auth::user()->role === 'client' ? 'Cliente' : 'Técnico' }} · {{ Auth::user()->phone }}</p>
            </div>
        </div>

        <div class="card p-5 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card p-5 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card p-5 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
