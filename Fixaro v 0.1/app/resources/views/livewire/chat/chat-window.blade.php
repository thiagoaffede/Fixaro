@php
    $chatResponse = \App\Models\Response::with(['professional.user', 'problem.client'])->find($this->responseId);
    $otherName = $isClient
        ? (optional(optional($chatResponse?->professional)->user)->name ?? 'Técnico')
        : (optional($chatResponse?->problem?->client)->name ?? 'Cliente');
@endphp

<div class="mx-auto -mb-6 max-w-3xl sm:mb-0 sm:px-6 sm:pt-6">
    <div class="flex h-[calc(100dvh-4rem)] flex-col overflow-hidden bg-white sm:h-[78vh] sm:rounded-4xl sm:shadow-card sm:ring-1 sm:ring-ink-100">
        {{-- Cabecera del chat --}}
        <div class="flex items-center gap-3 border-b border-ink-100 px-3 py-3 sm:px-4">
            <a href="{{ route('chats') }}" class="btn btn-ghost btn-sm px-2" aria-label="Volver">
                <x-icon name="arrow-left" class="h-5 w-5" />
            </a>
            <x-avatar :name="$otherName" />
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5">
                    <h1 class="truncate font-extrabold text-ink-900">{{ $otherName }}</h1>
                    @if($isClient)
                        <x-icon name="shield" class="h-4 w-4 text-brand-600" />
                    @endif
                </div>
                <p class="truncate text-xs text-ink-400">
                    {{ $problem->category }} · {{ $problem->address ?? 'Dirección no especificada' }}
                </p>
            </div>
            @if($isResolved)
                <span class="chip chip-ok"><x-icon name="check" class="h-3 w-3" /> Finalizado</span>
            @endif
                        @if($problem->lat && $problem->lng)
                            <div x-data="{ 
                                open: false,
                                map: null,
                                initMap() {
                                    if (this.map) {
                                        setTimeout(() => this.map.invalidateSize(), 200);
                                        return;
                                    }
                                    setTimeout(() => {
                                        const container = document.getElementById('chat-map-{{ $problem->id }}');
                                        if (!container) return;
                                        
                                        this.map = L.map(container).setView([{{ $problem->lat }}, {{ $problem->lng }}], 16);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '© OpenStreetMap'
                                        }).addTo(this.map);
                                        L.marker([{{ $problem->lat }}, {{ $problem->lng }}]).addTo(this.map)
                                            .bindPopup('Ubicación exacta del cliente')
                                            .openPopup();
                                    }, 300);
                                }
                            }">
                                <button @click="open = true; initMap()" type="button" class="btn btn-secondary btn-sm" aria-label="Ver mapa">
                                    <x-icon name="map" class="h-4 w-4" /> <span class="hidden sm:inline">Mapa</span>
                                </button>
 
                                {{-- Map Modal --}}
                                <div x-show="open" 
                                     x-cloak
                                     wire:key="map-modal-{{ $problem->id }}"
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true">
                                    <div class="flex min-h-screen items-end justify-center sm:items-center sm:p-4">
                                        <div class="fixed inset-0 bg-ink-900/60 backdrop-blur-sm" @click="open = false"></div>
                                        <div class="relative w-full overflow-hidden rounded-t-4xl bg-white p-5 text-left shadow-lift sm:max-w-2xl sm:rounded-4xl sm:p-6">
                                            <div class="mb-4 flex items-center justify-between">
                                                <h3 class="text-lg font-extrabold text-ink-900">Ubicación del trabajo</h3>
                                                <button @click="open = false" class="btn btn-ghost btn-sm" aria-label="Cerrar"><x-icon name="x" class="h-5 w-5" /></button>
                                            </div>
                                            <div id="chat-map-{{ $problem->id }}" wire:ignore class="z-0 h-96 w-full rounded-3xl"></div>
                                            <p class="mt-4 flex items-center gap-2 text-sm font-semibold text-ink-700"><x-icon name="map-pin" class="h-4 w-4 text-brand-600" /> {{ $problem->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
        </div>

        {{-- Mensajes --}}
        <div class="flex flex-1 flex-col gap-2 overflow-y-auto bg-ink-50 px-3 py-4 sm:px-5" wire:poll.2s="loadMessages">
            @if(count($messages) === 0)
                <div class="m-auto max-w-xs text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-brand-600 shadow-card"><x-icon name="chat" class="h-6 w-6" /></span>
                    <p class="mt-3 font-bold text-ink-900">Coordiná el trabajo por acá</p>
                    <p class="mt-1 text-sm text-ink-400">Horario, acceso, materiales. Todo queda registrado.</p>
                </div>
            @else
                @foreach($messages as $msg)
                    @if($msg['sender_id'] == Auth::id())
                        <div class="flex justify-end">
                            <div class="max-w-[80%] break-words rounded-3xl rounded-br-lg bg-brand-600 px-4 py-2.5 text-white shadow-sm">
                                <p class="text-sm">{{ $msg['message'] }}</p>
                                <span class="mt-0.5 block text-right text-[10px] font-medium text-brand-100">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="max-w-[80%] break-words rounded-3xl rounded-bl-lg bg-white px-4 py-2.5 text-ink-900 shadow-sm ring-1 ring-ink-100">
                                <p class="text-sm">{{ $msg['message'] }}</p>
                                <span class="mt-0.5 block text-[10px] font-medium text-ink-400">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        {{-- Entrada --}}
        @if(!$isResolved)
            <div class="border-t border-ink-100 bg-white p-3">
                <div class="flex items-center gap-2">
                    <input type="text" wire:model="newMessage"
                           wire:keydown.enter="sendMessage"
                           wire:loading.attr="disabled"
                           wire:target="sendMessage"
                           class="field flex-1 rounded-full bg-ink-50 ring-transparent focus:bg-white"
                           placeholder="Escribí un mensaje…" autocomplete="off">
                    <button type="button"
                            wire:click="sendMessage"
                            wire:loading.attr="disabled"
                            wire:target="sendMessage"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white shadow-sm transition hover:bg-brand-700 active:scale-95 disabled:opacity-50"
                            aria-label="Enviar">
                        <span wire:loading.remove wire:target="sendMessage"><x-icon name="send" class="h-5 w-5" /></span>
                        <svg wire:loading wire:target="sendMessage" class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                </div>

                        @if($isClient)
                            <div class="mt-2" x-data="{ open: false }">
                                <button x-on:click="open = true" type="button" class="flex w-full items-center justify-center gap-1.5 rounded-xl py-2 text-xs font-bold text-ok-700 transition hover:bg-ok-50">
                                    <x-icon name="check-circle" class="h-4 w-4" /> ¿Ya terminó? Finalizar trabajo
                                </button>

                                <div x-show="open" x-cloak style="display:none" class="fixed inset-0 z-50 flex items-end justify-center sm:items-center sm:p-4">
                                    <div class="fixed inset-0 bg-ink-900/60 backdrop-blur-sm" x-on:click="open = false"></div>
                                    <div class="relative z-10 w-full rounded-t-4xl bg-white p-6 shadow-lift sm:max-w-md sm:rounded-4xl">
                                        <div class="mb-5 text-center">
                                            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-ok-50 text-ok-600"><x-icon name="check-circle" class="h-7 w-7" /></span>
                                            <h3 class="mt-3 text-xl font-extrabold tracking-tight text-ink-900">Finalizar trabajo</h3>
                                            <p class="mt-1 text-sm text-ink-500">¿Cómo te fue con {{ $otherName }}?</p>
                                        </div>

                                        <div class="mb-4 flex items-center justify-center gap-1.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" wire:click="setRating({{ $i }})" class="rounded-lg p-0.5 focus:outline-none focus-visible:ring-4 focus-visible:ring-amber-100" aria-label="{{ $i }} estrellas">
                                                    <svg class="h-10 w-10 {{ $rating >= $i ? 'text-amber-400' : 'text-ink-200' }} transition hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                </button>
                                            @endfor
                                        </div>

                                        <textarea wire:model="reviewComment" rows="3" class="field mb-5 resize-none" placeholder="Contá cómo fue (opcional)"></textarea>

                                        <button wire:click="finishAndReview" type="button" class="btn btn-success btn-lg w-full">
                                            Finalizar y calificar
                                        </button>
                                        <button x-on:click="open = false" type="button" class="btn btn-ghost mt-2 w-full">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        @endif
            </div>
        @else
            <div class="flex items-center justify-center gap-2 border-t border-ink-100 bg-ink-50 p-4 text-sm font-semibold text-ink-500">
                <x-icon name="check-circle" class="h-4 w-4 text-ok-600" /> Este trabajo ya está finalizado.
            </div>
        @endif
    </div>
</div>
