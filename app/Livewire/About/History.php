<?php

namespace App\Livewire\About;

use Livewire\Component;

class History extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.history')->layout('layouts.app', [
            'title' => 'Clarence Bowls Club History | Weston-super-Mare',
            'metaDescription' => 'Discover the rich history of Clarence Bowls Club, founded in 1907 in Weston-super-Mare.',
        ]);
    }
}
