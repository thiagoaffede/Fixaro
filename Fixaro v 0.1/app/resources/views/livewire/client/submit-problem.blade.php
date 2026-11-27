<div class="mx-auto max-w-xl px-4 pt-5 sm:px-6 sm:pt-8">
    @php
        $steps = [1 => ['Foto', 'Mostranos el problema'], 2 => ['Detalles', '¿Qué está pasando?'], 3 => ['Ubicación', '¿Dónde tiene que ir el técnico?']];
    @endphp

    {{-- Encabezado y progreso --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm -ml-2">
                <x-icon name="arrow-left" class="h-4 w-4" /> Volver
            </a>
            <span class="text-xs font-bold uppercase tracking-wider text-ink-400">Paso {{ $step }} de 3</span>
        </div>
        <div class="mt-3 grid grid-cols-3 gap-1.5" aria-hidden="true">
            @foreach($steps as $n => $info)
                <div class="h-1.5 rounded-full transition-colors {{ $step >= $n ? 'bg-urgent-500' : 'bg-ink-200' }}"></div>
            @endforeach
        </div>
        <h1 class="mt-5 text-2xl font-extrabold tracking-tight text-ink-900 sm:text-3xl">{{ $steps[$step][1] }}</h1>
    </div>

    <div class="card p-5 sm:p-6">
        <form wire:submit.prevent="submit">

            <!-- PASO 1: Foto -->
            @if ($step == 1)
                <div class="space-y-5">
                    <p class="text-sm text-ink-500">Con una foto el técnico puede darte un diagnóstico y un precio más preciso. Es opcional.</p>

                    <div>
                        @if ($photo)
                            <div class="relative overflow-hidden rounded-3xl bg-ink-100">
                                <img src="{{ $photo->temporaryUrl() }}" class="max-h-72 w-full object-cover" alt="Vista previa">
                                <button type="button" wire:click="$set('photo', null)" class="btn btn-secondary btn-sm absolute right-3 top-3 shadow-sm">
                                    <x-icon name="x" class="h-4 w-4" /> Quitar
                                </button>
                            </div>
                        @else
                            <label for="photo" class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-ink-200 bg-ink-50 px-6 py-12 text-center transition hover:border-brand-400 hover:bg-brand-50/50">
                                <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-brand-600 shadow-card">
                                    <x-icon name="camera" class="h-8 w-8" />
                                </span>
                                <span class="mt-4 font-bold text-ink-900">Sacá o subí una foto</span>
                                <span class="mt-1 text-xs text-ink-400">JPG o PNG, hasta 5 MB</span>
                                <input id="photo" wire:model="photo" type="file" class="sr-only" accept="image/*" capture="environment">
                            </label>
                        @endif
                        <div wire:loading wire:target="photo" class="mt-3 text-sm font-semibold text-brand-600">Subiendo foto…</div>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <button type="button" wire:click="nextStep" class="btn btn-primary btn-lg w-full">
                        {{ $photo ? 'Continuar' : 'Seguir sin foto' }} <x-icon name="arrow-right" class="h-5 w-5" />
                    </button>
                </div>
            @endif

            <!-- PASO 2: Descripción -->
            @if ($step == 2)
                <div class="space-y-5">
                    <div>
                        <label for="description" class="label">Contalo en pocas palabras</label>
                        <textarea wire:model="description" id="description" rows="4" class="field resize-none" placeholder="Ej: Pierde agua debajo de la bacha de la cocina desde ayer. Ya cerré la llave de paso."></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <label for="is_urgent" class="flex cursor-pointer items-start gap-3 rounded-2xl p-4 ring-1 ring-inset transition {{ $is_urgent ? 'bg-urgent-50 ring-urgent-200' : 'bg-white ring-ink-200' }}">
                        <input id="is_urgent" wire:model.live="is_urgent" type="checkbox" class="mt-0.5 h-5 w-5 rounded-md border-ink-300 text-urgent-500 focus:ring-urgent-200">
                        <span>
                            <span class="flex items-center gap-1.5 font-bold text-ink-900"><x-icon name="bolt" class="h-4 w-4 text-urgent-500" /> Es una urgencia</span>
                            <span class="mt-0.5 block text-xs text-ink-500">Priorizamos tu pedido. Puede tener un recargo por atención inmediata.</span>
                        </span>
                    </label>

                    <div class="flex gap-3">
                        <button type="button" wire:click="previousStep" class="btn btn-secondary btn-lg">
                            <x-icon name="arrow-left" class="h-5 w-5" />
                        </button>
                        <button type="button" wire:click="nextStep" class="btn btn-primary btn-lg flex-1">
                            Continuar <x-icon name="arrow-right" class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            @endif

            <!-- PASO 3: Ubicación y rubro -->
            @if ($step == 3)
                <div class="space-y-5" x-data="locationPicker()">
                    <div>
                        <label for="address" class="label">Dirección</label>
                        <div class="overflow-hidden rounded-2xl bg-white ring-1 ring-inset ring-ink-200 transition focus-within:ring-2 focus-within:ring-brand-600">
                            <div class="flex items-center gap-2 px-4">
                                <x-icon name="map-pin" class="h-5 w-5 text-ink-400" />
                                <input
                                    id="address"
                                    type="text"
                                    x-model="query"
                                    @input.debounce.300ms="searchAddress()"
                                    placeholder="Calle y número"
                                    class="w-full rounded-none border-0 bg-transparent px-0 py-3 text-base text-ink-900 shadow-none placeholder:text-ink-300 focus:ring-0"
                                    autocomplete="off"
                                >
                                <span x-show="loading" class="text-[10px] font-bold uppercase text-ink-300 animate-pulse">Buscando</span>
                            </div>

                            <div x-show="suggestions.length > 0" x-cloak class="divide-y divide-ink-100 border-t border-ink-100">
                                <template x-for="suggestion in suggestions" :key="suggestion.place_id">
                                    <button
                                        type="button"
                                        @click="selectAddress(suggestion)"
                                        class="flex w-full items-start gap-3 px-4 py-3 text-left transition hover:bg-brand-50"
                                    >
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                        <span class="leading-tight">
                                            <span x-text="suggestion.formatted_primary" class="block text-sm font-bold text-ink-900"></span>
                                            <span x-text="suggestion.formatted_secondary" class="text-xs text-ink-400"></span>
                                        </span>
                                    </button>
                                </template>
                                <div class="px-4 py-1.5 text-right text-[10px] text-ink-300">Datos © OpenStreetMap</div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        @if($errors->has('lat') || $errors->has('lng'))
                            <p class="mt-2 text-sm font-medium text-red-600">Elegí una dirección de la lista para ubicarte en el mapa.</p>
                        @endif
                    </div>

                    <!-- Vista previa del mapa -->
                    <div x-show="lat" x-cloak class="space-y-2">
                        <div id="map" class="h-48 w-full rounded-3xl ring-1 ring-ink-100 z-0" wire:ignore></div>
                        <p class="flex items-start gap-2 text-xs text-ink-500">
                            <x-icon name="lock" class="mt-0.5 h-3.5 w-3.5 text-brand-600" />
                            Tu dirección exacta queda privada. Los técnicos solo ven la zona aproximada hasta que aceptes una oferta.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-brand-50 p-4">
                        <div class="flex items-center gap-3">
                            <x-trade-icon :category="$category" size="sm" />
                            <div class="flex-1">
                                <p class="text-xs font-semibold text-brand-700">Según tu descripción, necesitás un</p>
                                <select wire:model="category" id="category" class="-ml-1 mt-0.5 w-full rounded-xl border-0 bg-transparent py-1 pl-1 pr-8 text-base font-extrabold text-ink-900 focus:ring-2 focus:ring-brand-600">
                                    <option value="Plomero">Plomero</option>
                                    <option value="Electricista">Electricista</option>
                                    <option value="Gasista">Gasista</option>
                                    <option value="Cerrajero">Cerrajero</option>
                                    <option value="Albañil">Albañil</option>
                                    <option value="Aire Acondicionado">Aire Acondicionado</option>
                                    <option value="General">Reparaciones Generales</option>
                                </select>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="flex gap-3">
                        <button type="button" wire:click="previousStep" class="btn btn-secondary btn-lg">
                            <x-icon name="arrow-left" class="h-5 w-5" />
                        </button>
                        <button type="submit" class="btn btn-urgent btn-lg flex-1" wire:loading.attr="disabled" wire:target="submit">
                            <x-icon name="bolt" class="h-5 w-5" /> Pedir técnico
                        </button>
                    </div>
                </div>
            @endif

        </form>

        <script>
            function locationPicker() {
                return {
                    query: @entangle('address'),
                    lat: @entangle('lat'),
                    lng: @entangle('lng'),
                    suggestions: [],
                    loading: false,
                    map: null,
                    marker: null,
                    circle: null,

                    init() {
                        this.$watch('lat', value => {
                            if (value) {
                                this.$nextTick(() => this.initMap());
                            }
                        });
                    },

                    async searchAddress() {
                        if (this.query.length < 3) {
                            this.suggestions = [];
                            return;
                        }

                        this.loading = true;
                        try {
                            const controller = new AbortController();
                            const timeoutId = setTimeout(() => controller.abort(), 3000);

                            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.query)}&limit=5&addressdetails=1&countrycodes=ar&accept-language=es`, {
                                signal: controller.signal
                            });
                            clearTimeout(timeoutId);
                            const results = await response.json();
                            
                            // Format and filter results
                            this.suggestions = results.map(item => {
                                const addr = item.address;
                                
                                // Priority: Street + Number
                                let primary = '';
                                if (addr.road) {
                                    primary = addr.road + (addr.house_number ? ' ' + addr.house_number : '');
                                } else {
                                    primary = item.display_name.split(',')[0];
                                }
                                
                                // Clean up secondary (Neighborhood, City, etc)
                                let cityParts = [];
                                if (addr.suburb || addr.neighbourhood) cityParts.push(addr.suburb || addr.neighbourhood);
                                if (addr.city || addr.town) cityParts.push(addr.city || addr.town);
                                if (addr.state) cityParts.push(addr.state);
                                
                                let secondary = cityParts.join(', ');
                                if (!secondary) {
                                    secondary = item.display_name.replace(primary + ', ', '');
                                }
                                
                                return {
                                    ...item,
                                    formatted_primary: primary,
                                    formatted_secondary: secondary
                                };
                            });
                        } catch (error) {
                            console.error("Error fetching addresses:", error);
                            this.suggestions = [];
                        } finally {
                            this.loading = false;
                        }
                    },

                    selectAddress(suggestion) {
                        this.query = suggestion.display_name;
                        this.lat = parseFloat(suggestion.lat);
                        this.lng = parseFloat(suggestion.lon);
                        this.suggestions = [];
                        
                        let neighborhood = suggestion.address.suburb || 
                                           suggestion.address.neighbourhood || 
                                           suggestion.address.city_district || 
                                           suggestion.address.city || 
                                           suggestion.address.town || 
                                           'Zona Centro';
                        
                        @this.set('location', neighborhood);
                    },

                    initMap() {
                        if (!this.map) {
                            this.map = L.map('map').setView([this.lat, this.lng], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(this.map);
                        } else {
                            this.map.setView([this.lat, this.lng], 15);
                        }

                        if (this.marker) this.map.removeLayer(this.marker);
                        if (this.circle) this.map.removeLayer(this.circle);

                        this.marker = L.marker([this.lat, this.lng]).addTo(this.map);
                        
                        this.circle = L.circle([this.lat, this.lng], {
                            color: '#0A5CFF',
                            fillColor: '#0A5CFF',
                            fillOpacity: 0.2,
                            radius: 400
                        }).addTo(this.map);
                    }
                }
            }
        </script>
    </div>
</div>
