@php
    $user = Auth::user();
    $unread = $user->unreadMessagesCount();
    $isClient = $user->role === 'client';
    $tab = fn ($active) => $active ? 'text-brand-600' : 'text-ink-400';
@endphp

{{-- Barra inferior tipo app (solo celular) --}}
<nav class="fixed inset-x-0 bottom-0 z-40 border-t border-ink-100 bg-white/95 pb-[env(safe-area-inset-bottom)] backdrop-blur sm:hidden" aria-label="Navegación principal">
    <div class="mx-auto grid h-16 max-w-md grid-cols-4 items-center">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-0.5 text-[11px] font-semibold {{ $tab(request()->routeIs('dashboard')) }}">
            <x-icon name="{{ $isClient ? 'home' : 'briefcase' }}" class="h-6 w-6" />
            {{ $isClient ? 'Inicio' : 'Trabajos' }}
        </a>

        @if($isClient)
            <a href="{{ route('client.problem.new') }}" class="col-span-2 flex justify-center" aria-label="Pedir ayuda">
                <span class="-mt-7 flex items-center gap-2 rounded-full bg-urgent-500 px-5 py-3.5 text-sm font-extrabold text-white shadow-cta ring-4 ring-white active:scale-95">
                    <x-icon name="plus" class="h-5 w-5" stroke="2.5" /> Pedir ayuda
                </span>
            </a>
        @else
            <span class="col-span-2 flex justify-center">
                <span class="chip chip-ok"><span class="h-2 w-2 animate-pulse rounded-full bg-ok-500"></span> Recibiendo pedidos</span>
            </span>
        @endif

        <a href="{{ route('chats') }}" class="relative flex flex-col items-center gap-0.5 text-[11px] font-semibold {{ $tab(request()->routeIs('chats', 'chat')) }}">
            <x-icon name="chat" class="h-6 w-6" />
            Mensajes
            @if($unread > 0)
                <span class="absolute -top-1 left-1/2 ml-2 rounded-full bg-urgent-500 px-1.5 py-0.5 text-[10px] font-bold leading-none text-white ring-2 ring-white">{{ $unread }}</span>
            @endif
        </a>
    </div>
</nav>
