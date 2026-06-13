<?php

namespace App\Livewire\Client;

use App\Models\Problem;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClientDashboard extends Component
{
    public function acceptOffer($responseId)
    {
        $response = Response::findOrFail($responseId);

        // Security check: ensure the response belongs to a problem owned by the logged-in client
        if ($response->problem->user_id !== Auth::id()) {
            abort(403);
        }

        // 1. Mark this response as accepted
        $response->update(['status' => 'accepted']);

        // 2. Mark the problem as assigned
        $response->problem->update(['status' => 'assigned']);

        // 3. Mark all other responses for this problem as ignored
        Response::where('problem_id', $response->problem_id)
                ->where('id', '!=', $responseId)
                ->update(['status' => 'ignored']);

        session()->flash('success', '¡Oferta aceptada! Ahora puedes chatear con el profesional.');
    }

    public function render()
    {
        // Get all problems for the logged-in client, ordered by latest
        $problems = Problem::where('user_id', Auth::id())
                            ->with(['responses.professional.user'])
                            ->orderByDesc('created_at')
                            ->get();

        return view('livewire.client.client-dashboard', [
            'problems' => $problems
        ]);
    }
}
