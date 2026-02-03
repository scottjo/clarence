@php
    $settings = $this->settings;
@endphp
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <h1 class="text-4xl font-bold">Club Competition Winners</h1>

        <div class="flex items-center gap-2">
            <label for="year" class="font-semibold text-gray-700 dark:text-gray-300">Select Year:</label>
            <select wire:model.live="year" id="year" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-blue-500 focus:ring-blue-500">
                @foreach($this->availableYears as $availYear)
                    <option value="{{ $availYear }}">{{ $availYear }}</option>
                @endforeach
                @if($this->availableYears->isEmpty())
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8"
         style="
            --winner-bg: {{ $settings?->winner_col_bg ?? '#ffffff' }};
            --winner-bg-dark: {{ $settings?->winner_col_bg_dark ?? '#1f2937' }};
            --winner-stripe: color-mix(in srgb, var(--winner-bg), black 5%);
            --winner-stripe-dark: color-mix(in srgb, var(--winner-bg-dark), white 5%);
         ">
        <style>
            .winner-table tr:nth-child(odd) {
                background-color: var(--winner-stripe);
            }
            @media (prefers-color-scheme: dark) {
                .winner-table tr:nth-child(odd) {
                    background-color: var(--winner-stripe-dark) !important;
                }
            }
        </style>
        {{-- Men's Competition --}}
        <div>
            <h2 class="text-2xl font-bold mb-4 text-center">Men</h2>
            <div class="overflow-hidden rounded-lg shadow border border-gray-200 dark:border-gray-700"
                 style="background-color: var(--winner-bg);">
                 <style>
                    @media (prefers-color-scheme: dark) {
                        .men-container {
                            background-color: var(--winner-bg-dark) !important;
                        }
                    }
                 </style>
                 <div class="men-container h-full">
                    <table class="w-full text-left border-collapse winner-table">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 font-bold uppercase tracking-wider text-sm"
                                    style="color: {{ $settings?->winner_comp_text_color ?? '#374151' }};">
                                    Competition
                                    <style>
                                        @media (prefers-color-scheme: dark) {
                                            .comp-header { color: {{ $settings?->winner_comp_text_color_dark ?? '#d1d5db' }} !important; }
                                        }
                                    </style>
                                </th>
                                <th class="px-6 py-3 font-bold uppercase tracking-wider text-sm"
                                    style="color: {{ $settings?->winner_name_text_color ?? '#374151' }};">
                                    Winner(s)
                                    <style>
                                        @media (prefers-color-scheme: dark) {
                                            .name-header { color: {{ $settings?->winner_name_text_color_dark ?? '#d1d5db' }} !important; }
                                        }
                                    </style>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($this->menWinners as $winner)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 @if($winner->competition->is_important) text-lg font-bold @else text-sm @endif"
                                        style="color: {{ $settings?->winner_comp_text_color ?? 'inherit' }};">
                                        <style>
                                            @media (prefers-color-scheme: dark) {
                                                .winner-row-{{ $winner->id }}-comp { color: {{ $settings?->winner_comp_text_color_dark ?? 'inherit' }} !important; }
                                            }
                                        </style>
                                        <span class="winner-row-{{ $winner->id }}-comp">{{ $winner->competition->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 @if($winner->competition->is_important) text-lg font-bold @else text-sm @endif"
                                        style="color: {{ $settings?->winner_name_text_color ?? 'inherit' }};">
                                        <style>
                                            @media (prefers-color-scheme: dark) {
                                                .winner-row-{{ $winner->id }}-name { color: {{ $settings?->winner_name_text_color_dark ?? 'inherit' }} !important; }
                                            }
                                        </style>
                                        <span class="winner-row-{{ $winner->id }}-name">
                                            @if($winner->no_competition)
                                                <span class="italic opacity-75">No Competition</span>
                                            @else
                                                {{ collect($winner->names)->pluck('name')->implode(', ') }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-gray-500 italic">No records found for this year.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>

        {{-- Ladies Competition --}}
        <div>
            <h2 class="text-2xl font-bold mb-4 text-center">Ladies</h2>
            <div class="overflow-hidden rounded-lg shadow border border-gray-200 dark:border-gray-700"
                 style="background-color: var(--winner-bg);">
                 <div class="ladies-container h-full">
                    <style>
                        @media (prefers-color-scheme: dark) {
                            .ladies-container {
                                background-color: var(--winner-bg-dark) !important;
                            }
                        }
                    </style>
                    <table class="w-full text-left border-collapse winner-table">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-3 font-bold uppercase tracking-wider text-sm"
                                    style="color: {{ $settings?->winner_comp_text_color ?? '#374151' }};">
                                    Competition
                                </th>
                                <th class="px-6 py-3 font-bold uppercase tracking-wider text-sm"
                                    style="color: {{ $settings?->winner_name_text_color ?? '#374151' }};">
                                    Winner(s)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($this->ladiesWinners as $winner)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 @if($winner->competition->is_important) text-lg font-bold @else text-sm @endif"
                                        style="color: {{ $settings?->winner_comp_text_color ?? 'inherit' }};">
                                        <style>
                                            @media (prefers-color-scheme: dark) {
                                                .winner-row-{{ $winner->id }}-comp { color: {{ $settings?->winner_comp_text_color_dark ?? 'inherit' }} !important; }
                                            }
                                        </style>
                                        <span class="winner-row-{{ $winner->id }}-comp">{{ $winner->competition->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 @if($winner->competition->is_important) text-lg font-bold @else text-sm @endif"
                                        style="color: {{ $settings?->winner_name_text_color ?? 'inherit' }};">
                                        <style>
                                            @media (prefers-color-scheme: dark) {
                                                .winner-row-{{ $winner->id }}-name { color: {{ $settings?->winner_name_text_color_dark ?? 'inherit' }} !important; }
                                            }
                                        </style>
                                        <span class="winner-row-{{ $winner->id }}-name">
                                            @if($winner->no_competition)
                                                <span class="italic opacity-75">No Competition</span>
                                            @else
                                                {{ collect($winner->names)->pluck('name')->implode(', ') }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-gray-500 italic">No records found for this year.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                 </div>
            </div>
        </div>
    </div>
</div>
