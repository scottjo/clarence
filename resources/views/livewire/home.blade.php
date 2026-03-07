<div>
    <div class="container mx-auto px-4 py-12">
        @if($pinnedItems->isNotEmpty())
            @foreach($pinnedItems as $item)
                <div
                    x-data="{ unpinned: localStorage.getItem('pinned-item-{{ $item->id }}-dismissed') }"
                    x-show="!unpinned"
                    @class([
                        'fixed z-50 w-[90%] md:w-2/5 max-w-lg bg-yellow-50 dark:bg-amber-900/10 p-10 shadow-notice border border-yellow-100/50 dark:border-amber-800/20 transition-all duration-500 overflow-hidden',
                        'left-4 md:left-8 top-24 md:top-32 -rotate-2 hover:-rotate-1' => $item->position === 'left',
                        'right-4 md:right-8 top-24 md:top-32 rotate-2 hover:rotate-1' => $item->position === 'right' || !$item->position,
                    ])
                >
                    <!-- Pin decoration -->
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-8 h-8 bg-red-600 rounded-full shadow-lg z-20 flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-white/40 rounded-full"></div>
                    </div>

                    <!-- Unpin button -->
                    <button
                        @click="localStorage.setItem('pinned-item-{{ $item->id }}-dismissed', 'true'); unpinned = true"
                        class="absolute top-3 right-3 p-1.5 text-amber-800/50 dark:text-amber-200/50 hover:text-red-600 transition-colors z-30"
                        title="Unpin this notice"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="relative z-10">
                        @if($item->hasMedia('image'))
                            <div class="overflow-hidden rounded shadow-sm bg-white/30 dark:bg-black/10 p-0.5">
                                @php $media = $item->getFirstMedia('image'); @endphp

                                @if($item->news_article_id)
                                    <a href="{{ route('news.show', $item->newsArticle) }}" class="block">
                                @endif

                                @if($media && str_contains($media->mime_type, 'pdf'))
                                    <div class="aspect-[1/1.41] w-full flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-800/50 text-gray-500 rounded border border-gray-200 dark:border-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 mb-2 text-red-500/80">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span class="text-xs font-bold uppercase tracking-widest opacity-60 mb-4">PDF Document</span>

                                        @if($item->news_article_id)
                                            <span class="px-5 py-2.5 bg-red-600 text-white text-[10px] font-black rounded shadow-md hover:bg-red-700 transition uppercase tracking-widest">
                                                Open Notice
                                            </span>
                                        @else
                                            <a href="{{ $media->getUrl() }}" target="_blank" class="px-5 py-2.5 bg-red-600 text-white text-[10px] font-black rounded shadow-md hover:bg-red-700 transition uppercase tracking-widest">
                                                Open Notice
                                            </a>
                                        @endif
                                    </div>
                                @elseif($media)
                                    {{ $media->img('', ['class' => 'w-full h-auto object-contain max-h-[70vh] rounded shadow-sm', 'alt' => $item->title]) }}
                                @endif

                                @if($item->news_article_id)
                                    </a>
                                @endif
                            </div>
                        @endif

                        @if($item->news_article_id)
                            <div class="mt-6 text-center">
                                <a href="{{ route('news.show', $item->newsArticle) }}" class="inline-block text-amber-900/80 dark:text-amber-100/80 font-serif italic text-sm hover:underline decoration-1 underline-offset-4">
                                    {{ $item->title }} &rarr;
                                </a>
                            </div>
                        @else
                            <div class="mt-6 text-center text-amber-900/80 dark:text-amber-100/80 font-serif italic text-sm">
                                {{ $item->title }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <div class="grid md:grid-cols-2 gap-12 mb-16">
        <section>
            <h2 class="text-3xl font-bold mb-6">Latest News</h2>
            <div class="space-y-6">
                @foreach($latestNews as $article)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                        @if($article->hasMedia('image'))
                            {{ $article->getFirstMedia('image')->img('', ['class' => 'w-full h-48 object-cover']) }}
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $article->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit(html_entity_decode(strip_tags($article->content), ENT_QUOTES, 'UTF-8'), 150) }}</p>
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
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700">
                        @if($event->hasMedia('image'))
                            <div class="absolute inset-y-0 right-0 w-3/5">
                                {{ $event->getFirstMedia('image')->img('', ['class' => 'absolute inset-0 w-full h-full object-cover']) }}
                                <div class="absolute inset-0 bg-gradient-to-r from-white via-white to-transparent dark:from-gray-800 dark:via-gray-800"></div>
                            </div>
                        @endif
                        <div class="relative z-10 p-6">
                            <div class="flex items-start gap-4">
                                <div class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 p-3 rounded-lg text-center min-w-[80px]">
                                    <span class="block text-2xl font-bold">{{ $event->start_time->format('d') }}</span>
                                    <span class="text-sm uppercase">{{ $event->start_time->format('M') }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold mb-1">{{ $event->title }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                        {{ $event->start_time->format('H:i') }} @ {{ $event->location ?? 'The Club' }}
                                    </p>
                                    <a href="{{ route('events.show', $event) }}" class="text-blue-600 font-semibold hover:underline">Event Details</a>
                                </div>
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
