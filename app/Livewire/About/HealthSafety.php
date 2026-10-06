<?php

namespace App\Livewire\About;

use App\Models\HealthSafetyPage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class HealthSafety extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.about.health-safety', [
            'pages' => HealthSafetyPage::query()->with('media')->where('is_active', true)->latest()->paginate(12),
        ])->layout('layouts.app', ['title' => 'Club Health & Safety | Clarence Bowling Club']);
    }
}
