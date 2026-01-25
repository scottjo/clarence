<?php

namespace App\Livewire\About;

use Livewire\Component;

class Membership extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.membership')->layout('layouts.app');
    }
}
