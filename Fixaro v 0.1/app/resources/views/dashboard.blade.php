<x-app-layout>
    @php $user = Auth::user(); @endphp

    <div class="mx-auto max-w-5xl space-y-8 px-4 pt-5 sm:px-6 sm:pt-8">
        @if($user->role === 'client')
            {{-- Hero de pedido --}}
            <section class="relative overflow-hidden rounded-4xl bg-gradient-to-br from-brand-600 to-brand-800 p-6 text-white shadow-lift sm:p-8">
                <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/10"></div>
                <div class="pointer-events-none absolute -bottom-20 right-10 h-40 w-40 rounded-full bg-urgent-500/30 blur-2xl"></div>

                <p class="text-sm font-semibold text-brand-100">Hola, {{ $user->name }} 👋</p>
                <h1 class="mt-1 max-w-md text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">¿Qué se rompió hoy?</h1>
                <p class="mt-2 max-w-md text-sm text-brand-100">Contanos el problema y te asignamos un técnico verificado cerca tuyo.</p>

                <a href="{{ route('client.problem.new') }}" class="btn btn-urgent btn-lg mt-6 w-full sm:w-auto">
                    <x-icon name="bolt" class="h-5 w-5" /> Pedir ayuda ahora
                </a>

                <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 text-xs font-semibold text-brand-100">
                    <span class="flex items-center gap-1.5"><x-icon name="shield" class="h-4 w-4" /> Técnicos verificados</span>
                    <span class="flex items-center gap-1.5"><x-icon name="clock" class="h-4 w-4" /> Respuesta en minutos</span>
                </div>
            </section>

            {{-- Rubros --}}
            <section>
                <h2 class="section-title mb-3">¿Con qué te ayudamos?</h2>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach([
                        ['Plomero', 'Plomería', 'Pérdidas, canillas, cloacas'],
                        ['Electricista', 'Electricidad', 'Cortes, térmicas, enchufes'],
                        ['Cerrajero', 'Cerrajería', 'Aperturas y cerraduras'],
                        ['Flete', 'Fletes', 'Mudanzas y traslados'],
                    ] as [$cat, $label, $hint])
                        <a href="{{ route('client.problem.new') }}" class="card group flex flex-col gap-3 p-4 transition hover:-translate-y-0.5 hover:shadow-lift active:scale-[0.98]">
                            <x-trade-icon :category="$cat" />
                            <div>
                                <div class="font-bold text-ink-900">{{ $label }}</div>
                                <div class="mt-0.5 text-xs leading-snug text-ink-400">{{ $hint }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            @livewire('client.client-dashboard')

        @elseif($user->role === 'professional')
            <section class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-ink-400">Hola, {{ $user->name }} 👋</p>
                    <h1 class="text-2xl font-extrabold tracking-tight text-ink-900 sm:text-3xl">Tu panel de trabajos</h1>
                </div>
                <a href="{{ route('chats') }}" class="btn btn-secondary hidden sm:inline-flex">
                    <x-icon name="chat" class="h-4 w-4" /> Mensajes
                </a>
            </section>

            @livewire('professional.problem-feed')
        @endif
    </div>
</x-app-layout>
