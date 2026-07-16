<div>
    <div class="container mx-auto px-4 py-12">
        @if($settings?->book_a_rink_advert_enabled ?? true)
            @php
                $bookARinkPrice = filled($settings?->book_a_rink_price) ? $settings->book_a_rink_price : '£5 per person per session';
                $bookARinkPhone = filled($settings?->book_a_rink_phone) ? $settings->book_a_rink_phone : '07895 255006';
                $bookARinkPhoneLink = preg_replace('/[^\d+]/', '', $bookARinkPhone);
            @endphp

            <section class="mb-12 overflow-hidden rounded-lg border border-emerald-200 bg-white shadow-lg dark:border-emerald-900/60 dark:bg-gray-800">
                <div class="grid gap-0 lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="relative p-6 sm:p-8">
                        <div class="absolute inset-y-0 left-0 w-1.5 bg-emerald-600"></div>
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75 17.25 20.25M17.25 3.75 6.75 20.25M4.5 12h15" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold uppercase text-emerald-700 dark:text-emerald-300">Book a rink</p>
                                <h2 class="mt-1 text-3xl font-black text-gray-900 dark:text-white">Turn up and play</h2>
                                <p class="mt-2 max-w-2xl text-base text-gray-600 dark:text-gray-300">
                                    Fancy a casual game? Book a rink and enjoy a session at Clarence Bowls Club.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-700 p-6 text-white sm:p-8">
                        <div class="grid h-full gap-4 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                            <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/20">
                                <p class="text-xs font-semibold uppercase text-emerald-100">Price</p>
                                <p class="mt-1 text-2xl font-black">{{ $bookARinkPrice }}</p>
                            </div>
                            <div class="rounded-md bg-white/10 p-4 ring-1 ring-white/20">
                                <p class="text-xs font-semibold uppercase text-emerald-100">To book</p>
                                <a href="tel:{{ $bookARinkPhoneLink }}" class="mt-1 inline-flex items-center gap-2 text-2xl font-black underline decoration-white/40 underline-offset-4 transition hover:decoration-white">
                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293a1.125 1.125 0 0 1-1.21.38 12.035 12.035 0 0 1-7.143-7.143 1.125 1.125 0 0 1 .38-1.21l1.293-.97c.36-.27.527-.733.417-1.173L6.963 3.102A1.125 1.125 0 0 0 5.872 2.25H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                    {{ $bookARinkPhone }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

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
                        @if($item->hasMedia('title_image'))
                            <div class="overflow-hidden rounded shadow-sm bg-white/30 dark:bg-black/10 p-0.5">
                                @php $media = $item->news_article_id ? $item->newsArticle->getFirstMedia('title_image') : $item->getFirstMedia('image'); @endphp
                                @if(! $media && $item->news_article_id)
                                    @php $media = $item->newsArticle->getFirstMedia('image'); @endphp
                                @endif
                                @if(! $media && ! $item->news_article_id)
                                    @php $media = $item->getFirstMedia('image'); @endphp
                                @endif

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
                        @elseif($item->hasMedia('image'))
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
                            @if($article->hasMedia('title_image'))
                                {{ $article->getFirstMedia('title_image')->img('thumb', ['class' => 'w-full h-48 object-cover']) }}
                            @elseif($article->hasMedia('image'))
                                {{ $article->getFirstMedia('image')->img('thumb', ['class' => 'w-full h-48 object-cover']) }}
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

            <div class="space-y-16">
                <section>
                    <h2 class="text-3xl font-bold mb-6">Upcoming Events</h2>
                    <div class="space-y-6">
                        @foreach($upcomingEvents as $event)
                            <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-100 dark:border-gray-700">
                                @if($event->overlay_label && $event->overlay_active)
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
                                        <div class="bg-yellow-300 dark:bg-yellow-400 text-gray-900 px-6 py-2 font-black text-2xl md:text-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform -rotate-12 border-4 border-yellow-400 dark:border-yellow-500 uppercase tracking-widest whitespace-nowrap opacity-90">
                                            {{ $event->overlay_label }}
                                        </div>
                                    </div>
                                @endif

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

                @if($latestMatchReports->isNotEmpty())
                    <section>
                        <h2 class="text-3xl font-bold mb-6">Latest Match Reports</h2>
                        <div class="space-y-4">
                            @foreach($latestMatchReports as $report)
                                <a href="{{ route('match-reports.show', $report) }}" class="group relative flex bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                                    <div class="relative w-1/4 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                        @if($report->hasMedia('header_image'))
                                            {{ $report->getFirstMedia('header_image')->img('thumb', ['class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']) }}
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white dark:to-gray-800 opacity-20 group-hover:opacity-0 transition-opacity"></div>
                                    </div>
                                    <div class="p-4 flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $report->created_at->format('M d') }} • {{ $report->team }}</div>
                                            <span class="px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-{{ $report->getResultBadgeColor() }}-100 text-{{ $report->getResultBadgeColor() }}-800 dark:bg-{{ $report->getResultBadgeColor() }}-900 dark:text-{{ $report->getResultBadgeColor() }}-200 shadow-sm">
                                                {{ $report->getResultStatus() }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-sm mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors dark:text-white">{{ $report->title }}</h3>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 line-clamp-1">
                                            {{ strip_tags($report->description) }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('match-reports.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">View All Match Reports</a>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
</div>
