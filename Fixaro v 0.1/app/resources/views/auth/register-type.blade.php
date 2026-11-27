<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold tracking-tight text-ink-900">¿Cómo querés usar Fixaro?</h1>
        <p class="mt-1 text-sm text-ink-500">Podés cambiarlo más adelante.</p>
    </div>

    <div class="space-y-3">
        <a href="{{ route('register.client') }}" class="group flex items-center gap-4 rounded-3xl p-4 ring-1 ring-inset ring-ink-200 transition hover:bg-urgent-50 hover:ring-urgent-200">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-urgent-500 text-white shadow-cta">
                <x-icon name="home" class="h-6 w-6" />
            </span>
            <span class="flex-1">
                <span class="block font-extrabold text-ink-900">Necesito un técnico</span>
                <span class="block text-sm text-ink-500">Pedí ayuda para tu casa, depto o local.</span>
            </span>
            <x-icon name="chevron-right" class="h-5 w-5 text-ink-300 transition group-hover:translate-x-0.5 group-hover:text-urgent-500" />
        </a>

        <a href="{{ route('register.professional') }}" class="group flex items-center gap-4 rounded-3xl p-4 ring-1 ring-inset ring-ink-200 transition hover:bg-brand-50 hover:ring-brand-200">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-600 text-white shadow-sm">
                <x-icon name="wrench" class="h-6 w-6" />
            </span>
            <span class="flex-1">
                <span class="block font-extrabold text-ink-900">Soy técnico</span>
                <span class="block text-sm text-ink-500">Recibí pedidos cerca tuyo y sumá clientes.</span>
            </span>
            <x-icon name="chevron-right" class="h-5 w-5 text-ink-300 transition group-hover:translate-x-0.5 group-hover:text-brand-600" />
        </a>
    </div>

    <p class="mt-6 text-center text-sm text-ink-500">
        ¿Ya tenés cuenta? <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700">Ingresá</a>
    </p>
</x-guest-layout>
