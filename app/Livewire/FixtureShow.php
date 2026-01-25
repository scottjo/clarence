<?php

namespace App\Livewire;

use App\Models\Fixture;
use Livewire\Component;

class FixtureShow extends Component
{
    public Fixture $fixture;

    public function mount(Fixture $fixture): void
    {
        $this->fixture = $fixture;
    }

    public function render()
    {
        return view('livewire.fixture-show')
            ->layout('layouts.app');
    }
}
