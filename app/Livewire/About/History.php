<?php

namespace App\Livewire\About;

use Illuminate\View\View;
use Livewire\Component;

class History extends Component
{
    public function render(): View
    {
        return view('livewire.about.history')->layout('layouts.app', [
            'title' => 'Clarence Bowling Club History | Weston-super-Mare',
            'metaDescription' => 'Discover the rich history of Clarence Bowling Club, founded in 1907 in Weston-super-Mare.',
        ]);
    }
}
