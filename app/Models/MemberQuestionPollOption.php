<?php

namespace App\Models;

use Database\Factories\MemberQuestionPollOptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberQuestionPollOption extends Model
{
    /** @use HasFactory<MemberQuestionPollOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'member_question_id',
        'label',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(MemberQuestion::class, 'member_question_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(MemberQuestionPollVote::class);
    }
}
