<?php

namespace App\Livewire\About;

use App\Models\Facility;
use Illuminate\View\View;
use Livewire\Component;

class Facilities extends Component
{
    public function render(): View
    {
        return view('livewire.about.facilities', [
            'facilities' => Facility::orderBy('sort_order')->get(),
        ])->layout('layouts.app', [
            'title' => 'Facilities at Clarence Bowling Club | Weston-super-Mare',
        ]);
    }
}
