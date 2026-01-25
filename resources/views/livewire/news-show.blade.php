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

        <footer class="mt-16 text-center">
            <a href="{{ route('news') }}" class="inline-flex items-center text-blue-600 font-bold hover:underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to all news
            </a>
        </footer>
    </article>
</div>
