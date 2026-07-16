<div class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $settings?->members_area_heading ?: 'Members Area' }}</h1>
                <p class="text-gray-700 dark:text-gray-300 mt-2">
                    Welcome {{ auth()->user()?->name }} to the members only section.
                </p>
            </div>
            <div class="flex flex-wrap gap-4">
                @if($settings?->member_login_url)
                    <a href="{{ $settings->member_login_url }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Bowls Hub
                    </a>
                @endif
                <button wire:click="logout" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    Logout
                </button>
            </div>
        </div>

        <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-wrap gap-2">
                <button type="button" wire:click="showNewsAndNewsletters" class="inline-flex items-center gap-2 border-b-2 px-4 py-3 text-sm font-semibold transition {{ $activeMembersTab === 'news' ? 'border-blue-600 text-blue-700 dark:border-blue-400 dark:text-blue-300' : 'border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-900 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-white' }}">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                    </svg>
                    News & Newsletters
                </button>
                <button type="button" wire:click="showQuestionsAndAnswers" class="inline-flex items-center gap-2 border-b-2 px-4 py-3 text-sm font-semibold transition {{ $activeMembersTab === 'questions' ? 'border-blue-600 text-blue-700 dark:border-blue-400 dark:text-blue-300' : 'border-transparent text-gray-600 hover:border-gray-300 hover:text-gray-900 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-white' }}">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 4v-4z"></path>
                    </svg>
                    Questions & Answers
                </button>
            </div>
        </div>

        @if($activeMembersTab === 'news')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{
                seenNewsletters: JSON.parse(localStorage.getItem('seen_newsletters') || '[]'),
                seenCommitteeMinutes: JSON.parse(localStorage.getItem('seen_committee_minutes') || '[]'),
                markAsSeen(collection, id) {
                    if (collection === 'minutes') {
                        if (!this.seenCommitteeMinutes.includes(id)) {
                            this.seenCommitteeMinutes.push(id);
                            localStorage.setItem('seen_committee_minutes', JSON.stringify(this.seenCommitteeMinutes));
                        }

                        return;
                    }

                    if (!this.seenNewsletters.includes(id)) {
                        this.seenNewsletters.push(id);
                        localStorage.setItem('seen_newsletters', JSON.stringify(this.seenNewsletters));
                    }
                }
            }">
                <!-- News Section -->
                <div class="lg:col-span-2 space-y-8">
                    @if($announcements->isNotEmpty())
                        <section>
                            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                Members Announcements
                            </h2>
                            <div class="space-y-4">
                                @foreach($announcements as $announcement)
                                    @php
                                        $colors = [
                                            'info' => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800',
                                            'success' => 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800',
                                            'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800',
                                            'danger' => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800',
                                        ];
                                        $colorClass = $colors[$announcement->type] ?? $colors['info'];
                                    @endphp
                                    <div class="p-4 rounded-xl border {{ $colorClass }} shadow-sm">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-0.5">
                                                @if($announcement->type === 'success')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @elseif($announcement->type === 'warning')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                @elseif($announcement->type === 'danger')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold">{{ $announcement->header }}</h4>
                                                <div class="mt-1 text-sm opacity-90 whitespace-pre-line">{{ $announcement->text }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <section>
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"></path></svg>
                            Members News
                        </h2>

                    @if($newsArticles->isEmpty())
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                            <p class="text-gray-500">No members-only news articles found.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($newsArticles as $article)
                                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col">
                                    @if($article->hasMedia('title_image'))
                                        <div class="relative h-48">
                                            {{ $article->getFirstMedia('title_image')->img('thumb', ['class' => 'w-full h-full object-cover', 'alt' => $article->title]) }}
                                        </div>
                                    @elseif($article->hasMedia('image'))
                                        <div class="relative h-48">
                                            {{ $article->getFirstMedia('image')->img('thumb', ['class' => 'w-full h-full object-cover', 'alt' => $article->title]) }}
                                        </div>
                                    @endif
                                    <div class="p-6 grow">
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                                                {{ $article->published_at?->format('M j, Y') }}
                                            </time>
                                        </div>
                                        <h3 class="text-xl font-bold mb-2 text-gray-900 dark:text-white">{{ $article->title }}</h3>
                                        <div class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                                            {!! strip_tags($article->content) !!}
                                        </div>
                                    </div>
                                    <div class="p-6 pt-0 mt-auto">
                                        <a href="{{ route('news.show', $article->slug) }}" class="text-blue-600 hover:text-blue-700 font-medium inline-flex items-center gap-1 group">
                                            Read More
                                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            {{ $newsArticles->links() }}
                        </div>
                    @endif
                    </section>
                </div>

                <!-- Member Documents Section -->
                <div class="space-y-8">
                    <section>
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Newsletters
                        </h2>

                    @if($newsletters->isEmpty())
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                            <p class="text-gray-500">No newsletters available.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($newsletters as $newsletter)
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                                    @if($newsletter->hasMedia('newsletter_pdf'))
                                        <div class="w-16 h-20 bg-blue-50 dark:bg-blue-900/20 rounded overflow-hidden shrink-0 border border-blue-100 dark:border-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="grow">
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-gray-900 dark:text-white">{{ $newsletter->title }}</h3>
                                            @if($newsletter->isRecent())
                                                <span x-show="!seenNewsletters.includes({{ $newsletter->id }})"
                                                      class="px-2 py-0.5 text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full uppercase tracking-wider"
                                                      x-cloak>
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $newsletter->issue_date?->format('F Y') }}</p>
                                    </div>
                                    @if($newsletter->hasMedia('newsletter_pdf'))
                                        <a href="{{ $newsletter->getFirstMediaUrl('newsletter_pdf') }}"
                                           target="_blank"
                                           @click="markAsSeen('newsletter', {{ $newsletter->id }})"
                                           class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition"
                                           title="Download PDF">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"></path></svg>
                            Committee Minutes
                        </h2>

                    @if($committeeMinutes->isEmpty())
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                            <p class="text-gray-500">No committee minutes available.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($committeeMinutes as $minutes)
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                                    @if($minutes->hasMedia('newsletter_pdf'))
                                        <div class="w-16 h-20 bg-blue-50 dark:bg-blue-900/20 rounded overflow-hidden shrink-0 border border-blue-100 dark:border-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="grow">
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-bold text-gray-900 dark:text-white">{{ $minutes->title }}</h3>
                                            @if($minutes->isRecent())
                                                <span x-show="!seenCommitteeMinutes.includes({{ $minutes->id }})"
                                                      class="px-2 py-0.5 text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full uppercase tracking-wider"
                                                      x-cloak>
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $minutes->issue_date?->format('F Y') }}</p>
                                    </div>
                                    @if($minutes->hasMedia('newsletter_pdf'))
                                        <a href="{{ $minutes->getFirstMediaUrl('newsletter_pdf') }}"
                                           target="_blank"
                                           @click="markAsSeen('minutes', {{ $minutes->id }})"
                                           class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition"
                                           title="Download PDF">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                    </section>
                </div>
            </div>
        @else
            <livewire:member-questions />
        @endif
    </div>
</div>
