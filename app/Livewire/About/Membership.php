<?php

namespace App\Livewire\About;

use App\Models\MembershipLevel;
use Livewire\Component;

class Membership extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.about.membership', [
            'levels' => MembershipLevel::orderBy('sort_order')->get(),
        ])->layout('layouts.app', [
            'title' => 'Membership',
            'metaDescription' => 'Join Clarence Bowls Club in Weston-super-Mare. Explore our membership types and benefits for the '.date('Y').' season.',
        ]);
    }
}
