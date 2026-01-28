<?php

namespace App\Livewire\About;

use App\Models\Officer;
use Livewire\Component;

class Officers extends Component
{
    public function render(): \Illuminate\View\View
    {
        $officers = Officer::query()
            ->with('classification')
            ->where('is_active', true)
            ->get();

        $groups = $officers
            ->sortBy([
                fn ($a, $b) => ($a->classification?->sort_order ?? 9999) <=> ($b->classification?->sort_order ?? 9999),
                fn ($a, $b) => ($a->classification?->name ?? '') <=> ($b->classification?->name ?? ''),
                fn ($a, $b) => ($a->sort_order ?? 0) <=> ($b->sort_order ?? 0),
            ])
            ->groupBy(fn ($officer) => $officer->classification_id ?? 0);

        return view('livewire.about.officers', [
            'groups' => $groups,
        ])->layout('layouts.app');
    }
}
