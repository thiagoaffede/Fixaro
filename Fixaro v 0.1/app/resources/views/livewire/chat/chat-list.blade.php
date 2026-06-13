<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6 flex items-center">
                    <span class="mr-2">💬</span> {{ __('Tus Chats') }}
                </h2>

                @if($chats->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">📭</div>
                        <p class="text-gray-500 text-lg">{{ __('Aún no tienes conversaciones activas.') }}</p>
                        <p class="text-gray-400 text-sm mt-2">{{ __('Los chats aparecerán aquí cuando se acepten ofertas de trabajo.') }}</p>
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach($chats as $chat)
                            <a href="{{ route('chat', $chat->id) }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition duration-150 ease-in-out relative {{ $chat->unread_count > 0 ? 'border-indigo-200 bg-indigo-50/30' : 'border-gray-200' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">
                                            {{ substr(Auth::id() === ($chat->problem->user_id ?? null) ? ($chat->professional->user->name ?? 'P') : ($chat->problem->user->name ?? 'C'), 0, 1) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-800">
                                                {{ Auth::id() === ($chat->problem->user_id ?? null) ? ($chat->professional->user->name ?? __('Profesional')) : ($chat->problem->user->name ?? __('Cliente')) }}
                                                <span class="text-sm font-normal text-gray-500 ml-2">· {{ $chat->problem->title }}</span>
                                            </h3>
                                            <p class="text-sm text-gray-600 truncate max-w-md">
                                                @if($chat->last_message)
                                                    <span class="{{ $chat->unread_count > 0 ? 'font-bold text-gray-900' : '' }}">
                                                        {{ $chat->last_message->sender_id === Auth::id() ? 'Tú: ' : '' }}{{ $chat->last_message->message }}
                                                    </span>
                                                @else
                                                    <span class="italic text-gray-400">{{ __('Sin mensajes aún') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($chat->last_message)
                                            <p class="text-xs text-gray-400">{{ $chat->last_message->created_at->diffForHumans() }}</p>
                                        @endif
                                        
                                        @if($chat->unread_count > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-1 ml-2 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full">
                                                {{ $chat->unread_count }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($chat->unread_count > 0)
                                    <div class="absolute top-4 right-4 h-3 w-3 bg-indigo-600 rounded-full animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
