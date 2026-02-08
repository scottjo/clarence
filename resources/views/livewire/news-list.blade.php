<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-12 text-center">Club News</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $article)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-gray-100 dark:border-gray-700 hover:shadow-xl transition duration-300">
                @if($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-56 object-cover">
                @else
                    <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4"></path></svg>
                    </div>
                @endif
                <div class="p-8 flex-1 flex flex-col">
                    <div class="text-sm text-blue-600 font-semibold mb-2">{{ $article->published_at->format('M d, Y') }}</div>
                    <h2 class="text-2xl font-bold mb-4 leading-tight">{{ $article->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 flex-1">
                        {{ Str::limit(html_entity_decode(strip_tags($article->content), ENT_QUOTES, 'UTF-8'), 120) }}
                    </p>
                    <a href="{{ route('news.show', $article) }}" class="inline-flex items-center text-blue-600 font-bold hover:gap-2 transition-all">
                        Read Full Story
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white dark:bg-gray-800 rounded-xl shadow-inner">
                <p class="text-xl text-gray-500">No news articles found. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $articles->links() }}
    </div>
</div>
