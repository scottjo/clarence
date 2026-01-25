<?php

namespace App\Livewire;

use App\Enums\FixtureType;
use App\Models\Fixture;
use Livewire\Component;
use Livewire\WithPagination;

class FixturesList extends Component
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

    public function mount(): void
    {
        if (! $this->type) {
            $this->type = FixtureType::Men->value;
        }
    }

    public function render()
    {
        return view('livewire.fixtures-list', [
            'fixtures' => Fixture::query()
                ->where('type', $this->type)
                ->where('date', '>=', now())
                ->orderBy('date')
                ->paginate($this->perPage),
        ])->layout('layouts.app');
    }
}
