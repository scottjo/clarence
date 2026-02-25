<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-6">Membership</h1>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <h2 class="text-2xl font-bold mb-4">Join Clarence Bowls Club</h2>
            <p class="text-lg mb-6">We welcome new members of all ages and abilities, whether you're an experienced bowler or a complete beginner.</p>

            <h3 class="text-xl font-bold mb-4">Membership Types ({{ date('Y') }} Season)</h3>
            <div @class([
                'grid gap-6 mb-8',
                'grid-cols-1 md:grid-cols-3' => $levels->count() <= 3,
                'grid-cols-1 md:grid-cols-2 lg:grid-cols-4' => $levels->count() >= 4,
            ])>
                @foreach($levels as $level)
                    <div class="border dark:border-gray-700 rounded-lg p-6 text-center" wire:key="membership-level-{{ $level->id }}">
                        <h4 class="font-bold text-xl mb-2">{{ $level->name }}</h4>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-4">£{{ number_format($level->cost, 0) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $level->benefits }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-lg">
                <h3 class="text-xl font-bold mb-3">How to Apply</h3>
                <p class="mb-4">Membership applications are open year-round. You can download an application form below or pick one up from the clubhouse.</p>
                @if($formUrl)
                    <a href="{{ $formUrl }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">Download Application Form</a>
                @else
                    <button disabled class="bg-gray-400 cursor-not-allowed text-white font-bold py-2 px-6 rounded-lg transition">Download Application Form</button>
                    <p class="text-sm text-gray-500 mt-2 italic">The online application form is currently being updated. Please check back soon or visit the clubhouse.</p>
                @endif
            </div>
        </div>
    </div>
</div>
