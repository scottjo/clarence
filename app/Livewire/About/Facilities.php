<?php

namespace App\Livewire\About;

use Livewire\Component;

class Facilities extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.facilities')->layout('layouts.app');
    }
}
