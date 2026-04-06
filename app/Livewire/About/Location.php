<?php

namespace App\Livewire\About;

use Livewire\Component;

class Location extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.location')->layout('layouts.app', [
            'title' => 'Where Is Clarence Bowls Club | Weston-super-Mare',
            'metaDescription' => 'Find us at Clarence Park in Weston-super-Mare. Get directions and see our location on the map.',
        ]);
    }
}
