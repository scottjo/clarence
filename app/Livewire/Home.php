<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\NewsArticle;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'latestNews' => NewsArticle::where('is_active', true)
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->take(3)
                ->get(),
            'upcomingEvents' => Event::where('is_active', true)
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->take(3)
                ->get(),
        ])->layout('layouts.app');
    }
}
