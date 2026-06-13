<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatList extends Component
{
    public function render()
    {
        $userId = Auth::id();

        $chats = Response::where('status', 'accepted')
            ->where(function ($query) use ($userId) {
                $query->whereHas('professional', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('problem', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->with(['problem', 'professional.user', 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get()
            ->map(function ($chat) use ($userId) {
                $chat->unread_count = Message::where('response_id', $chat->id)
                    ->where('sender_id', '!=', $userId)
                    ->where('is_read', false)
                    ->count();
                
                $chat->last_message = $chat->messages->first();
                
                return $chat;
            })
            ->sortByDesc(function ($chat) {
                return $chat->last_message ? $chat->last_message->created_at : $chat->created_at;
            });

        return view('livewire.chat.chat-list', [
            'chats' => $chats
        ])->layout('layouts.app');
    }
}
