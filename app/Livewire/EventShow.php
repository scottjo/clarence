<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class EventShow extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        if (! $event->is_active) {
            abort(404);
        }
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.event-show')->layout('layouts.app', ['title' => $this->event->title]);
    }
}
