<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Models\Response;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatWindow extends Component
{
    public $responseId;
    public $newMessage = '';
    public $messages = [];
    public $rating = 5;
    public $reviewComment = '';

    protected $rules = [
        'newMessage' => 'required|string|max:1000',
    ];

    public function mount($responseId)
    {
        $this->responseId = $responseId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $response = Response::findOrFail($this->responseId);

        if (!$response->involvesUser(Auth::id())) {
            abort(403, 'No tienes permiso para ver este chat.');
        }

        if ($response->status !== 'accepted') {
            abort(403, 'El chat solo está disponible para ofertas aceptadas.');
        }

        $this->messages = Message::where('response_id', $this->responseId)
                                 ->orderBy('created_at', 'asc')
                                 ->get()
                                 ->toArray();

        // Mark unread messages from other users as read
        Message::where('response_id', $this->responseId)
               ->where('sender_id', '!=', Auth::id())
               ->where('is_read', false)
               ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '') {
            return;
        }

        $this->validate();

        $response = Response::findOrFail($this->responseId);

        if (!$response->involvesUser(Auth::id())) {
            abort(403);
        }

        $messageContent = trim($this->newMessage);
        
        // Anti-duplicate check: don't allow exact same message twice within 2 seconds
        $lastMessage = Message::where('response_id', $this->responseId)
            ->where('sender_id', Auth::id())
            ->latest()
            ->first();

        if ($lastMessage && $lastMessage->message === $messageContent && $lastMessage->created_at->diffInSeconds() < 2) {
            $this->newMessage = '';
            return;
        }

        $this->newMessage = ''; 

        Message::create([
            'response_id' => $this->responseId,
            'sender_id' => Auth::id(),
            'message' => $messageContent,
        ]);

        $this->loadMessages();
        $this->dispatch('message-sent');
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function finishAndReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'reviewComment' => 'nullable|string|max:1000',
        ]);

        $response = Response::findOrFail($this->responseId);
        $problem = $response->problem;

        if ($problem->user_id !== Auth::id()) {
            abort(403);
        }

        $problem->status = 'resolved';
        $problem->save();

        if (!Review::where('problem_id', $problem->id)->exists()) {
            Review::create([
                'problem_id' => $problem->id,
                'client_id' => Auth::id(),
                'professional_id' => $response->professional_id,
                'rating' => $this->rating,
                'comment' => $this->reviewComment,
            ]);
        }

        session()->flash('success', '¡Trabajo finalizado! Gracias por tu calificación.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $response = Response::find($this->responseId);
        $isClient = false;
        $isResolved = false;

        if ($response) {
            $isClient = $response->problem->user_id === Auth::id();
            $isResolved = $response->problem->status === 'resolved';
        }

        return view('livewire.chat.chat-window', [
            'isClient' => $isClient,
            'isResolved' => $isResolved,
            'problem' => $response->problem,
        ])->layout('layouts.app');
    }
}
