<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\PinnedItem;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home', [
            'pinnedItems' => PinnedItem::where('is_active', true)
                ->with(['newsArticle', 'media'])
                ->latest()
                ->get(),
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
        ])->layout('layouts.app', [
            'title' => 'Lawn Bowls Club in Weston-super-Mare | Clarence Bowls Club',
        ]);
    }
}
