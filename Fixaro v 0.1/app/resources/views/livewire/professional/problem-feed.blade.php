<div x-data="feedManager()">
    @if($activeJobs->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4 text-green-700">Tus Trabajos Activos</h3>
            <div class="space-y-4">
                @foreach($activeJobs as $job)
                    <div class="bg-green-50 border border-green-200 rounded-lg shadow-sm p-4 flex justify-between items-center">
                        <div>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $job->problem->category }}</span>
                            <p class="mt-2 text-sm font-medium text-gray-900">{{ Str::limit($job->problem->description, 100) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Cliente: {{ $job->problem->client->name }} | {{ $job->problem->location }}</p>
                            
                            <!-- Assigned professional can see exact location button -->
                            <button @click="initMap({{ $job->problem->lat }}, {{ $job->problem->lng }}, 'Ubicación Exacta', true)" class="mt-2 inline-flex items-center text-xs text-green-600 hover:text-green-700 font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Ver dirección exacta
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('chat', ['responseId' => $job->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 relative">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Abrir Chat
                                @if($job->unreadMessagesCount(Auth::id()) > 0)
                                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($completedJobs->isNotEmpty())
        <div class="mb-8">
            <h3 class="text-lg font-bold mb-4 text-gray-600">Trabajos Completados</h3>
            <div class="space-y-4">
                @foreach($completedJobs as $job)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $job->problem->category }}</span>
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 ml-1">✓ Resuelto</span>
                                <p class="mt-2 text-sm text-gray-700">{{ Str::limit($job->problem->description, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Cliente: {{ $job->problem->client->name }} | {{ $job->problem->location }}</p>
                            </div>
                        </div>

                        {{-- Review / Rating --}}
                        @php $review = $job->problem->reviews->first(); @endphp
                        @if($review)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <div class="flex items-center space-x-1">
                                    <span class="text-xs font-medium text-gray-600 mr-1">Valoración:</span>
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="text-xs text-gray-500 ml-1">({{ $review->rating }}/5)</span>
                                </div>
                                @if($review->comment)
                                    <p class="mt-2 text-sm text-gray-600 italic bg-white p-2 rounded border border-gray-100">"{{ $review->comment }}"</p>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">Por {{ $review->client->name }} · {{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @else
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-400">El cliente aún no ha dejado una valoración.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h3 class="text-lg font-bold mb-4">Problemas Abiertos en tu Zona</h3>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if($problems->isEmpty())
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No hay problemas nuevos</h3>
            <p class="mt-1 text-sm text-gray-500">Te notificaremos cuando haya solicitudes en tus categorías ({{ implode(', ', auth()->user()->professional->professions ?? []) }}).</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($problems as $problem)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden flex flex-col sm:flex-row">
                    @if($problem->photo_path)
                        <div class="sm:w-48 h-48 sm:h-auto flex-shrink-0 bg-gray-100 relative">
                            <img src="{{ asset('storage/' . $problem->photo_path) }}" alt="Foto del problema" class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="absolute inset-0 items-center justify-center bg-gray-100 text-gray-400" style="display:none;">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                    @endif
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $problem->category }}</span>
                                    @if($problem->is_urgent)
                                        <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 ml-2">URGENTE</span>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">{{ $problem->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-900 font-medium line-clamp-3">{{ $problem->description }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="mr-1.5 h-4 w-4 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    {{ $problem->location }}
                                </div>
                                
                                <button @click="initMap({{ $problem->approx_lat ?? '0' }}, {{ $problem->approx_lng ?? '0' }}, 'Zona: {{ $problem->location }}', false)" class="text-xs font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                    Ver zona
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                Solicitado por: {{ $problem->client->name ?? 'Cliente' }}
                            </div>
                            <button wire:click="openOfferModal({{ $problem->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Hacer Oferta
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Map Modal -->
    <div x-show="showMap" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showMap = false"></div>
        <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900" x-text="mapTitle"></h3>
                            <button @click="showMap = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div id="feedMap" class="h-80 w-full rounded-lg border z-0"></div>
                        <p class="mt-3 text-xs text-gray-500 italic" x-show="!isExact">
                            * Por seguridad, solo se muestra el área aproximada. La dirección exacta se revelará si el cliente acepta tu oferta.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offer Modal -->
    @if($isModalOpen)
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <form wire:submit.prevent="submitOffer">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Enviar Presupuesto / Oferta</h3>
                                        <div class="mt-4 space-y-4">
                                            <div>
                                                <label for="offerPrice" class="block text-sm font-medium leading-6 text-gray-900">Precio Estimado ($)</label>
                                                <div class="mt-2">
                                                    <input type="number" wire:model="offerPrice" id="offerPrice" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Ej: 15000">
                                                    @error('offerPrice') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div>
                                                <label for="offerTime" class="block text-sm font-medium leading-6 text-gray-900">Tiempo Estimado / Disponibilidad</label>
                                                <div class="mt-2">
                                                    <input type="text" wire:model="offerTime" id="offerTime" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Ej: Puedo ir hoy a las 16hs / Tardo 2hs">
                                                    @error('offerTime') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div>
                                                <label for="offerMessage" class="block text-sm font-medium leading-6 text-gray-900">Mensaje Breve (Opcional)</label>
                                                <div class="mt-2">
                                                    <textarea wire:model="offerMessage" id="offerMessage" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Ej: Llevo los repuestos, cobro visita, etc."></textarea>
                                                    @error('offerMessage') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">Enviar Oferta</button>
                                <button type="button" wire:click="closeOfferModal" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
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
                                color: '#4f46e5',
                                fillColor: '#4f46e5',
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
