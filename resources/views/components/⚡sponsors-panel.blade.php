<?php

use App\Models\Sponsor;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function sponsors()
    {
        $currentRoute = Route::currentRouteName();

        return Sponsor::query()
            ->where('is_active', true)
            ->where(function ($query) use ($currentRoute) {
                $query->where('show_on_all_pages', true)
                    ->when($currentRoute, function ($q) use ($currentRoute) {
                        $q->orWhereJsonContains('pages', $currentRoute);
                    });
            })
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function settings()
    {
        return Setting::first();
    }
};
?>

<div>
    @if($this->sponsors->isNotEmpty())
        <div class="container mx-auto px-4 mb-12">
            <section id="sponsor-panel" class="relative py-12 px-6 rounded-2xl shadow-sm border"
                     style="
                        --sponsor-panel-bg: {{ $this->settings?->sponsor_panel_bg_color ?? '#f3f4f6' }};
                        --sponsor-panel-bg-dark: {{ $this->settings?->sponsor_panel_bg_color_dark ?? $this->settings?->sponsor_panel_bg_color ?? '#1f2937' }};
                        background-color: var(--sponsor-panel-bg);
                        @if($this->settings?->sponsor_panel_pinstripe_color)
                            border-color: {{ $this->settings->sponsor_panel_pinstripe_color }};
                        @else
                            border-color: rgb(229 231 235);
                        @endif
                     ">
                <style>
                    #sponsor-panel {
                        --sponsor-card-bg: color-mix(in srgb, var(--sponsor-panel-bg), black 5%);
                        --sponsor-card-bg-dark: color-mix(in srgb, var(--sponsor-panel-bg-dark), white 5%);
                    }
                    @media (prefers-color-scheme: dark) {
                        #sponsor-panel {
                            background-color: var(--sponsor-panel-bg-dark) !important;
                        }
                    }
                </style>
                @if($this->settings?->sponsor_panel_pinstripe_color)
                    {{-- Top Pinstripe --}}
                    <div class="absolute top-0 left-0 w-full overflow-hidden rounded-t-2xl" style="height: 10px;">
                        <div class="w-full"
                             style="
                                background-color: {{ $this->settings->sponsor_panel_pinstripe_color }};
                                height: {{ match($this->settings->sponsor_panel_pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' } }};
                                @if($this->settings->sponsor_panel_pinstripe_style === 'double')
                                    border-top: 1px solid {{ $this->settings->sponsor_panel_pinstripe_color }};
                                    padding-top: 2px;
                                    background-clip: content-box;
                                    height: 5px;
                                @endif
                             ">
                        </div>
                    </div>
                    {{-- Bottom Pinstripe --}}
                    <div class="absolute bottom-0 left-0 w-full overflow-hidden rounded-b-2xl" style="height: 10px;">
                        <div class="absolute bottom-0 left-0 w-full"
                             style="
                                background-color: {{ $this->settings->sponsor_panel_pinstripe_color }};
                                height: {{ match($this->settings->sponsor_panel_pinstripe_width) { 'thin' => '1px', 'thick' => '4px', default => '2px' } }};
                                @if($this->settings->sponsor_panel_pinstripe_style === 'double')
                                    border-bottom: 1px solid {{ $this->settings->sponsor_panel_pinstripe_color }};
                                    padding-bottom: 2px;
                                    background-clip: content-box;
                                    height: 5px;
                                @endif
                             ">
                        </div>
                    </div>
                @endif

                <div class="px-4">
                    <h2 class="text-2xl font-bold text-center mb-8">Our Sponsors</h2>
                    <div class="flex flex-wrap justify-center gap-8 items-stretch">
                        @foreach($this->sponsors as $sponsor)
                        @php
                            $hasWebsite = !empty($sponsor->website);
                        @endphp
                        <div wire:key="sponsor-{{ $sponsor->id }}" class="flex w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.333%-1.334rem)] lg:w-[calc(25%-1.5rem)] max-w-sm transition-transform duration-300 hover:-translate-y-1">
                            @if($hasWebsite)
                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener noreferrer"
                                   class="flex flex-col items-center w-full p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg hover:border-gray-300 dark:hover:border-gray-600 group"
                                   style="background-color: var(--sponsor-card-bg);">
                            @else
                                <div class="flex flex-col items-center w-full p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg"
                                     style="background-color: var(--sponsor-card-bg);">
                            @endif
                                <style>
                                    @media (prefers-color-scheme: dark) {
                                        [wire\:key="sponsor-{{ $sponsor->id }}"] a,
                                        [wire\:key="sponsor-{{ $sponsor->id }}"] div {
                                            background-color: var(--sponsor-card-bg-dark) !important;
                                        }
                                    }
                                </style>
                                <div class="h-24 w-full flex items-center justify-center mb-4">
                                    <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="h-full w-auto object-contain grayscale @if($hasWebsite) group-hover:grayscale-0 @endif transition-all duration-300">
                                </div>

                                <h3 class="font-bold text-lg mb-2 text-center">{{ $sponsor->name }}</h3>

                                <div class="text-sm space-y-1 text-center">
                                    @if($sponsor->phone)
                                        <p>{{ $sponsor->phone }}</p>
                                    @endif

                                    @if($sponsor->address)
                                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $sponsor->address }}</p>
                                    @endif
                                </div>
                            @if($hasWebsite)
                                </a>
                            @else
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        </div>
    @else
        <div class="hidden"></div>
    @endif
</div>
