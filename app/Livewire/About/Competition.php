<?php

namespace App\Livewire\About;

use Illuminate\View\View;
use Livewire\Component;

class Competition extends Component
{
    public function render(): View
    {
        return view('livewire.about.competition')->layout('layouts.app', [
            'title' => 'Competitions at Clarence Bowling Club | Weston-super-Mare',
        ]);
    }
}
