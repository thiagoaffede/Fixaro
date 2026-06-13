<?php

namespace App\Livewire\Professional;

use App\Models\Problem;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProblemFeed extends Component
{
    public $isModalOpen = false;
    
    public $selectedProblemId = null;
    public $offerPrice = '';
    public $offerTime = '';
    public $offerMessage = '';

    protected $rules = [
        'offerPrice' => 'required|numeric|min:0',
        'offerTime' => 'required|string|max:255',
        'offerMessage' => 'required|string|max:1000',
    ];

    public function openOfferModal($problemId)
    {
        $this->resetValidation();
        $this->selectedProblemId = $problemId;
        $this->offerPrice = '';
        $this->offerTime = '';
        $this->offerMessage = '';
        $this->isModalOpen = true;
    }

    public function closeOfferModal()
    {
        $this->isModalOpen = false;
        $this->selectedProblemId = null;
    }

    public function submitOffer()
    {
        $this->validate();

        $professionalId = Auth::user()->professional->id;

        // Verify the problem is still open and we haven't already responded
        $problem = Problem::where('id', $this->selectedProblemId)->where('status', 'open')->first();
        
        if (!$problem) {
            session()->flash('error', 'El problema ya no está disponible.');
            $this->closeOfferModal();
            return;
        }

        $existingResponse = Response::where('problem_id', $this->selectedProblemId)
                                    ->where('professional_id', $professionalId)
                                    ->exists();

        if ($existingResponse) {
            session()->flash('error', 'Ya has enviado una oferta para este problema.');
            $this->closeOfferModal();
            return;
        }

        // Create the response
        Response::create([
            'problem_id' => $this->selectedProblemId,
            'professional_id' => $professionalId,
            'price_estimate' => $this->offerPrice,
            'time_estimate' => $this->offerTime,
            'message' => $this->offerMessage,
            'status' => 'pending'
        ]);

        session()->flash('success', 'Tu oferta ha sido enviada con éxito.');
        $this->closeOfferModal();
    }

    public function render()
    {
        $user = Auth::user();
        $professional = $user->professional;

        // Get professional's configured categories (professions)
        $professions = $professional->professions ?? [];

        // Fetch open problems matching categories, ordered by urgency and recency
        $problems = Problem::whereIn('category', $professions)
                            ->where('status', 'open')
                            // optionally exclude problems we already responded to
                            ->whereDoesntHave('responses', function($query) use ($professional) {
                                $query->where('professional_id', $professional->id);
                            })
                            ->orderByDesc('is_urgent')
                            ->orderByDesc('created_at')
                            ->get();

        $activeJobs = Response::with('problem.client')
                              ->where('professional_id', $professional->id)
                              ->where('status', 'accepted')
                              ->whereHas('problem', fn($q) => $q->where('status', 'assigned'))
                              ->orderByDesc('updated_at')
                              ->get();

        $completedJobs = Response::with(['problem.client', 'problem.reviews'])
                                ->where('professional_id', $professional->id)
                                ->where('status', 'accepted')
                                ->whereHas('problem', fn($q) => $q->where('status', 'resolved'))
                                ->orderByDesc('updated_at')
                                ->get();

        return view('livewire.professional.problem-feed', [
            'problems' => $problems,
            'activeJobs' => $activeJobs,
            'completedJobs' => $completedJobs,
        ]);
    }
}
