<?php

namespace App\Livewire\About;

use App\Models\CompetitionWinner;
use App\Models\Setting;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class CompetitionWinners extends Component
{
    #[Url]
    public ?int $year = null;

    public function mount(): void
    {
        if (! $this->year) {
            $this->year = $this->availableYears->first() ?? (int) date('Y');
        }
    }

    #[Computed]
    public function availableYears()
    {
        return CompetitionWinner::query()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
    }

    #[Computed]
    public function menWinners()
    {
        return $this->getWinnersByCategory('Men');
    }

    #[Computed]
    public function ladiesWinners()
    {
        return $this->getWinnersByCategory('Ladies');
    }

    protected function getWinnersByCategory(string $category)
    {
        return CompetitionWinner::query()
            ->where('year', $this->year)
            ->whereHas('competition', function ($query) use ($category) {
                $query->where(function ($q) use ($category) {
                    $q->where('category', $category)
                        ->orWhere('category', 'Both');
                });
            })
            ->where(function ($query) use ($category) {
                $query->whereNull('category')
                    ->orWhere('category', $category);
            })
            ->with('competition')
            ->get()
            ->sortBy(fn ($winner) => $winner->competition->sort_order);
    }

    #[Computed]
    public function settings()
    {
        return Setting::first();
    }

    public function render(): View
    {
        return view('livewire.about.competition-winners')
            ->layout('layouts.app', [
                'title' => "Club Competition Winners {$this->year}",
                'metaDescription' => "View the club competition winners for {$this->year} at Clarence Bowls Club.",
            ]);
    }
}
