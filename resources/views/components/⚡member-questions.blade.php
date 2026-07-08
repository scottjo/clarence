<?php

use App\Models\MemberAnswer;
use App\Models\MemberQuestion;
use App\Models\MemberQuestionComment;
use App\Models\MemberQuestionVote;
use App\Support\MemberContentModerator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $title = '';

    public string $body = '';

    public bool $isAnonymous = false;

    public string $search = '';

    public string $sortBy = 'date';

    public string $sortDirection = 'desc';

    public int $perPage = 5;

    public bool $showQuestionForm = false;

    /** @var array<int, bool> */
    public array $collapsedQuestions = [];

    /** @var array<int, string> */
    public array $answerBodies = [];

    /** @var array<int, string> */
    public array $commentBodies = [];

    public function mount(): void
    {
        abort_unless(Auth::check(), 403);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        if (! in_array($this->perPage, [5, 10, 20], true)) {
            $this->perPage = 5;
        }

        $this->resetPage();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function openQuestionForm(): void
    {
        $this->showQuestionForm = true;
    }

    public function closeQuestionForm(): void
    {
        $this->reset('title', 'body', 'isAnonymous');
        $this->resetValidation(['title', 'body', 'isAnonymous']);

        $this->showQuestionForm = false;
    }

    public function askQuestion(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:160'],
            'body' => ['nullable', 'string', 'max:3000'],
            'isAnonymous' => ['boolean'],
        ]);

        if ($this->containsBlockedLanguage($validated['title']) || $this->containsBlockedLanguage($validated['body'] ?? '')) {
            $this->addError('body', 'Please remove inappropriate language before posting.');

            return;
        }

        $user = Auth::user();

        MemberQuestion::query()->create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'body' => filled($validated['body'] ?? null) ? $validated['body'] : null,
            'is_anonymous' => $validated['isAnonymous'],
            'display_name' => $validated['isAnonymous'] ? null : $user->name,
        ]);

        $this->reset('title', 'body', 'isAnonymous');
        $this->showQuestionForm = false;
        $this->resetPage();
    }

    public function answerQuestion(int $questionId): void
    {
        if (! Auth::user()?->canAnswerMemberQuestions()) {
            $this->addError('answerAuthorization', 'Only designated club members can answer questions.');

            return;
        }

        $question = MemberQuestion::query()->findOrFail($questionId);

        if ($question->is_locked) {
            $this->addError("answerBodies.$questionId", 'This question is locked.');

            return;
        }

        $field = "answerBodies.$questionId";
        $body = trim($this->answerBodies[$questionId] ?? '');

        if ($body === '') {
            $this->addError($field, 'Please enter an answer.');

            return;
        }

        if (mb_strlen($body) > 3000) {
            $this->addError($field, 'Answers may not be greater than 3000 characters.');

            return;
        }

        if ($this->containsBlockedLanguage($body)) {
            $this->addError($field, 'Please remove inappropriate language before posting.');

            return;
        }

        MemberAnswer::query()->create([
            'member_question_id' => $question->id,
            'user_id' => Auth::id(),
            'body' => $body,
        ]);

        unset($this->answerBodies[$questionId]);
    }

    public function deleteAnswer(int $answerId): void
    {
        $answer = MemberAnswer::query()->findOrFail($answerId);

        abort_unless($answer->user_id === Auth::id(), 403);

        $answer->delete();
    }

    public function addComment(int $answerId): void
    {
        $field = "commentBodies.$answerId";
        $body = trim($this->commentBodies[$answerId] ?? '');

        if ($body === '') {
            $this->addError($field, 'Please enter a comment.');

            return;
        }

        if (mb_strlen($body) > 1200) {
            $this->addError($field, 'Comments may not be greater than 1200 characters.');

            return;
        }

        if ($this->containsBlockedLanguage($body)) {
            $this->addError($field, 'Please remove inappropriate language before posting.');

            return;
        }

        $user = Auth::user();
        $answer = MemberAnswer::query()->with('question')->findOrFail($answerId);

        if ($answer->question?->is_locked) {
            $this->addError($field, 'This question is locked.');

            return;
        }

        $answer->comments()->create([
            'user_id' => $user->id,
            'body' => $body,
            'is_anonymous' => false,
            'display_name' => $user->name,
        ]);

        unset($this->commentBodies[$answerId]);
    }

    public function deleteComment(int $commentId): void
    {
        $comment = MemberQuestionComment::query()->findOrFail($commentId);

        abort_unless($comment->user_id === Auth::id(), 403);

        $comment->delete();
    }

    public function toggleCollapsed(int $questionId): void
    {
        $this->collapsedQuestions[$questionId] = ! ($this->collapsedQuestions[$questionId] ?? false);
    }

    public function toggleLocked(int $questionId): void
    {
        if (! Auth::user()?->canAnswerMemberQuestions()) {
            $this->addError('answerAuthorization', 'Only designated club members can lock questions.');

            return;
        }

        $question = MemberQuestion::query()->findOrFail($questionId);

        $question->update([
            'is_locked' => ! $question->is_locked,
        ]);
    }

    public function voteQuestion(int $questionId, int $value): void
    {
        if (! in_array($value, [1, -1], true)) {
            return;
        }

        $vote = MemberQuestionVote::query()
            ->where('member_question_id', $questionId)
            ->where('user_id', Auth::id())
            ->first();

        if ($vote instanceof MemberQuestionVote) {
            if ($vote->value === $value) {
                $vote->delete();

                return;
            }

            $vote->update([
                'value' => $value,
            ]);

            return;
        }

        MemberQuestionVote::query()->create([
            'member_question_id' => $questionId,
            'user_id' => Auth::id(),
            'value' => $value,
        ]);
    }

    public function canAnswerQuestions(): bool
    {
        return Auth::user()?->canAnswerMemberQuestions() ?? false;
    }

    public function questions(): LengthAwarePaginator
    {
        $query = MemberQuestion::query()
            ->with([
                'user',
                'answers.user',
                'answers.comments.user',
                'votes' => fn ($query) => $query->where('user_id', Auth::id()),
            ])
            ->withCount([
                'answers',
                'comments',
            ])
            ->withSum('votes as vote_score', 'value')
            ->when(trim($this->search) !== '', function (Builder $query): void {
                $search = '%'.str_replace(['%', '_'], ['\%', '\_'], trim($this->search)).'%';

                $query->where(function (Builder $query) use ($search): void {
                    $query
                        ->where('title', 'like', $search)
                        ->orWhere('body', 'like', $search)
                        ->orWhere('display_name', 'like', $search)
                        ->orWhereHas('answers', fn (Builder $query) => $query->where('body', 'like', $search))
                        ->orWhereHas('answers.comments', fn (Builder $query) => $query->where('body', 'like', $search)->orWhere('display_name', 'like', $search));
                });
            });

        if ($this->sortBy === 'votes') {
            $query->orderBy('vote_score', $this->sortDirection);
        } else {
            $query->orderBy('created_at', $this->sortDirection);
        }

        return $query
            ->orderBy('id', $this->sortDirection)
            ->paginate($this->perPage);
    }

    private function containsBlockedLanguage(string $content): bool
    {
        return MemberContentModerator::containsBlockedLanguage($content);
    }
};
?>

