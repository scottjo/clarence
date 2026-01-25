<?php

namespace App\Livewire\About;

use Livewire\Component;

class Competition extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.competition')->layout('layouts.app');
    }
}
