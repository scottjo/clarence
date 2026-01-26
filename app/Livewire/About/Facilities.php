<?php

namespace App\Livewire\About;

use App\Models\Facility;
use Livewire\Component;

class Facilities extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.facilities', [
            'facilities' => Facility::orderBy('sort_order')->get(),
        ])->layout('layouts.app');
    }
}
