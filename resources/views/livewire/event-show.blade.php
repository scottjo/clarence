<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="relative">
                @if($event->hasMedia('image'))
                    {{ $event->getFirstMedia('image')->img('', ['class' => 'w-full h-80 object-cover']) }}
                @endif

                @if($event->overlay_message && $event->overlay_active)
                    <div class="absolute inset-0 flex items-center justify-center p-6 pointer-events-none z-10">
                        <div class="bg-yellow-200 dark:bg-yellow-300 text-gray-900 p-6 shadow-[0_30px_70px_-10px_rgba(0,0,0,0.6)] transform rotate-2 max-w-sm border-l-8 border-yellow-400 dark:border-yellow-500 font-medium text-lg leading-relaxed relative">
                            <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-12 h-6 bg-white/40 blur-sm -rotate-2"></div>
                            {{ $event->overlay_message }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-8 md:p-12">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="px-4 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-bold uppercase tracking-widest">Event</span>
                    <span class="text-gray-500">{{ $event->start_time->format('l, F j, Y') }}</span>
                </div>

                <h1 class="text-4xl md:text-5xl font-black mb-8 leading-tight">{{ $event->title }}</h1>

                <div class="grid md:grid-cols-2 gap-8 mb-12 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-2xl">
                    <div class="flex items-center gap-4">
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 font-bold uppercase tracking-tighter">Time</div>
                            <div class="font-bold">
                                {{ $event->start_time->format('H:i') }}
                                @if($event->end_time)
                                    - {{ $event->end_time->format('H:i') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500 font-bold uppercase tracking-tighter">Location</div>
                            <div class="font-bold">{{ $event->location ?? 'The Club' }}</div>
                        </div>
                    </div>
                </div>

                <div class="prose prose-xl dark:prose-invert max-w-none">
                    {!! $event->description !!}
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('events') }}" class="inline-flex items-center text-gray-500 font-bold hover:text-blue-600 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to all events
            </a>
        </div>
    </div>
</div>
