<?php

namespace App\Livewire;

use App\Models\CompetitionResult;
use App\Models\Event;
use App\Models\NewsArticle;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchResults extends Component
{
    #[Url(as: 'q')]
    public string $search = '';

    public function mount(): void
    {
        $this->search = Str::limit($this->search, 100, '');
    }

    public function render(): \Illuminate\View\View
    {
        $newsResults = collect();
        $eventResults = collect();
        $officerResults = collect();
        $fixtureResults = collect();
        $resultResults = collect();
        $winnerResults = collect();

        if (! empty($this->search)) {
            $newsResults = NewsArticle::where('is_active', true)
                ->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('content', 'like', "%{$this->search}%");
                })
                ->latest('published_at')
                ->get();

            $eventResults = Event::where('is_active', true)
                ->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->where('start_time', '>=', now())
                ->orderBy('start_time')
                ->get();

            $officerResults = \App\Models\Officer::where('is_active', true)
                ->where('name', 'like', "%{$this->search}%")
                ->orderBy('sort_order')
                ->get();

            $fixtureResults = \App\Models\Fixture::where(function ($query) {
                $query->where('opponent', 'like', "%{$this->search}%")
                    ->orWhere('venue', 'like', "%{$this->search}%")
                    ->orWhere('competition', 'like', "%{$this->search}%")
                    ->orWhere('notes', 'like', "%{$this->search}%");
            })
                ->orderBy('date', 'desc')
                ->get();

            $resultResults = \App\Models\Result::whereHas('fixture', function ($query) {
                $query->where('opponent', 'like', "%{$this->search}%");
            })
                ->orWhere('summary', 'like', "%{$this->search}%")
                ->with('fixture')
                ->latest()
                ->get();

            $winnerResults = CompetitionResult::where(function ($query) {
                $query->whereHas('competition', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhere('winner_name', 'like', "%{$this->search}%");
            })
                ->with('competition')
                ->orderBy('year', 'desc')
                ->get()
                ->groupBy(fn ($result) => $result->year.'-'.$result->competition_id.'-'.$result->category)
                ->map(function ($results) {
                    $first = $results->first();

                    return (object) [
                        'year' => $first->year,
                        'competition' => $first->competition,
                        'category' => $first->category,
                        'no_competition' => $first->no_competition,
                        'winner_names' => $results->pluck('winner_name')->filter()->implode(', '),
                    ];
                });
        }

        return view('livewire.search-results', [
            'newsResults' => $newsResults,
            'eventResults' => $eventResults,
            'officerResults' => $officerResults,
            'fixtureResults' => $fixtureResults,
            'resultResults' => $resultResults,
            'winnerResults' => $winnerResults,
        ])->layout('layouts.app', ['title' => 'Search Results']);
    }
}
