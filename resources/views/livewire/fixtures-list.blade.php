<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8 text-center">{{ $type }} Fixtures</h1>

    @if($fixtures->total() > 0)
        <div class="max-w-5xl mx-auto mb-8 flex justify-end items-center gap-3">
            <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Fixtures per page:</label>
            <select wire:model.live="perPage" id="perPage" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
    @endif

    <div class="max-w-5xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 font-bold">Date & Time</th>
                            <th class="px-6 py-4 font-bold">Opponent</th>
                            <th class="px-6 py-4 font-bold text-center">Venue</th>
                            <th class="px-6 py-4 font-bold">Competition</th>
                            <th class="px-6 py-4 font-bold">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($fixtures as $fixture)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition cursor-pointer" onclick="window.location='{{ route('fixtures.show', $fixture) }}'">
                                <td class="px-6 py-4" data-href="{{ route('fixtures.show', $fixture) }}">
                                    <div class="font-semibold">{{ $fixture->date->format('D d M, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $fixture->date->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-lg text-blue-600 dark:text-blue-400">
                                    {{ $fixture->opponent }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $fixture->venue === 'Home' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300' }}">
                                        {{ $fixture->venue }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                    {{ $fixture->competition ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 italic">
                                    {{ $fixture->notes }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    No upcoming fixtures scheduled at the moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $fixtures->links() }}
        </div>
    </div>
</div>
