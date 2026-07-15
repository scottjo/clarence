<?php

namespace App\Models;

use Database\Factories\MemberQuestionDirectCommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberQuestionDirectComment extends Model
{
    /** @use HasFactory<MemberQuestionDirectCommentFactory> */
    use HasFactory;

    protected $fillable = [
        'member_question_id',
        'user_id',
        'body',
        'is_anonymous',
        'display_name',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(MemberQuestion::class, 'member_question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function displayAuthor(): string
    {
        return $this->is_anonymous ? 'Anonymous member' : ($this->display_name ?: $this->user?->name ?: 'Member');
    }
}
