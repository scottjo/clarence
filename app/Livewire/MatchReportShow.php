<?php

namespace App\Livewire;

use App\Models\MatchReport;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class MatchReportShow extends Component
{
    public MatchReport $report;

    public function mount(MatchReport $report)
    {
        $this->report = $report;

        if (! $report->is_published) {
            abort(404);
        }

        // Mark as viewed
        $viewedReports = Session::get('viewed_match_reports', []);
        if (! in_array($report->id, $viewedReports)) {
            $viewedReports[] = $report->id;
            Session::put('viewed_match_reports', $viewedReports);
        }
    }

    public function render()
    {
        return view('livewire.match-report-show', [
            'report' => $this->report,
        ])->layout('layouts.app', [
            'title' => $this->report->title.' | Match Report | Clarence Bowls Club',
        ]);
    }
}
