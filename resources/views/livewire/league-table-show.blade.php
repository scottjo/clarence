<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                        <li>
                            <a href="{{ route('league-tables.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Leagues</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="text-gray-900 dark:text-white font-medium">{{ $league->name }}</span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $league->name }}
                    @if($season)
                        <span class="text-gray-500 dark:text-gray-400 font-normal"> - {{ $season }}</span>
                    @endif
                </h1>

                @if($allSeasons->count() > 1)
                    <div class="mt-4 flex items-center gap-3">
                        <label for="season-select" class="text-sm font-medium text-gray-700 dark:text-gray-300">Season:</label>
                        <select
                            id="season-select"
                            class="text-sm rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 block p-1.5"
                            onchange="window.location.href = this.value"
                        >
                            @foreach($allSeasons as $otherSeason)
                                <option value="{{ route('league-tables.show', ['league' => $league->slug, 'season' => $otherSeason]) }}" {{ $otherSeason === $season ? 'selected' : '' }}>
                                    {{ $otherSeason }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if($league->description)
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $league->description }}</p>
                @endif
            </div>
            <a href="{{ route('league-tables.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="mr-2 -ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Leagues
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Team</th>
                            <th scope="col" class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">P</th>
                            <th scope="col" class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-green-600 dark:text-green-500">W</th>
                            <th scope="col" class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-yellow-600 dark:text-yellow-500">D</th>
                            <th scope="col" class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-red-600 dark:text-red-500">L</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">RW</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">RD</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">RL</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">F</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">A</th>
                            <th scope="col" class="hidden md:table-cell px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Diff</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider bg-gray-100 dark:bg-gray-700">Pts</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($standings as $index => $standing)
                            <tr class="{{ $loop->even ? 'bg-gray-50/50 dark:bg-gray-900/20' : '' }} hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $standing->team_name }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->played }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-green-600 dark:text-green-500 font-medium">
                                    {{ $standing->won }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-yellow-600 dark:text-yellow-500 font-medium">
                                    {{ $standing->drawn }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-center text-red-600 dark:text-red-500 font-medium">
                                    {{ $standing->lost }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->rinks_won }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->rinks_drawn }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->rinks_lost }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->points_for }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">
                                    {{ $standing->points_against }}
                                </td>
                                <td class="hidden md:table-cell px-3 py-4 whitespace-nowrap text-sm text-center font-medium {{ $standing->points_difference >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500' }}">
                                    {{ $standing->points_difference > 0 ? '+' : '' }}{{ $standing->points_difference }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-bold text-gray-900 dark:text-white bg-gray-50/50 dark:bg-gray-700/50">
                                    {{ $standing->points }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No standings have been uploaded for this league yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400 italic">
                    <span class="font-bold">Legend:</span> P: Played, W: Won, D: Drawn, L: Lost, <span class="hidden md:inline">RW: Rinks Won, RD: Rinks Drawn, RL: Rinks Lost, F: For, A: Against, Diff: Shot Difference, </span>Pts: Points
                </p>
                @if($league->message)
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($league->message)) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
