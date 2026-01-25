<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-12 text-center">Upcoming Events</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col hover:-translate-y-1 transition duration-300">
                <div class="relative h-48">
                    @if($event->image)
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-600 flex items-center justify-center text-white">
                            <svg class="w-16 h-16 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white dark:bg-gray-900 rounded-xl p-2 text-center shadow-lg min-w-[60px]">
                        <span class="block text-xl font-black leading-none">{{ $event->start_time->format('d') }}</span>
                        <span class="block text-xs uppercase font-bold text-gray-500">{{ $event->start_time->format('M') }}</span>
                    </div>
                </div>

                <div class="p-8 flex-1 flex flex-col">
                    <h2 class="text-2xl font-bold mb-3">{{ $event->title }}</h2>
                    <div class="flex items-center text-sm text-gray-500 mb-6 gap-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $event->start_time->format('H:i') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location ?? 'The Club' }}
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 flex-1">
                        {{ Str::limit(strip_tags($event->description), 100) }}
                    </p>
                    <a href="{{ route('events.show', $event) }}" class="block text-center py-3 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition">View Details</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <p class="text-xl text-gray-500">No upcoming events at the moment. Stay tuned!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $events->links() }}
    </div>
</div>
