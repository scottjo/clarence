<?php

namespace App\Models;

use Database\Factories\LeagueStandingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeagueStanding extends Model
{
    /** @use HasFactory<LeagueStandingFactory> */
    use HasFactory;

    protected $fillable = [
        'league_id',
        'season',
        'team_name',
        'played',
        'won',
        'drawn',
        'lost',
        'rinks_won',
        'rinks_drawn',
        'rinks_lost',
        'not_complete',
        'points_for',
        'points_against',
        'points_difference',
        'points',
        'sort_order',
    ];

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
}
