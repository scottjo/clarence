<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('match-reports.index') }}" class="inline-flex items-center text-blue-600 font-bold mb-8 hover:gap-2 transition-all">
            <svg class="w-4 h-4 mr-1 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            Back to All Reports
        </a>

        @if($report->hasMedia('header_image'))
            <div class="rounded-2xl overflow-hidden shadow-2xl mb-12">
                {{ $report->getFirstMedia('header_image')->img('', ['class' => 'w-full h-auto object-cover max-h-[500px]']) }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    {{ $report->title }}
                </h1>
                <div class="mt-4 flex flex-wrap items-center gap-4 text-gray-500 dark:text-gray-400">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $report->created_at->format('F d, Y') }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        By {{ $report->author }}
                    </span>
                </div>
            </div>
            <div class="flex items-center">
                <span class="px-6 py-2 rounded-full text-lg font-black uppercase tracking-widest bg-{{ $report->getResultBadgeColor() }}-100 text-{{ $report->getResultBadgeColor() }}-800 dark:bg-{{ $report->getResultBadgeColor() }}-900 dark:text-{{ $report->getResultBadgeColor() }}-200 shadow-sm border border-{{ $report->getResultBadgeColor() }}-200 dark:border-{{ $report->getResultBadgeColor() }}-700">
                    {{ $report->getResultStatus() }}
                </span>
            </div>
        </div>

        <div class="prose prose-lg dark:prose-invert max-w-none mb-12 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            {!! $report->description !!}
        </div>

        @if($report->rink_scores)
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-8 mb-12 border-2 border-dashed border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold mb-6 flex items-center dark:text-white">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Rink Scores
                </h3>
                <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 font-mono text-sm">
                    {{ $report->rink_scores }}
                </div>
            </div>
        @endif

        @if($report->hasMedia('gallery'))
            <div class="mb-12">
                <h3 class="text-2xl font-bold mb-6 dark:text-white">Match Gallery</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($report->getMedia('gallery') as $media)
                        <div class="rounded-xl overflow-hidden shadow-md aspect-square">
                            {{ $media->img('thumb', ['class' => 'w-full h-full object-cover hover:scale-110 transition duration-500']) }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
