<?php

namespace App\Models;

use Database\Factories\MemberQuestionVoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberQuestionVote extends Model
{
    /** @use HasFactory<MemberQuestionVoteFactory> */
    use HasFactory;

    protected $fillable = [
        'member_question_id',
        'user_id',
        'value',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'integer',
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
}
