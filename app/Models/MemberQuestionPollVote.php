<?php

namespace App\Models;

use Database\Factories\MemberQuestionPollVoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberQuestionPollVote extends Model
{
    /** @use HasFactory<MemberQuestionPollVoteFactory> */
    use HasFactory;

    protected $fillable = [
        'member_question_id',
        'member_question_poll_option_id',
        'user_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(MemberQuestion::class, 'member_question_id');
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(MemberQuestionPollOption::class, 'member_question_poll_option_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
