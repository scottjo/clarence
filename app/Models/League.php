<?php

namespace App\Models;

use Database\Factories\LeagueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class League extends Model
{
    /** @use HasFactory<LeagueFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('active_leagues'));
        static::deleted(fn () => Cache::forget('active_leagues'));
    }

    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'description',
        'is_active',
        'sort_order',
        'message',
    ];

    /** @return array<string, mixed> */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function standings(): HasMany
    {
        return $this->hasMany(LeagueStanding::class)
            ->orderBy('sort_order')
            ->orderByDesc('points')
            ->orderByDesc('points_difference');
    }
}
