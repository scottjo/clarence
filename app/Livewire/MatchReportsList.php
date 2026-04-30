<?php

namespace App\Livewire;

use App\Models\MatchReport;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class MatchReportsList extends Component
{
    use WithPagination;

    public $team = '';

    public $year = '';

    public $perPage = 10;

    protected $queryString = ['team', 'year', 'perPage'];

    public function updatedTeam(): void
    {
        $this->resetPage();
    }

    public function updatedYear(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = MatchReport::query()
            ->where('is_published', true)
            ->latest('created_at');

        if ($this->team) {
            $query->where('team', $this->team);
        }

        if ($this->year) {
            $query->where('year', $this->year);
        }

        $reports = $query->paginate($this->perPage);

        // Get viewed reports from session
        $viewedReports = Session::get('viewed_match_reports', []);

        return view('livewire.match-reports-list', [
            'reports' => $reports,
            'teams' => MatchReport::query()->where('is_published', true)->distinct()->pluck('team'),
            'years' => MatchReport::query()->where('is_published', true)->distinct()->pluck('year')->sortDesc(),
            'viewedReports' => $viewedReports,
        ])->layout('layouts.app', [
            'title' => 'Match Reports | Clarence Bowls Club',
        ]);
    }
}
