<?php

namespace App\Livewire\About;

use App\Models\Officer;
use Livewire\Component;

class Officers extends Component
{
    public function render(): \Illuminate\View\View
    {
        $officers = Officer::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('livewire.about.officers', [
            'officers' => $officers,
        ])->layout('layouts.app');
    }
}
