<section>
    <div class="mb-3 flex items-end justify-between">
        <h2 class="section-title">Tus pedidos</h2>
        @if($problems->isNotEmpty())
            <span class="text-xs font-semibold text-ink-400">{{ $problems->count() }} en total</span>
        @endif
    </div>

    <x-flash class="mb-4" />

    @if($problems->isEmpty())
        <div class="card flex flex-col items-center px-6 py-10 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                <x-icon name="inbox" class="h-7 w-7" />
            </span>
            <h3 class="mt-4 font-bold text-ink-900">Todavía no pediste ayuda</h3>
            <p class="mt-1 max-w-xs text-sm text-ink-400">Cuando publiques un problema, vas a ver acá las ofertas de los técnicos.</p>
            <a href="{{ route('client.problem.new') }}" class="btn btn-urgent mt-5">
                <x-icon name="plus" class="h-4 w-4" /> Pedir ayuda
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($problems as $problem)
                @php
                    $pending = $problem->responses->where('status', 'pending');
                    $status = [
                        'open' => ['Buscando técnico', 'chip-brand'],
                        'quoted' => ['Con ofertas', 'chip-brand'],
                        'assigned' => ['Técnico asignado', 'chip-ok'],
                        'resolved' => ['Resuelto', 'chip-muted'],
                    ][$problem->status] ?? [ucfirst($problem->status), 'chip-muted'];
                @endphp

                <article wire:key="problem-{{ $problem->id }}" class="card overflow-hidden {{ $problem->status === 'resolved' ? 'opacity-80' : '' }}">
                    {{-- Cabecera del pedido --}}
                    <div class="flex gap-3 p-4 sm:p-5">
                        <x-trade-icon :category="$problem->category" />
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="font-bold text-ink-900">{{ $problem->category }}</span>
                                <span class="chip {{ $status[1] }}">
                                    @if($problem->status === 'open')
                                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-brand-500"></span>
                                    @endif
                                    {{ $status[0] }}
                                </span>
                                @if($problem->is_urgent && $problem->status !== 'resolved')
                                    <span class="chip chip-urgent"><x-icon name="bolt" class="h-3 w-3" /> Urgente</span>
                                @endif
                            </div>
                            <p class="mt-1.5 line-clamp-2 text-sm text-ink-600">{{ $problem->description }}</p>
                            <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-ink-400">
                                <span class="flex items-center gap-1"><x-icon name="clock" class="h-3.5 w-3.5" /> {{ $problem->created_at->diffForHumans() }}</span>
                                @if($problem->location)
                                    <span class="flex items-center gap-1"><x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $problem->location }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Ofertas / estado --}}
                    @if($problem->status === 'open')
                        <div class="border-t border-ink-100 bg-ink-50/60 p-4 sm:p-5">
                            @if($pending->isEmpty())
                                <div class="flex items-center gap-3 text-sm text-ink-500">
                                    <span class="relative flex h-3 w-3">
                                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-400 opacity-60"></span>
                                        <span class="relative inline-flex h-3 w-3 rounded-full bg-brand-500"></span>
                                    </span>
                                    Avisamos a los técnicos de tu zona. Te llegan las ofertas acá.
                                </div>
                            @else
                                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-ink-400">{{ $pending->count() }} {{ $pending->count() === 1 ? 'oferta recibida' : 'ofertas recibidas' }}</h3>
                                <div class="space-y-3">
                                    @foreach($pending as $response)
                                        <div wire:key="offer-{{ $response->id }}" class="rounded-2xl bg-white p-4 ring-1 ring-ink-100">
                                            <div class="flex items-start gap-3">
                                                <x-avatar :name="$response->professional->user->name" />
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="truncate font-bold text-ink-900">{{ $response->professional->user->name }} {{ $response->professional->user->surname }}</span>
                                                        <x-icon name="shield" class="h-4 w-4 text-brand-600" title="Verificado" />
                                                    </div>
                                                    <p class="mt-0.5 flex items-center gap-1 text-xs font-medium text-ink-500">
                                                        <x-icon name="clock" class="h-3.5 w-3.5" /> {{ $response->time_estimate }}
                                                    </p>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-lg font-extrabold tracking-tight text-ink-900">${{ number_format($response->price_estimate, 0, ',', '.') }}</div>
                                                    <div class="text-[11px] font-medium text-ink-400">estimado</div>
                                                </div>
                                            </div>
                                            @if($response->message)
                                                <p class="mt-3 rounded-xl bg-ink-50 px-3 py-2 text-sm text-ink-600">“{{ $response->message }}”</p>
                                            @endif
                                            <button wire:click="acceptOffer({{ $response->id }})" wire:loading.attr="disabled" class="btn btn-primary mt-3 w-full">
                                                <x-icon name="check" class="h-4 w-4" /> Aceptar oferta
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    @elseif($problem->status === 'assigned')
                        @php $accepted = $problem->responses->where('status', 'accepted')->first(); @endphp
                        @if($accepted)
                            <div class="flex items-center gap-3 border-t border-ok-100 bg-ok-50/60 p-4 sm:p-5">
                                <x-avatar :name="$accepted->professional->user->name" />
                                <div class="min-w-0 flex-1">
                                    <div class="truncate font-bold text-ink-900">{{ $accepted->professional->user->name }} {{ $accepted->professional->user->surname }}</div>
                                    <p class="text-xs font-medium text-ink-500">${{ number_format($accepted->price_estimate, 0, ',', '.') }} · {{ $accepted->time_estimate }}</p>
                                </div>
                                <a href="{{ route('chat', ['responseId' => $accepted->id]) }}" class="btn btn-success btn-sm relative">
                                    <x-icon name="chat" class="h-4 w-4" /> Chat
                                    @if($accepted->unreadMessagesCount(Auth::id()) > 0)
                                        <span class="absolute -right-1 -top-1 flex h-3 w-3">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-urgent-400 opacity-75"></span>
                                            <span class="relative inline-flex h-3 w-3 rounded-full bg-urgent-500 ring-2 ring-white"></span>
                                        </span>
                                    @endif
                                </a>
                            </div>
                        @endif

                    @elseif($problem->status === 'resolved')
                        <div class="flex items-center gap-2 border-t border-ink-100 px-4 py-3 text-sm font-semibold text-ok-700 sm:px-5">
                            <x-icon name="check-circle" class="h-4 w-4" /> Trabajo completado
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>
