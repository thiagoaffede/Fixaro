<div>
    <div class="max-w-xl mx-auto p-4 sm:p-6 lg:p-8 bg-white shadow rounded-lg mt-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Publicar un Problema</h2>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="w-1/3 text-center">
                    <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $step >= 1 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">1</div>
                    <div class="text-xs mt-2 {{ $step >= 1 ? 'text-indigo-600 font-bold' : 'text-gray-500' }}">Foto</div>
                </div>
                <div class="w-1/3 text-center">
                    <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $step >= 2 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">2</div>
                    <div class="text-xs mt-2 {{ $step >= 2 ? 'text-indigo-600 font-bold' : 'text-gray-500' }}">Detalles</div>
                </div>
                <div class="w-1/3 text-center">
                    <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center {{ $step >= 3 ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">3</div>
                    <div class="text-xs mt-2 {{ $step >= 3 ? 'text-indigo-600 font-bold' : 'text-gray-500' }}">Ubicación</div>
                </div>
            </div>
            <div class="relative mt-2">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="submit">
            
            <!-- STEP 1: Photo -->
            @if ($step == 1)
                <div class="space-y-6">
                    <div>
                        <x-input-label for="photo" :value="__('Sube una foto del problema (Opcional pero recomendado)')" />
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" class="mx-auto h-32 w-auto rounded" alt="Preview">
                                    <button type="button" wire:click="$set('photo', null)" class="mt-2 text-sm text-red-600 hover:text-red-500">Quitar foto</button>
                                @else
                                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                        <label for="photo" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                            <span>Seleccionar archivo</span>
                                            <input id="photo" wire:model="photo" type="file" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF hasta 5MB</p>
                                @endif
                            </div>
                        </div>
                        <div wire:loading wire:target="photo" class="mt-2 text-sm text-indigo-600">Cargando imagen...</div>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button type="button" wire:click="nextStep">
                            {{ __('Siguiente') }}
                        </x-primary-button>
                    </div>
                </div>
            @endif

            <!-- STEP 2: Description -->
            @if ($step == 2)
                <div class="space-y-6">
                    <div>
                        <x-input-label for="description" :value="__('Describe el problema (Obligatorio)')" />
                        <p class="text-sm text-gray-500 mb-2">Sé lo más detallado posible para recibir presupuestos más precisos.</p>
                        <textarea wire:model="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Hay una fuga de agua debajo de la bacha de la cocina que empezó ayer..."></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_urgent" wire:model="is_urgent" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-indigo-300 text-indigo-600">
                        </div>
                        <label for="is_urgent" class="ml-2 text-sm font-medium text-gray-900">¿Es una urgencia?</label>
                    </div>
                    <p class="text-xs text-gray-500 ml-6">Márcalo solo si necesitas asistencia inmediata (puede incurrir en costos adicionales por urgencia).</p>

                    <div class="flex justify-between">
                        <button type="button" wire:click="previousStep" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Atrás
                        </button>
                        <x-primary-button type="button" wire:click="nextStep">
                            {{ __('Siguiente') }}
                        </x-primary-button>
                    </div>
                </div>
            @endif

            <!-- STEP 3: Location and Category Confirmation -->
            @if ($step == 3)
                <div class="space-y-6" x-data="locationPicker()">
                    <div>
                        <x-input-label for="address" :value="__('¿Dónde se encuentra el problema?')" />
                            <!-- Google Places Style Suggestions List -->
                            <div class="border border-gray-300 rounded shadow-sm overflow-hidden mt-1 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                                <input 
                                    type="text" 
                                    x-model="query" 
                                    @input.debounce.300ms="searchAddress()"
                                    placeholder="Ingrese una ubicación"
                                    class="w-full border-0 focus:ring-0 p-3 text-base"
                                    autocomplete="off"
                                >
                                
                                <div x-show="suggestions.length > 0" class="border-t border-gray-200 divide-y divide-gray-100 bg-white">
                                    <template x-for="suggestion in suggestions" :key="suggestion.place_id">
                                        <button 
                                            type="button"
                                            @click="selectAddress(suggestion)"
                                            class="w-full text-left px-3 py-2.5 hover:bg-gray-50 flex items-start space-x-3 transition-colors group"
                                        >
                                            <div class="mt-0.5">
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="leading-tight">
                                                <span x-text="suggestion.formatted_primary" class="font-bold text-gray-800 text-sm"></span>
                                                <span x-text="suggestion.formatted_secondary" class="text-gray-400 text-xs ml-1"></span>
                                            </div>
                                        </button>
                                    </template>
                                </div>

                                <div x-show="loading" class="bg-gray-50 px-3 py-1 border-t border-gray-100 flex justify-end">
                                    <span class="text-[10px] text-gray-400 animate-pulse uppercase font-semibold">Buscando...</span>
                                </div>

                                <div class="bg-white px-3 py-1.5 border-t border-gray-100 flex justify-end items-center space-x-1 opacity-50">
                                    <span class="text-[9px] text-gray-400">powered by</span>
                                    <span class="text-[9px] font-bold text-gray-600">OpenStreetMap</span>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        @if($errors->has('lat') || $errors->has('lng'))
                            <p class="text-sm text-red-600 mt-2">Por favor, selecciona una dirección válida de la lista desplegable.</p>
                        @endif
                    <!-- End of address container -->

                    <!-- Map Preview -->
                    <div x-show="lat" class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Vista previa de ubicación</span>
                            <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 1.55l7.834 3.35a1 1 0 01.666.92v6.57a1 1 0 01-.17.56l-8.334 11.2a1 1 0 01-1.66 0L.17 12.94a1 1 0 01-.17-.56V5.82a1 1 0 01.666-.92zM10 3.167L3.5 5.952V12.15l6.5 8.735 6.5-8.735V5.952L10 3.167zM10 6a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"></path></svg>
                                Privacidad Protegida
                            </span>
                        </div>
                        <div id="map" class="h-48 w-full rounded-lg border shadow-inner z-0" wire:ignore></div>
                        <p class="text-[10px] text-gray-500 italic">
                            * Los profesionales solo verán el círculo azul (zona aproximada) hasta que aceptes su oferta.
                        </p>
                    </div>

                    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                        <span class="font-medium">Sugerencia Inteligente:</span> Basado en tu descripción, creemos que necesitas un <strong>{{ $category }}</strong>.
                    </div>

                    <div>
                        <x-input-label for="category" :value="__('¿Es correcta esta categoría?')" />
                        <select wire:model="category" id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 mt-1">
                            <option value="Plomero">Plomero</option>
                            <option value="Electricista">Electricista</option>
                            <option value="Gasista">Gasista</option>
                            <option value="Cerrajero">Cerrajero</option>
                            <option value="Albañil">Albañil</option>
                            <option value="Aire Acondicionado">Aire Acondicionado</option>
                            <option value="General">Reparaciones Generales</option>
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="flex justify-between">
                        <button type="button" wire:click="previousStep" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Atrás
                        </button>
                        <x-primary-button type="submit" class="bg-green-600 hover:bg-green-500 focus:bg-green-700 active:bg-green-800 focus:ring-green-500">
                            {{ __('Publicar Problema') }}
                        </x-primary-button>
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
                            color: '#4f46e5',
                            fillColor: '#4f46e5',
                            fillOpacity: 0.2,
                            radius: 400
                        }).addTo(this.map);
                    }
                }
            }
        </script>
    </div>
</div>
