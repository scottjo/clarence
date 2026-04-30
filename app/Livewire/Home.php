<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\MatchReport;
use App\Models\NewsArticle;
use App\Models\PinnedItem;
use App\Models\Setting;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $settings = Setting::first();

        $latestMatchReports = collect();
        if ($settings?->show_match_reports ?? false) {
            $viewedReports = session()->get('viewed_match_reports', []);
            $latestMatchReports = MatchReport::where('is_published', true)
                ->whereNotIn('id', $viewedReports)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('livewire.home', [
            'pinnedItems' => PinnedItem::where('is_active', true)
                ->with(['newsArticle', 'media'])
                ->latest()
                ->get(),
            'latestNews' => NewsArticle::where('is_active', true)
                ->where('is_members_only', false)
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->take(3)
                ->get(),
            'upcomingEvents' => Event::where('is_active', true)
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->take(3)
                ->get(),
            'latestMatchReports' => $latestMatchReports,
        ])->layout('layouts.app', [
            'title' => 'Lawn Bowls Club in Weston-super-Mare | Clarence Bowls Club',
        ]);
    }
}
