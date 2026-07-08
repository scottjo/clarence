<?php

namespace App\Models;

use Database\Factories\MemberAnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberAnswer extends Model
{
    /** @use HasFactory<MemberAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'member_question_id',
        'user_id',
        'body',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(MemberQuestion::class, 'member_question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(MemberQuestionComment::class);
    }
}
