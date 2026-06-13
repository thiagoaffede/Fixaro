<?php

namespace App\Livewire\Client;

use App\Models\Problem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubmitReview extends Component
{
    public $problemId;
    public $rating = 5;
    public $comment = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount($problemId)
    {
        $this->problemId = $problemId;
        
        $problem = Problem::findOrFail($this->problemId);
        
        // Ensure user is the client who owns the problem
        if ($problem->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure problem is resolved
        if ($problem->status !== 'resolved') {
            abort(403, 'El trabajo aún no ha sido marcado como terminado.');
        }

        // Check if review already exists
        if (Review::where('problem_id', $this->problemId)->exists()) {
            session()->flash('info', 'Ya has calificado este trabajo.');
            $this->redirect(route('dashboard'));
        }
    }

    public function submit()
    {
        $this->validate();

        $problem = Problem::with('responses')->findOrFail($this->problemId);
        
        // Find the accepted response to know which professional to review
        $acceptedResponse = $problem->responses->where('status', 'accepted')->first();

        if (!$acceptedResponse) {
            abort(400, 'No se encontró la oferta aceptada para este problema.');
        }

        Review::create([
            'problem_id' => $problem->id,
            'client_id' => Auth::id(),
            'professional_id' => $acceptedResponse->professional_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        session()->flash('success', '¡Gracias por calificar el trabajo! Tu opinión ayuda a mantener la calidad de Fixaro.');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.client.submit-review')
               ->layout('layouts.app');
    }
}
