<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">League Tables</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">View current standings for our various bowling leagues.</p>
        </div>

        @if($leagues->isEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400">No league tables are currently available.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($leagues as $league)
                    @php
                        $latestSeason = $league->standings->first()?->season;
                        $seasonCount = $league->standings->unique('season')->count();
                    @endphp
                    <a href="{{ route('league-tables.show', $league->slug) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $league->name }}
                                </h2>
                                @if($latestSeason)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200 mt-1">
                                        {{ $latestSeason }}
                                    </span>
                                @endif
                            </div>
                            <span class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </div>
                        @if($league->description)
                            <p class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                                {{ $league->description }}
                            </p>
                        @endif

                        @if($seasonCount > 1)
                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $seasonCount }} seasons available
                            </div>
                        @endif

                        <div class="flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 mt-4">
                            View Standings
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
