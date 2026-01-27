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
            ->leftJoin('officer_classifications', 'officers.classification_id', '=', 'officer_classifications.id')
            ->where('officers.is_active', true)
            ->orderByRaw('COALESCE(officer_classifications.sort_order, 9999) ASC')
            ->orderBy('officer_classifications.name', 'ASC')
            ->orderBy('officers.sort_order', 'ASC')
            ->select('officers.*')
            ->get();

        $groups = $officers->groupBy(function ($officer) {
            return $officer->classification_id ?? 0;
        });

        return view('livewire.about.officers', [
            'groups' => $groups,
        ])->layout('layouts.app');
    }
}
