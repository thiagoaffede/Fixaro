<div x-data="feedManager()" class="space-y-8">
    @php
        $avgRating = $completedJobs->map(fn ($j) => optional($j->problem->reviews->first())->rating)->filter()->avg();
    @endphp

    {{-- Resumen --}}
    <div class="grid grid-cols-3 gap-3">
        <div class="card p-4">
            <div class="text-2xl font-extrabold tracking-tight text-ink-900">{{ $problems->count() }}</div>
            <div class="text-xs font-semibold text-ink-400">Pedidos cerca</div>
        </div>
        <div class="card p-4">
            <div class="text-2xl font-extrabold tracking-tight text-ok-600">{{ $activeJobs->count() }}</div>
            <div class="text-xs font-semibold text-ink-400">En curso</div>
        </div>
        <div class="card p-4">
            <div class="flex items-center gap-1 text-2xl font-extrabold tracking-tight text-ink-900">
                {{ $avgRating ? number_format($avgRating, 1, ',', '') : '–' }}
                <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
            <div class="text-xs font-semibold text-ink-400">{{ $completedJobs->count() }} terminados</div>
        </div>
    </div>

    <x-flash />

    {{-- Trabajos activos --}}
    @if($activeJobs->isNotEmpty())
        <section>
            <h2 class="section-title mb-3 flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-ok-500"></span> Trabajos en curso
            </h2>
            <div class="space-y-3">
                @foreach($activeJobs as $job)
                    <article wire:key="active-{{ $job->id }}" class="card flex flex-col gap-4 p-4 ring-ok-100 sm:flex-row sm:items-center sm:p-5">
                        <div class="flex min-w-0 flex-1 gap-3">
                            <x-trade-icon :category="$job->problem->category" />
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="font-bold text-ink-900">{{ $job->problem->client->name }}</span>
                                    <span class="chip chip-ok">Asignado</span>
                                </div>
                                <p class="mt-1 line-clamp-2 text-sm text-ink-600">{{ $job->problem->description }}</p>
                                <button @click="initMap({{ $job->problem->lat ?? 0 }}, {{ $job->problem->lng ?? 0 }}, 'Ubicación exacta', true)" class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:text-brand-700">
                                    <x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $job->problem->address ?? $job->problem->location }}
                                </button>
                            </div>
                        </div>
                        <a href="{{ route('chat', ['responseId' => $job->id]) }}" class="btn btn-success relative w-full sm:w-auto">
                            <x-icon name="chat" class="h-4 w-4" /> Abrir chat
                            @if($job->unreadMessagesCount(Auth::id()) > 0)
                                <span class="absolute -right-1 -top-1 flex h-3 w-3">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-urgent-400 opacity-75"></span>
                                    <span class="relative inline-flex h-3 w-3 rounded-full bg-urgent-500 ring-2 ring-white"></span>
                                </span>
                            @endif
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Pedidos abiertos --}}
    <section>
        <div class="mb-3">
            <h2 class="section-title">Pedidos en tu zona</h2>
            <p class="text-xs font-semibold text-ink-400">{{ implode(' · ', auth()->user()->professional->professions ?? []) }}</p>
        </div>

        @if($problems->isEmpty())
            <div class="card flex flex-col items-center px-6 py-10 text-center">
                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                    <x-icon name="inbox" class="h-7 w-7" />
                </span>
                <h3 class="mt-4 font-bold text-ink-900">No hay pedidos nuevos</h3>
                <p class="mt-1 max-w-xs text-sm text-ink-400">Te avisamos apenas entre uno de tus rubros cerca tuyo.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($problems as $problem)
                    <article wire:key="feed-{{ $problem->id }}" class="card overflow-hidden {{ $problem->is_urgent ? 'ring-2 ring-urgent-200' : '' }}">
                        @if($problem->photo_path)
                            <div class="relative h-44 bg-ink-100">
                                <img src="{{ asset('storage/' . $problem->photo_path) }}" alt="Foto del problema" class="h-full w-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="absolute inset-0 items-center justify-center text-ink-300" style="display:none;">
                                    <x-icon name="image" class="h-10 w-10" stroke="1.5" />
                                </div>
                            </div>
                        @endif
                        <div class="p-4 sm:p-5">
                            <div class="flex items-start gap-3">
                                <x-trade-icon :category="$problem->category" />
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="font-bold text-ink-900">{{ $problem->category }}</span>
                                        @if($problem->is_urgent)
                                            <span class="chip chip-urgent"><x-icon name="bolt" class="h-3 w-3" /> Urgente</span>
                                        @endif
                                    </div>
                                    <div class="mt-0.5 flex flex-wrap items-center gap-x-3 text-xs text-ink-400">
                                        <span class="flex items-center gap-1"><x-icon name="clock" class="h-3.5 w-3.5" /> {{ $problem->created_at->diffForHumans() }}</span>
                                        <button @click="initMap({{ $problem->approx_lat ?? 0 }}, {{ $problem->approx_lng ?? 0 }}, @js('Zona: ' . $problem->location), false)" class="flex items-center gap-1 font-semibold text-brand-600 hover:text-brand-700">
                                            <x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $problem->location }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 line-clamp-3 text-sm text-ink-700">{{ $problem->description }}</p>
                            <div class="mt-4 flex items-center justify-between gap-3 border-t border-ink-100 pt-4">
                                <span class="flex items-center gap-2 text-xs font-medium text-ink-500">
                                    <x-avatar :name="$problem->client->name ?? 'C'" size="sm" />
                                    {{ $problem->client->name ?? 'Cliente' }}
                                </span>
                                <button wire:click="openOfferModal({{ $problem->id }})" class="btn {{ $problem->is_urgent ? 'btn-urgent' : 'btn-primary' }}">
                                    Ofertar
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    {{-- Trabajos terminados --}}
    @if($completedJobs->isNotEmpty())
        <section>
            <h2 class="section-title mb-3">Terminados</h2>
            <div class="space-y-3">
                @foreach($completedJobs as $job)
                    @php $review = $job->problem->reviews->first(); @endphp
                    <article wire:key="done-{{ $job->id }}" class="card p-4 sm:p-5">
                        <div class="flex items-start gap-3">
                            <x-trade-icon :category="$job->problem->category" size="sm" />
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="font-bold text-ink-900">{{ $job->problem->client->name }}</span>
                                    <span class="text-xs text-ink-400">· {{ $job->problem->location }}</span>
                                </div>
                                <p class="mt-0.5 line-clamp-1 text-sm text-ink-500">{{ $job->problem->description }}</p>
                            </div>
                            @if($review)
                                <div class="flex items-center gap-0.5" aria-label="{{ $review->rating }} de 5 estrellas">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4 {{ $review->rating >= $i ? 'text-amber-400' : 'text-ink-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                            @endif
                        </div>
                        @if($review && $review->comment)
                            <p class="mt-3 rounded-xl bg-ink-50 px-3 py-2 text-sm text-ink-600">“{{ $review->comment }}” <span class="text-xs text-ink-400">· {{ $review->created_at->diffForHumans() }}</span></p>
                        @elseif(! $review)
                            <p class="mt-3 text-xs text-ink-400">Todavía sin calificación.</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Modal de mapa -->
    <div x-show="showMap" x-cloak class="relative z-50" role="dialog" aria-modal="true" style="display: none;">
        <div class="fixed inset-0 bg-ink-900/60 backdrop-blur-sm" @click="showMap = false"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-0 sm:items-center sm:p-4">
                <div class="relative w-full overflow-hidden rounded-t-4xl bg-white p-5 shadow-lift sm:max-w-xl sm:rounded-4xl sm:p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-extrabold text-ink-900" x-text="mapTitle"></h3>
                        <button @click="showMap = false" class="btn btn-ghost btn-sm" aria-label="Cerrar"><x-icon name="x" class="h-5 w-5" /></button>
                    </div>
                    <div id="feedMap" class="z-0 h-80 w-full rounded-3xl"></div>
                    <p class="mt-3 flex items-start gap-2 text-xs text-ink-500" x-show="!isExact">
                        <x-icon name="lock" class="mt-0.5 h-3.5 w-3.5 text-brand-600" />
                        Por seguridad solo ves la zona aproximada. La dirección exacta aparece cuando el cliente acepta tu oferta.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de oferta -->
    @if($isModalOpen)
        <div class="relative z-50" role="dialog" aria-modal="true" aria-labelledby="offer-title">
            <div class="fixed inset-0 bg-ink-900/60 backdrop-blur-sm" wire:click="closeOfferModal"></div>
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center sm:items-center sm:p-4">
                    <div class="relative w-full overflow-hidden rounded-t-4xl bg-white shadow-lift sm:max-w-lg sm:rounded-4xl">
                        <form wire:submit.prevent="submitOffer" class="p-5 sm:p-6">
                            <div class="mx-auto mb-4 h-1.5 w-10 rounded-full bg-ink-200 sm:hidden"></div>
                            <h3 class="text-xl font-extrabold tracking-tight text-ink-900" id="offer-title">Enviar oferta</h3>
                            <p class="mt-1 text-sm text-ink-500">El cliente compara precio, tiempo y tu reputación.</p>

                            <div class="mt-5 space-y-4">
                                <div>
                                    <label for="offerPrice" class="label">Precio estimado</label>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center font-bold text-ink-400">$</span>
                                        <input type="number" inputmode="numeric" wire:model="offerPrice" id="offerPrice" class="field pl-8 text-lg font-bold" placeholder="15000">
                                    </div>
                                    @error('offerPrice') <span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="offerTime" class="label">¿Cuándo llegás?</label>
                                    <input type="text" wire:model="offerTime" id="offerTime" class="field" placeholder="Ej: En 30 min / Hoy a las 16 hs">
                                    @error('offerTime') <span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="offerMessage" class="label">Mensaje <span class="font-normal text-ink-400">(opcional)</span></label>
                                    <textarea wire:model="offerMessage" id="offerMessage" rows="3" class="field resize-none" placeholder="Ej: Llevo los repuestos. La visita está incluida."></textarea>
                                    @error('offerMessage') <span class="mt-1 block text-xs font-medium text-red-600">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                                <button type="button" wire:click="closeOfferModal" class="btn btn-secondary">Cancelar</button>
                                <button type="submit" class="btn btn-primary">
                                    <x-icon name="send" class="h-4 w-4" /> Enviar oferta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function feedManager() {
            return {
                showMap: false,
                mapTitle: '',
                isExact: false,
                mapInstance: null,
                circleInstance: null,
                markerInstance: null,

                initMap(lat, lng, title, exact = false) {
                    if (lat == 0 || lng == 0) return;
                    
                    this.mapTitle = title;
                    this.isExact = exact;
                    this.showMap = true;

                    this.$nextTick(() => {
                        if (!this.mapInstance) {
                            this.mapInstance = L.map('feedMap').setView([lat, lng], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(this.mapInstance);
                        } else {
                            this.mapInstance.setView([lat, lng], 15);
                        }

                        // Clear previous layers
                        if (this.circleInstance) this.mapInstance.removeLayer(this.circleInstance);
                        if (this.markerInstance) this.mapInstance.removeLayer(this.markerInstance);

                        if (exact) {
                            this.markerInstance = L.marker([lat, lng]).addTo(this.mapInstance);
                        } else {
                            this.circleInstance = L.circle([lat, lng], {
                                color: '#0A5CFF',
                                fillColor: '#0A5CFF',
                                fillOpacity: 0.2,
                                radius: 400
                            }).addTo(this.mapInstance);
                        }

                        setTimeout(() => {
                            this.mapInstance.invalidateSize();
                        }, 200);
                    });
                }
            }
        }
    </script>
</div>
