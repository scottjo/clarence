<div class="container mx-auto px-4 py-12">
    <article class="max-w-4xl mx-auto">
        <header class="mb-12 text-center">
            <div class="text-blue-600 font-bold uppercase tracking-wider mb-4">{{ $newsArticle->published_at->format('M d, Y') }}</div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight mb-8">{{ $newsArticle->title }}</h1>

            @if($newsArticle->image)
                <div class="rounded-2xl overflow-hidden shadow-2xl mb-12">
                    <img src="{{ Storage::url($newsArticle->image) }}" alt="{{ $newsArticle->title }}" class="w-full object-cover max-h-[500px]">
                </div>
            @endif
        </header>

        <div class="prose prose-lg dark:prose-invert mx-auto bg-white dark:bg-gray-800 p-8 md:p-12 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            {!! $newsArticle->content !!}
        </div>

        @if($newsArticle->attachments)
            <div class="max-w-4xl mx-auto mt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Attachments</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($newsArticle->attachments as $attachment)
                        <a href="{{ Storage::url($attachment) }}" download class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-blue-500 transition-colors group">
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-4 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ basename($attachment) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Click to download
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <footer class="mt-16 text-center">
            <a href="{{ route('news') }}" class="inline-flex items-center text-blue-600 font-bold hover:underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to all news
            </a>
        </footer>
    </article>
</div>
