<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-12 text-center text-gray-900 dark:text-white">Match Reports</h1>

    <div class="flex flex-wrap gap-4 mb-8 justify-center">
        <select wire:model.live="team" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            <option value="">All Teams</option>
            @foreach($teams as $t)
                <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
        </select>

        <select wire:model.live="year" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
            <option value="">All Years</option>
            @foreach($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($reports as $report)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col border border-gray-100 dark:border-gray-700 hover:shadow-xl transition duration-300 relative">
                @if(!in_array($report->id, $viewedReports))
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full uppercase tracking-wider">New</span>
                    </div>
                @endif

                @if($report->hasMedia('header_image'))
                    {{ $report->getFirstMedia('header_image')->img('thumb', ['class' => 'w-full h-56 object-cover']) }}
                @else
                    <div class="w-full h-56 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4"></path></svg>
                    </div>
                @endif

                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $report->created_at->format('M d, Y') }}</span>
                        <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider bg-{{ $report->getResultBadgeColor() }}-100 text-{{ $report->getResultBadgeColor() }}-800 dark:bg-{{ $report->getResultBadgeColor() }}-900 dark:text-{{ $report->getResultBadgeColor() }}-200">
                            {{ $report->getResultStatus() }}
                        </span>
                    </div>

                    <h2 class="text-2xl font-bold mb-4 leading-tight dark:text-white">{{ $report->title }}</h2>

                    <p class="text-gray-600 dark:text-gray-400 mb-6 flex-1 line-clamp-3">
                        {{ strip_tags($report->description) }}
                    </p>

                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-sm text-gray-500 dark:text-gray-400 italic">By {{ $report->author }}</span>
                        <a href="{{ route('match-reports.show', $report) }}" class="inline-flex items-center text-blue-600 font-bold hover:gap-2 transition-all">
                            Read Report
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white dark:bg-gray-800 rounded-xl shadow-inner">
                <p class="text-xl text-gray-500">No match reports found. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $reports->links() }}
    </div>
</div>
