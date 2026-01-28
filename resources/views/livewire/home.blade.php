<div>
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-12 mb-16">
        <section>
            <h2 class="text-3xl font-bold mb-6">Latest News</h2>
            <div class="space-y-6">
                @foreach($latestNews as $article)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                        @if($article->image)
                            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $article->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                            <a href="{{ route('news.show', $article) }}" class="text-blue-600 font-semibold hover:underline">Read More &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                <a href="{{ route('news') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">View All News</a>
            </div>
        </section>

        <section>
            <h2 class="text-3xl font-bold mb-6">Upcoming Events</h2>
            <div class="space-y-6">
                @foreach($upcomingEvents as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-3 rounded-lg text-center min-w-[80px]">
                                <span class="block text-2xl font-bold">{{ $event->start_time->format('d') }}</span>
                                <span class="text-sm uppercase">{{ $event->start_time->format('M') }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-1">{{ $event->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ $event->start_time->format('H:i') }} @ {{ $event->location ?? 'The Club' }}
                                </p>
                                <a href="{{ route('events.show', $event) }}" class="text-blue-600 font-semibold hover:underline">Event Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                <a href="{{ route('events') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">View All Events</a>
            </div>
        </section>
    </div>
</div>
</div>
