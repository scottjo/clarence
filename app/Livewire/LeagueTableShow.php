<?php

namespace App\Livewire;

use App\Models\League;
use Illuminate\View\View;
use Livewire\Component;

class LeagueTableShow extends Component
{
    public League $league;

    public ?string $season = null;

    public function mount(League $league, ?string $season = null): void
    {
        if (! $league->is_active) {
            abort(404);
        }

        $this->league = $league;
        $this->season = $season ?? $league->standings()->max('season');
    }

    public function render(): View
    {
        $standings = $this->league->standings()
            ->where('season', $this->season)
            ->get();

        $allSeasons = $this->league->standings()
            ->select('season')
            ->distinct()
            ->reorder()
            ->orderByDesc('season')
            ->pluck('season');

        return view('livewire.league-table-show', [
            'standings' => $standings,
            'allSeasons' => $allSeasons,
        ])->layout('layouts.app', [
            'title' => $this->league->name.($this->season ? " ({$this->season})" : '').' - League Table',
        ]);
    }
}
