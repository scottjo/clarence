<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionResult extends Model
{
    protected $fillable = [
        'competition_id',
        'year',
        'category',
        'winner_name',
        'no_competition',
    ];

    protected function casts(): array
    {
        return [
            'no_competition' => 'boolean',
        ];
    }

    public function competition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
