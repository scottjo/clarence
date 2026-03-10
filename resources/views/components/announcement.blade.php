@props(['announcement'])

@php
    $colors = [
        'info' => 'bg-blue-100 text-blue-800 border-blue-200',
        'success' => 'bg-green-100 text-green-800 border-green-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'danger' => 'bg-red-100 text-red-800 border-red-200',
    ];

    $colorClass = $colors[$announcement->type] ?? $colors['info'];
@endphp

<div class="container mx-auto px-4 py-4 relative z-40">
    <div class="{{ $colorClass }} rounded-lg border shadow-sm px-4 py-3 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div class="flex items-center">
                <div>
                    <p class="font-bold text-lg leading-none">{{ $announcement->header }}</p>
                    <p class="mt-1 font-medium">{{ $announcement->text }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
