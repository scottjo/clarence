<?php

namespace App\Livewire\About;

use Livewire\Component;

class History extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.history')->layout('layouts.app', [
            'title' => 'Club History',
            'metaDescription' => 'Discover the rich history of Clarence Bowls Club, founded in 1912 in Weston-super-Mare.',
        ]);
    }
}
