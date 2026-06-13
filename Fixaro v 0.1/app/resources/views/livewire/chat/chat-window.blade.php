<x-slot name="header">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Chat del Trabajo') }}
            </h2>
        </div>

        @if($isResolved)
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                ✓ Finalizado
            </span>
        @endif
    </div>
</x-slot>

<div>
    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col" style="height: 75vh;">
                {{-- Job Details Header --}}
                <div class="bg-white border-b border-gray-200 p-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-indigo-50 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 leading-tight">{{ $problem->title }}</h3>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    <span class="font-medium">Dirección exacta:</span> 
                                    {{ $problem->address ?? 'No especificada' }}
                                </p>
                            </div>
                        </div>

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
                                <button @click="open = true; initMap()" type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7" /></svg>
                                    Ver Mapa
                                </button>
 
                                {{-- Map Modal --}}
                                <div x-show="open" 
                                     x-cloak
                                     wire:key="map-modal-{{ $problem->id }}"
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true">
                                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-lg font-medium text-gray-900">Ubicación del Trabajo</h3>
                                                    <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    </button>
                                                </div>
                                                <div id="chat-map-{{ $problem->id }}" wire:ignore class="w-full h-96 rounded-lg border border-gray-200 z-0"></div>
                                                <div class="mt-4 text-sm text-gray-600">
                                                    <p class="font-bold">Dirección: {{ $problem->address }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Chat Messages --}}
                <div class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col space-y-3" wire:poll.2s="loadMessages">
                    @if(count($messages) === 0)
                        <div class="text-center text-sm text-gray-500 mt-10">
                            <p class="font-medium">No hay mensajes todavía.</p>
                            <p class="mt-1 text-gray-400">¡Escribe el primer mensaje para coordinar!</p>
                        </div>
                    @else
                        @foreach($messages as $msg)
                            @if($msg['sender_id'] == Auth::id())
                                <div class="flex justify-end">
                                    <div class="bg-indigo-600 text-white rounded-lg py-2 px-4 max-w-xs lg:max-w-md break-words shadow">
                                        <p class="text-sm">{{ $msg['message'] }}</p>
                                        <span class="text-xs text-indigo-200 mt-1 block text-right">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-start">
                                    <div class="bg-white border border-gray-200 text-gray-900 rounded-lg py-2 px-4 max-w-xs lg:max-w-md break-words shadow">
                                        <p class="text-sm">{{ $msg['message'] }}</p>
                                        <span class="text-xs text-gray-400 mt-1 block">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                {{-- Chat Input --}}
                @if(!$isResolved)
                    <div class="bg-white border-t border-gray-200 p-3 sm:p-4">
                        <div class="flex space-x-2">
                            <input type="text" wire:model="newMessage"
                                   wire:keydown.enter="sendMessage"
                                   wire:loading.attr="disabled"
                                   wire:target="sendMessage"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-50"
                                   placeholder="Escribe un mensaje..." autocomplete="off">
                            <button type="button" 
                                    wire:click="sendMessage"
                                    wire:loading.attr="disabled"
                                    wire:target="sendMessage"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50">
                                <svg wire:loading.remove wire:target="sendMessage" class="h-4 w-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                                <svg wire:loading wire:target="sendMessage" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        @if($isClient)
                            <div class="mt-3 pt-3 border-t border-gray-100" x-data="{ open: false }">
                                <button x-on:click="open = true" type="button"
                                    class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                    ✓ Terminar Trabajo
                                </button>

                                {{-- Inline Modal --}}
                                <div x-show="open" x-cloak style="display:none"
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                    <div class="fixed inset-0 bg-black bg-opacity-50" x-on:click="open = false"></div>
                                    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6 z-10">
                                        <div class="text-center mb-5">
                                            <h3 class="text-lg font-bold text-gray-900">Finalizar Trabajo</h3>
                                            <p class="text-sm text-gray-500 mt-1">¿Cómo fue tu experiencia?</p>
                                        </div>

                                        {{-- Stars --}}
                                        <div class="mb-4">
                                            <div class="flex items-center justify-center space-x-2" x-data="{ hovered: 0 }">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button"
                                                            wire:click="setRating({{ $i }})"
                                                            x-on:mouseenter="hovered = {{ $i }}"
                                                            x-on:mouseleave="hovered = 0"
                                                            class="focus:outline-none">
                                                        <svg class="w-9 h-9 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    </button>
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- Comment --}}
                                        <div class="mb-5">
                                            <textarea wire:model="reviewComment" rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                placeholder="Comentario opcional..."></textarea>
                                        </div>

                                        {{-- Buttons --}}
                                        <button wire:click="finishAndReview" type="button"
                                            class="w-full mb-2 px-4 py-3 bg-green-600 rounded-md font-semibold text-sm text-white uppercase hover:bg-green-700 transition">
                                            ✓ Finalizar y Calificar
                                        </button>
                                        <button x-on:click="open = false" type="button"
                                            class="w-full px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 transition">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 border-t border-gray-200 p-4 text-center text-sm text-gray-500">
                        Este trabajo ha sido finalizado.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
