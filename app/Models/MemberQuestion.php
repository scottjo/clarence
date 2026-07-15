<?php

namespace App\Models;

use Database\Factories\MemberQuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MemberQuestion extends Model
{
    /** @use HasFactory<MemberQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_anonymous',
        'is_locked',
        'allow_member_answers',
        'is_comment_only',
        'display_name',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'is_locked' => 'boolean',
            'allow_member_answers' => 'boolean',
            'is_comment_only' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(MemberAnswer::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(MemberQuestionVote::class);
    }

    public function pollOptions(): HasMany
    {
        return $this->hasMany(MemberQuestionPollOption::class)->orderBy('sort_order');
    }

    public function pollVotes(): HasMany
    {
        return $this->hasMany(MemberQuestionPollVote::class);
    }

    public function directComments(): HasMany
    {
        return $this->hasMany(MemberQuestionDirectComment::class)->latest();
    }

    public function upVotes(): HasMany
    {
        return $this->hasMany(MemberQuestionVote::class)->where('value', 1);
    }

    public function downVotes(): HasMany
    {
        return $this->hasMany(MemberQuestionVote::class)->where('value', -1);
    }

    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(
            MemberQuestionComment::class,
            MemberAnswer::class,
            'member_question_id',
            'member_answer_id',
        );
    }

    public function displayAuthor(): string
    {
        return $this->is_anonymous ? 'Anonymous member' : ($this->display_name ?: $this->user?->name ?: 'Member');
    }

    public function hasBody(): bool
    {
        return filled($this->body);
    }

    public function canBeAnsweredBy(User $user): bool
    {
        return ! $this->is_comment_only && ($this->allow_member_answers || $user->canAnswerMemberQuestions());
    }

    public function visibleCommentsCount(): int
    {
        if ($this->is_comment_only) {
            return (int) ($this->direct_comments_count ?? $this->directComments()->count());
        }

        return (int) ($this->comments_count ?? $this->comments()->count());
    }
}
