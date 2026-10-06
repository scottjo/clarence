<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-10">Club Health &amp; Safety</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($pages as $page)
            <a wire:key="health-safety-{{ $page->id }}" href="{{ route('about.health-safety.show', $page->slug) }}" class="flex flex-col gap-4 overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-md hover:shadow-lg transition focus-visible:outline-2 focus-visible:outline-blue-600">
                @if ($page->hasMedia('title_image'))
                    <img src="{{ $page->getFirstMediaUrl('title_image') }}" alt="{{ $page->title }}" class="w-full h-48 object-cover" loading="lazy">
                @endif
                <div class="flex flex-col gap-3 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $page->title }}</h2>
                    @if ($page->subtitle)
                        <p class="text-gray-600 dark:text-gray-300">{{ $page->subtitle }}</p>
                    @endif
                    <time datetime="{{ $page->created_at->toIso8601String() }}" class="text-sm text-gray-500 dark:text-gray-400">Created {{ $page->created_at->format('j F Y, H:i') }}</time>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold">View page &rarr;</span>
                </div>
            </a>
        @empty
            <p class="col-span-full text-center text-gray-600 dark:text-gray-300">Health &amp; Safety pages will appear here when available.</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $pages->links() }}</div>
</div>
