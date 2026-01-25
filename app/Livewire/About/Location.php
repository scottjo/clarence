<?php

namespace App\Livewire\About;

use Livewire\Component;

class Location extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.location')->layout('layouts.app');
    }
}
