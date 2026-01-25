<?php

namespace App\Livewire;

use App\Models\Result;
use Livewire\Component;
use Livewire\WithPagination;

class ResultsList extends Component
{
    use WithPagination;

    public ?string $type = null;

    public int $perPage = 10;

    protected $queryString = ['type', 'perPage'];

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function updatedType(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Result::with('fixture')
            ->join('fixtures', 'results.fixture_id', '=', 'fixtures.id')
            ->select('results.*')
            ->orderByDesc('fixtures.date');

        if ($this->type) {
            $query->whereHas('fixture', function ($query) {
                $query->where('type', $this->type);
            });
        }

        return view('livewire.results-list', [
            'results' => $query->paginate($this->perPage),
        ])->layout('layouts.app');
    }
}
