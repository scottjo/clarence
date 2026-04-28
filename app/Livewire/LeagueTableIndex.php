<?php

namespace App\Livewire;

use App\Models\League;
use Illuminate\View\View;
use Livewire\Component;

class LeagueTableIndex extends Component
{
    public function render(): View
    {
        $leagues = League::where('is_active', true)
            ->with(['standings' => function ($query) {
                $query->select('league_id', 'season')
                    ->distinct()
                    ->orderByDesc('season');
            }])
            ->orderBy('sort_order')
            ->get();

        return view('livewire.league-table-index', [
            'leagues' => $leagues,
        ])->layout('layouts.app', [
            'title' => 'League Tables',
        ]);
    }
}