<section class="mt-12 space-y-8">
    @php
        $questions = $this->questions();
        $canAnswerQuestions = $this->canAnswerQuestions();
    @endphp

    <div class="border-t border-gray-200 pt-10 dark:border-gray-700">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Questions and Answers</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ask the club, see official answers, vote on useful questions, and discuss the answers with other members.</p>
            </div>
            @if($canAnswerQuestions)
                <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-300">Answering enabled</span>
            @endif
        </div>
    </div>

    <div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 md:grid-cols-[1fr_auto_auto_auto_auto]">
        <div>
            <label for="member-question-search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search questions, answers and comments</label>
            <input wire:model.live.debounce.300ms="search" id="member-question-search" type="search" class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white" placeholder="Search...">
        </div>
        <div>
            <label for="member-question-sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">List by</label>
            <select wire:model.live="sortBy" id="member-question-sort" class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                <option value="date">Date</option>
                <option value="votes">Votes</option>
            </select>
        </div>
        <div>
            <label for="member-question-per-page" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Questions</label>
            <select wire:model.live="perPage" id="member-question-per-page" class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" wire:click="toggleSortDirection" class="w-full rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700">
                {{ $sortDirection === 'desc' ? 'Newest first' : 'Oldest first' }}
            </button>
        </div>
        <div class="flex items-end">
            <button type="button" wire:click="openQuestionForm" class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Ask question
            </button>
        </div>
    </div>

    @if($showQuestionForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 p-4" role="dialog" aria-modal="true" aria-labelledby="ask-question-title">
            <div class="w-full max-w-2xl rounded-lg border border-gray-200 bg-white p-5 shadow-xl dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 id="ask-question-title" class="text-lg font-bold text-gray-900 dark:text-white">Ask a question</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Post a question for the club and choose whether to show your name.</p>
                    </div>
                    <button type="button" wire:click="closeQuestionForm" class="inline-flex size-8 items-center justify-center rounded-full border border-gray-300 text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700" title="Close question form" aria-label="Close question form">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="askQuestion" class="mt-5 space-y-4">
                    <div>
                        <label for="question-title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
                        <input wire:model="title" id="question-title" type="text" maxlength="160" class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white" placeholder="What would you like to ask?">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="question-body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Details <span class="font-normal text-gray-500 dark:text-gray-400">(optional)</span></label>
                        <textarea wire:model="body" id="question-body" rows="5" maxlength="3000" class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white" placeholder="Add any useful background..."></textarea>
                        @error('body')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-3 border-t border-gray-200 pt-4 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input wire:model="isAnonymous" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            Ask anonymously
                        </label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <button type="button" wire:click="closeQuestionForm" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700">Cancel</button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="askQuestion" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-70">
                                <span wire:loading.remove wire:target="askQuestion">Post question</span>
                                <span wire:loading wire:target="askQuestion">Posting...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="space-y-5">
        @forelse($questions as $question)
            @php
                $isCollapsed = $collapsedQuestions[$question->id] ?? false;
                $isAnswered = $question->answers_count > 0;
                $voteScore = (int) $question->vote_score;
            @endphp
            <article wire:key="member-question-{{ $question->id }}" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex flex-col gap-4 md:flex-row md:items-start">
                    <div class="md:w-36">
                        @php
                            $currentVote = $question->votes->first()?->value;
                        @endphp
                        <div class="inline-grid grid-cols-[2.75rem_4rem_2.75rem] overflow-hidden rounded-md border border-gray-300 bg-white text-sm shadow-sm dark:border-gray-700 dark:bg-gray-900">
                            <button type="button" wire:click="voteQuestion({{ $question->id }}, -1)" class="flex items-center justify-center border-r border-gray-300 px-3 py-2 font-semibold transition dark:border-gray-700 {{ $currentVote === -1 ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800' }}" title="Thumbs down">
                                <span aria-hidden="true">👎</span>
                                <span class="sr-only">thumbs down</span>
                            </button>
                            <div class="flex flex-col items-center justify-center px-2 py-1 text-center leading-tight">
                                <span class="text-base font-bold text-gray-900 dark:text-white">{{ $voteScore }}</span>
                                <span class="text-[0.65rem] font-semibold uppercase text-gray-500 dark:text-gray-400">Score</span>
                            </div>
                            <button type="button" wire:click="voteQuestion({{ $question->id }}, 1)" class="flex items-center justify-center border-l border-gray-300 px-3 py-2 font-semibold transition dark:border-gray-700 {{ $currentVote === 1 ? 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800' }}" title="Thumbs up">
                                <span aria-hidden="true">👍</span>
                                <span class="sr-only">thumbs up</span>
                            </button>
                        </div>
                    </div>
                    <div class="min-w-0 grow">
                        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $question->title }}</h3>
                                    @if($question->is_locked)
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-300">Locked</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Asked by {{ $question->displayAuthor() }} on {{ $question->created_at->format('j M Y') }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <span class="w-fit rounded-full {{ $isAnswered ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }} px-3 py-1 text-xs font-semibold">
                                    {{ $isAnswered ? 'Answered' : 'Unanswered' }}
                                </span>
                                @if($canAnswerQuestions)
                                    <button type="button" wire:click="toggleLocked({{ $question->id }})" class="inline-flex size-8 items-center justify-center rounded-full border transition {{ $question->is_locked ? 'border-red-300 bg-red-50 text-red-700 hover:bg-red-100 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300 dark:hover:bg-red-900/50' : 'border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700' }}" title="{{ $question->is_locked ? 'Unlock question' : 'Lock question' }}" aria-label="{{ $question->is_locked ? 'Unlock question' : 'Lock question' }}">
                                        @if($question->is_locked)
                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v6.75a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                            </svg>
                                        @else
                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M6.75 10.5h10.5A1.5 1.5 0 0 1 18.75 12v6.75a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                            </svg>
                                        @endif
                                    </button>
                                @endif
                                <span class="w-fit rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600 dark:bg-gray-700 dark:text-gray-300">{{ $question->comments_count }} {{ $question->comments_count === 1 ? 'comment' : 'comments' }}</span>
                                <button type="button" wire:click="toggleCollapsed({{ $question->id }})" class="group inline-flex size-8 items-center justify-center rounded-full border border-gray-300 text-gray-700 shadow-sm transition duration-200 ease-out hover:-translate-y-0.5 hover:bg-gray-50 hover:shadow-md active:translate-y-0 active:scale-95 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-700 motion-reduce:transition-none motion-reduce:hover:translate-y-0" title="{{ $isCollapsed ? 'Expand question' : 'Minimise question' }}" aria-label="{{ $isCollapsed ? 'Expand question' : 'Minimise question' }}">
                                    <svg class="size-4 transition-transform duration-300 ease-out group-hover:scale-110 motion-reduce:transition-none {{ $isCollapsed ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if($isCollapsed)
                            <div class="mt-4 rounded-md bg-gray-50 p-3 text-sm text-gray-600 dark:bg-gray-900/40 dark:text-gray-300">
                                {{ $isAnswered ? 'This question has been answered.' : 'This question has not been answered yet.' }}
                                It has {{ $question->comments_count }} {{ $question->comments_count === 1 ? 'comment' : 'comments' }}.
                            </div>
                        @else
                            @if($question->hasBody())
                                <p class="mt-4 whitespace-pre-line text-gray-700 dark:text-gray-300">{{ $question->body }}</p>
                            @endif

                            @if($canAnswerQuestions && ! $question->is_locked)
                                <form wire:submit.prevent="answerQuestion({{ $question->id }})" class="mt-5 space-y-3 rounded-md bg-blue-50 p-4 dark:bg-blue-900/20">
                                    <label for="answer-{{ $question->id }}" class="block text-sm font-semibold text-blue-900 dark:text-blue-200">Answer this question</label>
                                    <textarea wire:model="answerBodies.{{ $question->id }}" id="answer-{{ $question->id }}" rows="3" class="block w-full rounded-md border border-blue-200 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-blue-800 dark:bg-gray-800 dark:text-white" placeholder="Write an answer for members to see..."></textarea>
                                    @error('answerBodies.'.$question->id)
                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    @error('answerAuthorization')
                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">Post answer</button>
                                </form>
                            @elseif($question->is_locked)
                                <div class="mt-5 rounded-md bg-red-50 p-4 text-sm font-medium text-red-700 dark:bg-red-900/20 dark:text-red-300">
                                    This question is locked. No further answers or comments can be added.
                                </div>
                            @endif

                            @if($question->answers->isNotEmpty())
                                <div class="mt-6 space-y-4">
                                    @foreach($question->answers as $answer)
                                        <div wire:key="member-answer-{{ $answer->id }}" class="rounded-md border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                                            <div class="flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400 md:flex-row md:items-center md:justify-between">
                                                <span>Answered by {{ $answer->user?->name ?? 'Club member' }}</span>
                                                <div class="flex items-center gap-2">
                                                    <time datetime="{{ $answer->created_at->toIso8601String() }}">{{ $answer->created_at->format('j M Y, H:i') }}</time>
                                                    @if($answer->user_id === auth()->id())
                                                        <button type="button" wire:click="deleteAnswer({{ $answer->id }})" wire:confirm="Delete this answer and its comments?" class="inline-flex size-7 items-center justify-center rounded-full text-red-600 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/30 dark:hover:text-red-300" title="Delete answer" aria-label="Delete answer">
                                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mt-3 whitespace-pre-line text-gray-700 dark:text-gray-300">{{ $answer->body }}</p>

                                            <div class="mt-4 space-y-3">
                                                @foreach($answer->comments as $comment)
                                                    <div wire:key="member-comment-{{ $comment->id }}" class="border-l-2 border-blue-200 pl-3 dark:border-blue-800">
                                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>
                                                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                                            <p>{{ $comment->displayAuthor() }} · {{ $comment->created_at->format('j M Y') }}</p>
                                                            @if($comment->user_id === auth()->id())
                                                                <button type="button" wire:click="deleteComment({{ $comment->id }})" wire:confirm="Delete this comment?" class="inline-flex size-6 items-center justify-center rounded-full text-red-600 transition hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-900/30 dark:hover:text-red-300" title="Delete comment" aria-label="Delete comment">
                                                                    <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                    </svg>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if(! $question->is_locked)
                                                    <form wire:submit.prevent="addComment({{ $answer->id }})" class="flex flex-col gap-2 md:flex-row">
                                                        <label for="comment-{{ $answer->id }}" class="sr-only">Comment on this answer</label>
                                                        <input wire:model="commentBodies.{{ $answer->id }}" id="comment-{{ $answer->id }}" type="text" maxlength="1200" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white" placeholder="Comment on this answer...">
                                                        <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-white dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">Comment</button>
                                                    </form>
                                                    @error('commentBodies.'.$answer->id)
                                                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                    @enderror
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-lg border border-gray-200 bg-white p-8 text-center text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                No questions found.
            </div>
        @endforelse
    </div>

    <div>
        {{ $questions->links() }}
    </div>
</section>
