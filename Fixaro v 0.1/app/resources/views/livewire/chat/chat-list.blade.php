<div class="mx-auto max-w-3xl px-4 pt-5 sm:px-6 sm:pt-8">
    <h1 class="mb-5 text-2xl font-extrabold tracking-tight text-ink-900 sm:text-3xl">Mensajes</h1>

    @if($chats->isEmpty())
        <div class="card flex flex-col items-center px-6 py-12 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                <x-icon name="chat" class="h-7 w-7" />
            </span>
            <h3 class="mt-4 font-bold text-ink-900">Sin conversaciones todavía</h3>
            <p class="mt-1 max-w-xs text-sm text-ink-400">Cuando se acepte una oferta, el chat con el técnico o el cliente aparece acá.</p>
        </div>
    @else
        <div class="card divide-y divide-ink-100 overflow-hidden">
            @foreach($chats as $chat)
                @php
                    $iAmClient = Auth::id() === ($chat->problem->user_id ?? null);
                    $otherName = $iAmClient ? ($chat->professional->user->name ?? 'Técnico') : ($chat->problem->user->name ?? 'Cliente');
                    $unread = $chat->unread_count > 0;
                @endphp
                <a href="{{ route('chat', $chat->id) }}" wire:key="chat-{{ $chat->id }}" class="flex items-center gap-3 p-4 transition hover:bg-ink-50 {{ $unread ? 'bg-brand-50/40' : '' }}">
                    <div class="relative">
                        <x-avatar :name="$otherName" size="lg" />
                        <span class="absolute -bottom-1 -right-1 rounded-full ring-2 ring-white">
                            <x-trade-icon :category="$chat->problem->category ?? null" size="xs" />
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-2">
                            <h3 class="truncate font-bold text-ink-900">
                                {{ $otherName }}
                                <span class="font-medium text-ink-400">· {{ $chat->problem->category ?? '' }}</span>
                            </h3>
                            @if($chat->last_message)
                                <span class="shrink-0 text-[11px] font-medium {{ $unread ? 'text-brand-600' : 'text-ink-400' }}">{{ $chat->last_message->created_at->diffForHumans(null, true) }}</span>
                            @endif
                        </div>
                        <div class="mt-0.5 flex items-center justify-between gap-2">
                            <p class="truncate text-sm {{ $unread ? 'font-semibold text-ink-900' : 'text-ink-500' }}">
                                @if($chat->last_message)
                                    {{ $chat->last_message->sender_id === Auth::id() ? 'Vos: ' : '' }}{{ $chat->last_message->message }}
                                @else
                                    <span class="italic text-ink-400">Sin mensajes aún</span>
                                @endif
                            </p>
                            @if($unread)
                                <span class="flex h-5 min-w-[1.25rem] shrink-0 items-center justify-center rounded-full bg-urgent-500 px-1.5 text-[11px] font-bold text-white">{{ $chat->unread_count }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
