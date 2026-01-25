<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8 text-center">{{ $type ?? 'All' }} Results</h1>

    @if($results->total() > 0)
        <div class="max-w-4xl mx-auto mb-8 flex justify-end items-center gap-3">
            <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Results per page:</label>
            <select wire:model.live="perPage" id="perPage" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
    @endif

    <div class="max-w-4xl mx-auto space-y-6">
        @forelse($results as $result)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-3 flex justify-between items-center border-b border-gray-100 dark:border-gray-700">
                    <span class="text-sm font-semibold text-gray-500 uppercase">{{ $result->fixture->competition ?? 'Friendly' }}</span>
                    <span class="text-sm text-gray-500">{{ $result->fixture->date->format('D d M, Y') }}</span>
                </div>
                <div class="p-8 flex items-center justify-between">
                    <div class="flex-1 text-center">
                        <div class="text-sm text-gray-500 mb-1">Clarence</div>
                        <div class="text-2xl font-bold">{{ $result->fixture->venue === 'Home' ? $result->home_score : $result->away_score }}</div>
                    </div>
                    <div class="px-8 text-gray-300 font-light text-4xl">vs</div>
                    <div class="flex-1 text-center">
                        <div class="text-sm text-gray-500 mb-1">{{ $result->fixture->opponent }}</div>
                        <div class="text-2xl font-bold">{{ $result->fixture->venue === 'Home' ? $result->away_score : $result->home_score }}</div>
                    </div>
                </div>
                @if($result->summary)
                    <div class="px-8 pb-8 text-gray-600 dark:text-gray-400 italic text-center border-t border-gray-50 dark:border-gray-700 pt-4">
                        "{{ $result->summary }}"
                    </div>
                @endif
                <div class="bg-blue-600 h-1 w-full"></div>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                No results recorded yet.
            </div>
        @endforelse
    </div>

    <div class="max-w-4xl mx-auto mt-8">
        {{ $results->links() }}
    </div>
</div>
