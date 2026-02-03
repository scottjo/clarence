<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
            Search Results for "{{ $search }}"
        </h1>

        <div class="space-y-12">
            <!-- News Articles -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">News Articles</h2>
                @if($newsResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No news articles found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($newsResults as $article)
                            <a href="{{ route('news.show', $article->slug) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                                <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $article->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ strip_tags($article->content) }}
                                </p>
                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                                    {{ $article->published_at?->format('M d, Y') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Events -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">Events</h2>
                @if($eventResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No events found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($eventResults as $event)
                            <a href="{{ route('events.show', $event->slug) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                                <h3 class="text-xl font-bold text-green-600 dark:text-green-400 mb-2">{{ $event->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 line-clamp-3">
                                    {{ strip_tags($event->description) }}
                                </p>
                                <div class="mt-4 text-sm text-gray-500 dark:text-gray-500">
                                    {{ $event->start_time?->format('M d, Y @ H:i') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Officers -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">Officers</h2>
                @if($officerResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No officers found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($officerResults as $officer)
                            <a href="{{ route('about.officers') }}#officer-{{ $officer->id }}" class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition block">
                                <div class="flex items-center gap-4">
                                    @if($officer->avatar)
                                        <img src="{{ Storage::url($officer->avatar) }}" alt="{{ $officer->name }}" class="w-12 h-12 rounded-full object-cover">
                                    @endif
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $officer->name }}</h3>
                                        <p class="text-blue-600 dark:text-blue-400">{{ $officer->role->getLabel() }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Fixtures -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">Fixtures</h2>
                @if($fixtureResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No fixtures found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($fixtureResults as $fixture)
                            <a href="{{ route('fixtures.show', $fixture) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                                <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-2">vs {{ $fixture->opponent }}</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $fixture->date?->format('M d, Y @ H:i') }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                                    {{ $fixture->venue }} | {{ $fixture->competition }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Results -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">Results</h2>
                @if($resultResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No results found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($resultResults as $result)
                            <a href="{{ route('results', ['type' => $result->fixture->type->value]) }}#result-{{ $result->id }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                                <h3 class="text-xl font-bold text-purple-600 dark:text-purple-400 mb-1">
                                    vs {{ $result->fixture->opponent }}
                                </h3>
                                <div class="text-2xl font-black mb-2 dark:text-white">
                                    {{ $result->home_score }} - {{ $result->away_score }}
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 line-clamp-2 italic">
                                    "{{ $result->summary }}"
                                </p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <!-- Competition Winners -->
            <section>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2">Competition Winners</h2>
                @if($winnerResults->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No competition winners found.</p>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($winnerResults as $winner)
                            <a href="{{ route('about.competition-winners', ['year' => $winner->year]) }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                                <h3 class="text-xl font-bold text-amber-600 dark:text-amber-400 mb-2">
                                    {{ $winner->year }} {{ $winner->competition->name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    @if($winner->no_competition)
                                        <span class="italic">No Competition</span>
                                    @else
                                        {{ $winner->winner_names }}
                                    @endif
                                </p>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-500">
                                    {{ $winner->category ?: $winner->competition->category }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        @if($newsResults->isEmpty() && $eventResults->isEmpty() && $officerResults->isEmpty() && $fixtureResults->isEmpty() && $resultResults->isEmpty() && $winnerResults->isEmpty())
            <div class="text-center py-12">
                <p class="text-xl text-gray-600 dark:text-gray-400">Sorry, we couldn't find anything matching your search.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Return Home</a>
                </div>
            </div>
        @endif
    </div>
</div>
