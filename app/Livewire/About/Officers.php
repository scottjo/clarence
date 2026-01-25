<?php

namespace App\Livewire\About;

use Livewire\Component;

class Officers extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.officers')->layout('layouts.app');
    }
}
