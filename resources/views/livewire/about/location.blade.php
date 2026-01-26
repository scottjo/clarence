<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6">Location</h1>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <p class="text-lg mb-4">Visit us at our beautiful greens in the heart of the community.</p>
        <div class="aspect-video bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
            @if($settings?->latitude && $settings?->longitude)
                <iframe
                    width="100%"
                    height="100%"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $settings->longitude - 0.005 }}%2C{{ $settings->latitude - 0.002 }}%2C{{ $settings->longitude + 0.005 }}%2C{{ $settings->latitude + 0.002 }}&amp;layer=mapnik&amp;marker={{ $settings->latitude }}%2C{{ $settings->longitude }}"
                    style="border: 0"
                ></iframe>
            @else
                <div class="flex items-center justify-center h-full">
                    <span class="text-gray-500 dark:text-gray-400">[Map Placeholder - Please set Latitude and Longitude in Settings]</span>
                </div>
            @endif
        </div>
        <div class="mt-6">
            <h2 class="text-2xl font-semibold mb-2">Address</h2>
            <p class="font-semibold">{{ $settings?->club_name ?? 'Clarence Bowls Club' }}</p>
            @if($settings?->address)
                <p class="whitespace-pre-line">{{ $settings->address }}</p>
            @else
                <p>Clarence Park</p>
                <p>Clarence Road South</p>
                <p>Weston Super Mare</p>
                <p>BS23 4BN</p>
            @endif
        </div>
    </div>
</div>
