@php
    $user = Auth::user();
    $unread = $user->unreadMessagesCount();
    $isClient = $user->role === 'client';
@endphp

<nav class="sticky top-0 z-40 border-b border-ink-100 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-5xl items-center justify-between px-4 sm:px-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" aria-label="Inicio">
                <x-brand />
            </a>

            <!-- Links de escritorio -->
            <div class="hidden items-center gap-1 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <x-icon name="home" class="h-4 w-4" /> Inicio
                </x-nav-link>
                <x-nav-link :href="route('chats')" :active="request()->routeIs('chats', 'chat')">
                    <x-icon name="chat" class="h-4 w-4" /> Mensajes
                    @if($unread > 0)
                        <span class="rounded-full bg-urgent-500 px-1.5 py-0.5 text-[10px] font-bold leading-none text-white">{{ $unread }}</span>
                    @endif
                </x-nav-link>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if($isClient)
                <a href="{{ route('client.problem.new') }}" class="btn btn-urgent btn-sm hidden sm:inline-flex">
                    <x-icon name="plus" class="h-4 w-4" /> Pedir ayuda
                </a>
            @else
                <span class="chip chip-ok hidden sm:inline-flex">
                    <span class="h-2 w-2 rounded-full bg-ok-500"></span> Disponible
                </span>
            @endif

            <x-dropdown align="right" width="w-56">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 rounded-full p-0.5 pr-2 transition hover:bg-ink-100 focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-100" aria-label="Menú de cuenta">
                        <x-avatar :name="$user->name" size="sm" />
                        <span class="hidden text-sm font-semibold text-ink-700 sm:block">{{ $user->name }}</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-3 pb-2 pt-2">
                        <div class="text-sm font-bold text-ink-900">{{ $user->name }} {{ $user->surname }}</div>
                        <div class="text-xs text-ink-400">{{ $isClient ? 'Cliente' : 'Técnico' }} · {{ $user->phone }}</div>
                    </div>
                    <div class="my-1 h-px bg-ink-100"></div>
                    <x-dropdown-link :href="route('profile.edit')">
                        <x-icon name="user" class="h-4 w-4" /> Mi perfil
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            <x-icon name="logout" class="h-4 w-4" /> Cerrar sesión
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
