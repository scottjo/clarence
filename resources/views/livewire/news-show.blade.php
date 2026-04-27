<div class="container mx-auto px-4 py-12">
    <article class="max-w-4xl mx-auto">
        <header class="mb-12 text-center">
            <div class="text-blue-600 font-bold uppercase tracking-wider mb-4">{{ $newsArticle->published_at->format('M d, Y') }}</div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight mb-8">{{ $newsArticle->title }}</h1>

            @if($newsArticle->hasMedia('title_image'))
                <div class="rounded-2xl overflow-hidden shadow-2xl mb-12">
                    {{ $newsArticle->getFirstMedia('title_image')->img('', ['class' => 'w-full object-cover max-h-[500px]']) }}
                </div>
            @endif
        </header>

        <div class="prose prose-lg dark:prose-invert mx-auto bg-white dark:bg-gray-800 p-8 md:p-12 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            {!! $newsArticle->content !!}
        </div>

        @if($newsArticle->hasMedia('gallery'))
            <div class="max-w-4xl mx-auto mt-12" x-data="{
                isOpen: false,
                currentImage: '',
                images: [
                    @foreach($newsArticle->getMedia('gallery') as $image)
                        '{{ $image->getUrl('large') ?: $image->getUrl() }}',
                    @endforeach
                ],
                currentIndex: 0,
                openLightbox(index) {
                    this.currentIndex = index;
                    this.currentImage = this.images[index];
                    this.isOpen = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeLightbox() {
                    this.isOpen = false;
                    document.body.classList.remove('overflow-hidden');
                },
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    this.currentImage = this.images[this.currentIndex];
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    this.currentImage = this.images[this.currentIndex];
                }
            }" @keydown.escape.window="closeLightbox()" @keydown.right.window="next()" @keydown.left.window="prev()">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Gallery</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($newsArticle->getMedia('gallery') as $index => $image)
                        <div class="rounded-xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700 aspect-square group cursor-pointer relative"
                             @click="openLightbox({{ $index }})">
                            {{ $image->img('thumb', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']) }}
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                <svg class="w-10 h-10 text-white transform scale-90 group-hover:scale-100 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Lightbox Overlay -->
                <template x-teleport="body">
                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 p-4 md:p-10"
                         x-cloak>

                        <!-- Close Button -->
                        <button type="button" @click="closeLightbox()" class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors z-[110] p-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Previous Button -->
                        <button type="button" x-show="images.length > 1" @click.stop="prev()" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors z-[110] p-4 hidden md:block">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Next Button -->
                        <button type="button" x-show="images.length > 1" @click.stop="next()" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors z-[110] p-4 hidden md:block">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Image Container -->
                        <div class="relative w-full h-full flex items-center justify-center" @click="closeLightbox()">
                            <img :src="currentImage"
                                 @click.stop
                                 class="max-w-full max-h-full object-contain shadow-2xl transition-all duration-300"
                                 x-show="isOpen"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="scale-95 opacity-0"
                                 x-transition:enter-end="scale-100 opacity-100">

                            <!-- Image Counter -->
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-white/60 text-sm font-medium mb-4" x-show="images.length > 1">
                                <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        @endif

        @if($newsArticle->hasMedia('attachments'))
            <div class="max-w-4xl mx-auto mt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Attachments</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($newsArticle->getMedia('attachments') as $attachment)
                        <a href="{{ $attachment->getUrl() }}" download class="flex items-center p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-blue-500 transition-colors group">
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-4 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $attachment->file_name }}
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
            <a href="{{ $newsArticle->is_members_only ? route('members') : route('news') }}" class="inline-flex items-center text-blue-600 font-bold hover:underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to all news
            </a>
        </footer>
    </article>
</div>
