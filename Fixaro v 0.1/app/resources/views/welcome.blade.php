@php
    $ctaUrl = auth()->check() ? route('dashboard') : route('register.client');
    $trades = [
        ['Plomero', 'Plomería', 'Pérdidas, canillas, termotanques y destapes.'],
        ['Electricista', 'Electricidad', 'Cortes de luz, térmicas que saltan, enchufes.'],
        ['Cerrajero', 'Cerrajería', 'Te quedaste afuera o se trabó la cerradura.'],
        ['Flete', 'Fletes', 'Mudanzas chicas, muebles y traslados.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials-head', ['title' => null])
    </head>
    <body class="bg-white">
        {{-- Barra superior --}}
        <header class="absolute inset-x-0 top-0 z-30">
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:h-20 sm:px-6">
                <a href="/" aria-label="Fixaro"><x-brand dark /></a>
                <nav class="flex items-center gap-1 sm:gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-sm bg-white text-brand-700 hover:bg-brand-50">Ir a mi panel</a>
                    @else
                        <a href="{{ route('register.professional') }}" class="btn btn-sm hidden text-white/90 hover:bg-white/10 hover:text-white sm:inline-flex">Soy técnico</a>
                        <a href="{{ route('login') }}" class="btn btn-sm bg-white/15 text-white ring-1 ring-inset ring-white/25 hover:bg-white/25">Ingresar</a>
                    @endauth
                </nav>
            </div>
        </header>

        {{-- Hero --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-brand-600 via-brand-700 to-brand-900 pb-16 pt-24 text-white sm:pb-24 sm:pt-32">
            <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10"></div>
            <div class="pointer-events-none absolute -bottom-40 -left-20 h-96 w-96 rounded-full bg-urgent-500/20 blur-3xl"></div>
            {{-- Grilla tipo mapa --}}
            <div class="pointer-events-none absolute inset-0 opacity-[0.07]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 44px 44px;"></div>

            <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2">
                <div>
                    <span class="chip bg-white/15 text-white ring-1 ring-inset ring-white/20">
                        <span class="h-2 w-2 rounded-full bg-urgent-500 ring-2 ring-urgent-200/50"></span> Ya en Bahía Blanca
                    </span>
                    <h1 class="mt-5 text-4xl font-extrabold leading-[1.05] tracking-tight sm:text-6xl">
                        ¿Se rompió algo?<br>
                        <span class="text-urgent-200">Un técnico en camino,</span> ya.
                    </h1>
                    <p class="mt-5 max-w-lg text-base text-brand-100 sm:text-lg">
                        Plomero, electricista, cerrajero o flete. Pedí en 3 toques y te asignamos el técnico verificado más cercano, con precio claro antes de que llegue.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ $ctaUrl }}" class="btn btn-urgent btn-lg">
                            <x-icon name="bolt" class="h-5 w-5" /> Pedir ayuda ahora
                        </a>
                        <a href="#como-funciona" class="btn btn-lg bg-white/10 text-white ring-1 ring-inset ring-white/25 hover:bg-white/20">
                            Cómo funciona
                        </a>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-x-6 gap-y-2 text-sm font-semibold text-brand-100">
                        <span class="flex items-center gap-2"><x-icon name="shield" class="h-4 w-4" /> Técnicos verificados</span>
                        <span class="flex items-center gap-2"><x-icon name="clock" class="h-4 w-4" /> Respuesta en minutos</span>
                        <span class="flex items-center gap-2"><x-icon name="lock" class="h-4 w-4" /> Pago protegido</span>
                    </div>
                </div>

                {{-- Mock de la app --}}
                <div class="relative mx-auto w-full max-w-sm lg:mr-0">
                    <div class="rounded-[2.5rem] bg-ink-900/40 p-2.5 shadow-2xl ring-1 ring-white/20 backdrop-blur">
                        <div class="overflow-hidden rounded-[2rem] bg-ink-50 text-ink-900">
                            {{-- mapa --}}
                            <div class="relative h-52 bg-[#E8EEF7]">
                                <div class="absolute inset-0" style="background-image: linear-gradient(#fff 3px, transparent 3px), linear-gradient(90deg, #fff 3px, transparent 3px); background-size: 52px 52px; background-position: 12px 20px;"></div>
                                <div class="absolute left-[18%] top-[56%] h-1 w-[52%] rotate-[-18deg] rounded-full bg-brand-600/70"></div>
                                <span class="absolute left-[16%] top-[60%] flex h-9 w-9 items-center justify-center rounded-full bg-white shadow-lift ring-4 ring-brand-200">
                                    <x-icon name="truck" class="h-4 w-4 text-brand-600" />
                                </span>
                                <span class="absolute right-[24%] top-[30%] flex h-10 w-10 items-center justify-center">
                                    <span class="absolute h-10 w-10 animate-ping rounded-full bg-urgent-400/40"></span>
                                    <span class="relative h-4 w-4 rounded-full bg-urgent-500 ring-4 ring-white"></span>
                                </span>
                                <span class="absolute left-3 top-3 chip bg-white text-ink-700 shadow-card">
                                    <x-icon name="map-pin" class="h-3.5 w-3.5 text-urgent-500" /> Barrio Universitario
                                </span>
                            </div>
                            {{-- tarjeta de técnico --}}
                            <div class="space-y-3 p-4">
                                <div class="flex items-center gap-2">
                                    <span class="chip chip-ok"><x-icon name="check" class="h-3 w-3" /> Técnico asignado</span>
                                    <span class="ml-auto text-xs font-bold text-ink-400">Llega en 18 min</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-2xl bg-white p-3 shadow-card">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-100 text-base font-extrabold text-amber-700">M</span>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-1 text-sm font-bold">Martín R. <x-icon name="shield" class="h-3.5 w-3.5 text-brand-600" /></div>
                                        <div class="flex items-center gap-1 text-xs text-ink-400">
                                            <svg class="h-3.5 w-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            4,9 · Electricista
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-base font-extrabold">$15.000</div>
                                        <div class="text-[10px] font-semibold text-ink-400">precio base</div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <span class="btn btn-secondary btn-sm flex-1"><x-icon name="phone" class="h-4 w-4" /> Llamar</span>
                                    <span class="btn btn-primary btn-sm flex-1"><x-icon name="chat" class="h-4 w-4" /> Chat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Rubros --}}
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
            <p class="text-sm font-bold uppercase tracking-wider text-urgent-500">Rubros</p>
            <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">Las urgencias de todos los días</h2>
            <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                @foreach($trades as [$cat, $label, $hint])
                    <a href="{{ $ctaUrl }}" class="card group flex flex-col gap-4 p-5 transition hover:-translate-y-1 hover:shadow-lift">
                        <x-trade-icon :category="$cat" size="lg" />
                        <div>
                            <h3 class="text-lg font-extrabold text-ink-900">{{ $label }}</h3>
                            <p class="mt-1 text-sm leading-snug text-ink-500">{{ $hint }}</p>
                        </div>
                        <span class="mt-auto flex items-center gap-1 text-sm font-bold text-brand-600">Pedir <x-icon name="arrow-right" class="h-4 w-4 transition group-hover:translate-x-0.5" /></span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Cómo funciona --}}
        <section id="como-funciona" class="bg-ink-50 py-16 sm:py-24">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <p class="text-sm font-bold uppercase tracking-wider text-urgent-500">Cómo funciona</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">Tres toques y listo</h2>
                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach([
                        ['camera', 'Contá qué pasó', 'Elegí el rubro y sacá una foto. Con eso el técnico ya tiene un diagnóstico.'],
                        ['map-pin', 'Te asignamos al más cercano', 'Un técnico verificado de tu zona acepta el pedido y ves cuándo llega.'],
                        ['shield', 'Pagás cuando está resuelto', 'Precio claro antes de empezar y pago protegido por Fixaro.'],
                    ] as $i => [$icon, $title, $text])
                        <div class="card relative p-6">
                            <span class="absolute right-5 top-4 text-6xl font-extrabold text-ink-100">{{ $i + 1 }}</span>
                            <span class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-600 text-white">
                                <x-icon :name="$icon" class="h-6 w-6" />
                            </span>
                            <h3 class="relative mt-5 text-lg font-extrabold text-ink-900">{{ $title }}</h3>
                            <p class="relative mt-1.5 text-sm text-ink-500">{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Para quién --}}
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-urgent-500">Pensado para vos</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl">Cuando no tenés a quién llamar</h2>
                    <p class="mt-4 text-ink-500">Si te mudaste a estudiar, vivís solo o tenés un local que no puede cerrar, no hace falta pedir contactos ni esperar presupuestos.</p>
                </div>
                <div class="grid gap-3">
                    @foreach([
                        ['user', 'Estudiantes', 'Recién llegados al centro o al Universitario.'],
                        ['home', 'Gente que vive sola', 'Alguien de confianza, con nombre, foto y reseñas.'],
                        ['briefcase', 'Comercios', 'Resolvé rápido para no perder un día de ventas.'],
                    ] as [$icon, $title, $text])
                        <div class="flex items-center gap-4 rounded-3xl bg-ink-50 p-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-urgent-500 shadow-card">
                                <x-icon :name="$icon" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-extrabold text-ink-900">{{ $title }}</h3>
                                <p class="text-sm text-ink-500">{{ $text }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA técnicos --}}
        <section class="px-4 pb-16 sm:px-6 sm:pb-24">
            <div class="relative mx-auto max-w-6xl overflow-hidden rounded-4xl bg-ink-900 p-8 text-white sm:p-12">
                <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-brand-600/40 blur-2xl"></div>
                <div class="relative flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">¿Sos técnico en Bahía Blanca?</h2>
                        <p class="mt-2 max-w-lg text-ink-300">Recibí pedidos cerca tuyo, sin comisiones por trabajo. Sumate al grupo de técnicos verificados.</p>
                    </div>
                    <a href="{{ route('register.professional') }}" class="btn btn-lg shrink-0 bg-white text-ink-900 hover:bg-ink-100">
                        <x-icon name="wrench" class="h-5 w-5" /> Quiero sumarme
                    </a>
                </div>
            </div>
        </section>

        <footer class="border-t border-ink-100">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 py-8 text-sm text-ink-400 sm:flex-row sm:px-6">
                <x-brand />
                <p>Hecho en Bahía Blanca · © {{ date('Y') }} Fixaro</p>
            </div>
        </footer>
    </body>
</html>
