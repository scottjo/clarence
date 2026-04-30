<?php

namespace App\Models;

use Database\Factories\MatchReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MatchReport extends Model implements HasMedia
{
    /** @use HasFactory<MatchReportFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'team',
        'opponent',
        'year',
        'title',
        'our_score',
        'opponent_score',
        'author',
        'description',
        'rink_scores',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'year' => 'integer',
            'our_score' => 'integer',
            'opponent_score' => 'integer',
        ];
    }

    public function getResultBadgeColor(): string
    {
        if ($this->our_score > $this->opponent_score) {
            return 'green';
        }

        if ($this->our_score < $this->opponent_score) {
            return 'red';
        }

        return 'amber';
    }

    public function getResultStatus(): string
    {
        if ($this->our_score > $this->opponent_score) {
            return 'Win';
        }

        if ($this->our_score < $this->opponent_score) {
            return 'Loss';
        }

        return 'Draw';
    }
}
