<?php

namespace App\Livewire\About;

use Livewire\Component;

class PlayLearn extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.play-learn')->layout('layouts.app');
    }
}
