<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionWinner extends Model
{
    protected $fillable = [
        'competition_id',
        'year',
        'category',
        'names',
        'no_competition',
    ];

    protected function casts(): array
    {
        return [
            'names' => 'array',
            'no_competition' => 'boolean',
        ];
    }

    public function competition(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
}
