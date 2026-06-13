<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">{{ __("¡Hola, :name! Bienvenido a Fixaro.", ['name' => Auth::user()->name]) }}</p>
                    
                    @if(session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(Auth::user()->role === 'client')
                        <div class="mt-6">
                            <a href="{{ route('client.problem.new') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-6 mr-4">
                                🛠️ Pedir un Profesional Ahora
                            </a>
                            <a href="{{ route('chats') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mb-6 relative">
                                💬 Mis Chats
                                @if(Auth::user()->unreadMessagesCount() > 0)
                                    <span class="absolute -top-2 -right-2 flex h-5 w-5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-5 w-5 bg-indigo-600 items-center justify-center text-white text-[10px]">
                                            {{ Auth::user()->unreadMessagesCount() }}
                                        </span>
                                    </span>
                                @endif
                            </a>
                            
                            @livewire('client.client-dashboard')
                        </div>
                    @elseif(Auth::user()->role === 'professional')
                        <div class="mt-6">
                            <a href="{{ route('chats') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-6 relative">
                                💬 Mis Chats
                                @if(Auth::user()->unreadMessagesCount() > 0)
                                    <span class="absolute -top-2 -right-2 flex h-5 w-5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-5 w-5 bg-red-600 items-center justify-center text-white text-[10px]">
                                            {{ Auth::user()->unreadMessagesCount() }}
                                        </span>
                                    </span>
                                @endif
                            </a>
                            @livewire('professional.problem-feed')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
