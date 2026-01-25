
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-8 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Fixtures
        </a>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="bg-blue-600 px-8 py-10 text-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
                            {{ $fixture->type->getLabel() }}
                        </div>
                        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Clarence vs {{ $fixture->opponent }}</h1>
                        <p class="text-blue-100 text-lg">
                            {{ $fixture->competition ?? 'Friendly Match' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-5xl font-bold mb-1">{{ $fixture->date->format('H:i') }}</div>
                        <div class="text-xl text-blue-100">{{ $fixture->date->format('l, jS F Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-12">
                <div class="grid md:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Venue Information</h3>
                            <div class="flex items-center gap-4">
                                <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-xl">
                                    @if($fixture->venue === 'Home')
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    @else
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-2xl font-bold">{{ $fixture->venue }}</div>
                                    <div class="text-gray-500">
                                        @if($fixture->venue === 'Home')
                                            Clarence Bowls Club, Beach Road
                                        @else
                                            Traveling to {{ $fixture->opponent }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Competition</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-600">
                                <div class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $fixture->competition ?? 'Friendly' }}</div>
                                <p class="text-gray-500 mt-2">A competitive match scheduled between Clarence and {{ $fixture->opponent }}.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Additional Notes</h3>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-xl border border-yellow-100 dark:border-yellow-900/30">
                            @if($fixture->notes)
                                <p class="text-gray-700 dark:text-gray-300 italic whitespace-pre-line">{{ $fixture->notes }}</p>
                            @else
                                <p class="text-gray-500 italic">No additional notes for this fixture.</p>
                            @endif
                        </div>

                        <div class="mt-8 p-6 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                            <h4 class="font-bold mb-2">Match Information</h4>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path></svg>
                                    Please arrive 30 minutes before start time.
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                                    Dress code: Whites / Club Colors.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
