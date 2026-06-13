<?php

namespace App\Livewire\Client;

use App\Models\Problem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmitProblem extends Component
{
    use WithFileUploads;

    public $step = 1;

    // Form fields
    public $photo;
    public $description = '';
    public $location = '';
    public $address = '';
    public $lat = null;
    public $lng = null;
    public $is_urgent = false;
    public $category = null;

    // Available locations (MVP static list)
    public $availableLocations = [
        'Palermo', 'Belgrano', 'Caballito', 'Recoleta', 'Villa Crespo', 'Almagro', 'Microcentro', 'Otro'
    ];

    protected $rules = [
        1 => [
            'photo' => 'nullable|image|max:5120', // 5MB max
        ],
        2 => [
            'description' => 'required|string|min:10',
        ],
        3 => [
            'address' => 'required|string',
            'location' => 'nullable|string', // Keep for compatibility
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'category' => 'required|string', // Ensure category is confirmed
        ]
    ];

    public function nextStep()
    {
        // For step 3, we don't call nextStep from the UI, we call submit()
        $this->validate($this->rules[$this->step]);
        
        if ($this->step == 2) {
            $this->autoCategorize();
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    private function autoCategorize()
    {
        // Basic heuristic keyword mapping
        $keywords = [
            'Plomero' => ['agua', 'caño', 'inodoro', 'pileta', 'fuga', 'gotea', 'humedad', 'baño', 'canilla', 'filtracion'],
            'Electricista' => ['luz', 'enchufe', 'cable', 'cortocircuito', 'tablero', 'termica', 'lampara'],
            'Gasista' => ['gas', 'estufa', 'calefon', 'termotanque', 'olor', 'hornalla'],
            'Cerrajero' => ['llave', 'cerradura', 'puerta', 'trabo', 'candado', 'abrir'],
            'Albañil' => ['pared', 'techo', 'piso', 'ceramica', 'revoque', 'pintura', 'grieta'],
            'Aire Acondicionado' => ['aire', 'acondicionado', 'enfria', 'calienta', 'split'],
        ];

        $desc = strtolower($this->description);
        
        foreach ($keywords as $cat => $words) {
            foreach ($words as $word) {
                if (str_contains($desc, $word)) {
                    $this->category = $cat;
                    return;
                }
            }
        }

        $this->category = 'General';
    }

    public function submit()
    {
        $this->validate($this->rules[3]);

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('problems', 'public');
        }

        $problem = new Problem([
            'user_id' => Auth::id(),
            'description' => $this->description,
            'category' => $this->category,
            'photo_path' => $photoPath,
            'location' => $this->location ?: 'Buenos Aires', // Fallback
            'is_urgent' => $this->is_urgent,
            'address' => $this->address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'status' => 'open'
        ]);

        // Generate the approximate coordinates before saving
        $problem->generateApproximateCoordinates();
        $problem->save();

        // Redirect to dashboard or problem detail
        return redirect()->route('dashboard')->with('success', 'Tu problema ha sido publicado y los profesionales han sido notificados.');
    }

    public function render()
    {
        return view('livewire.client.submit-problem');
    }
}
