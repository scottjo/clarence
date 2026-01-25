<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class EventsList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.events-list', [
            'events' => Event::where('is_active', true)
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->paginate(9),
        ])->layout('layouts.app');
    }
}
