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
}
