<?php

namespace App\Livewire\About;

use App\Models\HealthSafetyPage;
use Illuminate\View\View;
use Livewire\Component;

class HealthSafetyShow extends Component
{
    public HealthSafetyPage $healthSafetyPage;

    public function mount(HealthSafetyPage $healthSafetyPage): void
    {
        abort_unless($healthSafetyPage->is_active, 404);
        $this->healthSafetyPage = $healthSafetyPage->load('media');
    }

    public function render(): View
    {
        return view('livewire.about.health-safety-show')->layout('layouts.app', [
            'title' => $this->healthSafetyPage->title.' | Club Health & Safety',
        ]);
    }
}
