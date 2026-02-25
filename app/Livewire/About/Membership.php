<?php

namespace App\Livewire\About;

use App\Models\MembershipLevel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Membership extends Component
{
    public function render(): \Illuminate\View\View
    {
        $formUrl = null;
        $settings = config('settings');

        if ($settings?->membership_application_form) {
            try {
                $disk = Storage::disk('public');
                $path = $settings->membership_application_form;

                if ($disk->exists($path)) {
                    $formUrl = $disk->url($path);
                    // Add cache-busting parameter based on last modified time
                    $timestamp = $disk->lastModified($path);
                    $formUrl .= "?v={$timestamp}";
                }
            } catch (\Exception $e) {
                // Fail gracefully
                $formUrl = null;
            }
        }

        return view('livewire.about.membership', [
            'levels' => MembershipLevel::orderBy('sort_order')->get(),
            'formUrl' => $formUrl,
        ])->layout('layouts.app', [
            'title' => 'Membership',
            'metaDescription' => 'Join Clarence Bowls Club in Weston-super-Mare. Explore our membership types and benefits for the '.date('Y').' season.',
        ]);
    }
}
