<div>
    <h3 class="text-lg font-bold mb-4">Tus Problemas Publicados</h3>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($problems->isEmpty())
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">No tienes problemas publicados</h3>
            <p class="mt-1 text-sm text-gray-500">¿Necesitas un profesional? Pide uno ahora.</p>
            <div class="mt-4">
                <a href="{{ route('client.problem.new') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    Pedir un Profesional
                </a>
            </div>
        </div>
    @else
        <div class="space-y-6">
            @foreach($problems as $problem)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    
                    <!-- Problem Header -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{ $problem->category }}</span>
                                @if($problem->status === 'open')
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Abierto - Esperando ofertas</span>
                                @elseif($problem->status === 'assigned')
                                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">Asignado</span>
                                @elseif($problem->status === 'resolved')
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Resuelto</span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-900 line-clamp-2">{{ $problem->description }}</p>
                        </div>
                        <span class="mt-2 sm:mt-0 text-xs text-gray-500">{{ $problem->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <!-- Offers / Responses Section -->
                    <div class="p-4">
                        @if($problem->status === 'open')
                            {{-- OPEN: Show all pending offers --}}
                            @if($problem->responses->isEmpty())
                                <p class="text-sm text-gray-500 text-center py-4">Aún no hay ofertas de profesionales. Te notificaremos pronto.</p>
                            @else
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Ofertas Recibidas ({{ $problem->responses->where('status', 'pending')->count() }})</h4>
                                <div class="space-y-3">
                                    @foreach($problem->responses->where('status', 'pending') as $response)
                                        <div class="border border-gray-200 rounded-md p-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-900">{{ $response->professional->user->name }} {{ $response->professional->user->surname }}</span>
                                                    <p class="text-xs text-gray-500 mt-1">Tiempo: {{ $response->time_estimate }}</p>
                                                    @if($response->message)
                                                        <p class="text-xs text-gray-600 mt-2 bg-white p-2 rounded border border-gray-100">"{{ $response->message }}"</p>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-bold text-gray-900">${{ number_format($response->price_estimate, 0, ',', '.') }}</div>
                                                    <button wire:click="acceptOffer({{ $response->id }})" class="mt-2 text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700 font-medium">
                                                        Aceptar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        @elseif($problem->status === 'assigned')
                            {{-- ASSIGNED: Show accepted professional + chat link --}}
                            @php $accepted = $problem->responses->where('status', 'accepted')->first(); @endphp
                            @if($accepted)
                                <div class="border border-indigo-300 bg-indigo-50 rounded-md p-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <div class="flex items-center">
                                                <svg class="h-4 w-4 text-indigo-600 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                <span class="text-sm font-medium text-gray-900">{{ $accepted->professional->user->name }} {{ $accepted->professional->user->surname }}</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">${{ number_format($accepted->price_estimate, 0, ',', '.') }} · {{ $accepted->time_estimate }}</p>
                                        </div>
                                        <a href="{{ route('chat', ['responseId' => $accepted->id]) }}" class="inline-flex items-center px-3 py-1.5 text-xs bg-green-600 text-white rounded-md hover:bg-green-700 font-medium relative">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            Ir al Chat
                                            @if($accepted->unreadMessagesCount(Auth::id()) > 0)
                                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endif

                        @elseif($problem->status === 'resolved')
                            {{-- RESOLVED: Show completion message --}}
                            <div class="text-center py-3">
                                <p class="text-sm text-green-700 font-medium">✓ Trabajo completado</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
