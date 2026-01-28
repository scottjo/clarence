<?php

namespace App\Models;

use App\Enums\SocialPlatform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SocialMediaLink extends Model
{
    /** @use HasFactory<\Database\Factories\SocialMediaLinkFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('social_links'));
        static::deleted(fn () => Cache::forget('social_links'));
    }

    protected $fillable = [
        'platform',
        'url',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'platform' => SocialPlatform::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
