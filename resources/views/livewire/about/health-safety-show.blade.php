<div class="container mx-auto max-w-4xl px-4 py-12">
    <div class="flex flex-col gap-8">
        <a href="{{ route('about.health-safety') }}" class="text-blue-600 dark:text-blue-400 hover:underline">&larr; Club Health &amp; Safety</a>
        <header class="flex flex-col gap-3">
            <h1 class="text-4xl font-bold">{{ $healthSafetyPage->title }}</h1>
            @if ($healthSafetyPage->subtitle)
                <p class="text-xl text-gray-600 dark:text-gray-300">{{ $healthSafetyPage->subtitle }}</p>
            @endif
            <time datetime="{{ $healthSafetyPage->created_at->toIso8601String() }}" class="text-sm text-gray-500 dark:text-gray-400">Created {{ $healthSafetyPage->created_at->format('j F Y, H:i') }}</time>
        </header>
        @if ($healthSafetyPage->hasMedia('title_image'))
            <img src="{{ $healthSafetyPage->getFirstMediaUrl('title_image') }}" alt="{{ $healthSafetyPage->title }}" class="w-full max-h-[32rem] rounded-xl object-contain">
        @endif
        @if (filled($healthSafetyPage->content))
            <div class="prose prose-lg dark:prose-invert max-w-none">{!! str($healthSafetyPage->content)->sanitizeHtml() !!}</div>
        @endif
        @if ($healthSafetyPage->hasMedia('attachments'))
            <section class="flex flex-col gap-4" aria-labelledby="attachments-heading">
                <h2 id="attachments-heading" class="text-2xl font-bold">Attachments</h2>
                @foreach ($healthSafetyPage->getMedia('attachments') as $attachment)
                    <a wire:key="attachment-{{ $attachment->id }}" href="{{ $attachment->getUrl() }}" download class="flex items-center justify-between gap-4 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 text-blue-600 dark:text-blue-400 hover:underline">
                        <span class="break-all">{{ $attachment->file_name }}</span>
                        <span class="text-sm">Download</span>
                    </a>
                @endforeach
            </section>
        @endif
    </div>
</div>
