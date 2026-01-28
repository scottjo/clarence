<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Hero extends Model
{
    /** @use HasFactory<\Database\Factories\HeroFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(function (Hero $hero): void {
            Cache::forget("hero:{$hero->page_identifier}");
        });
        static::deleted(function (Hero $hero): void {
            Cache::forget("hero:{$hero->page_identifier}");
        });
    }

    protected function casts(): array
    {
        return [
            'overlay_opacity' => 'integer',
        ];
    }

    protected $fillable = [
        'page_identifier',
        'image',
        'title',
        'subtitle',
        'intro_text',
        'title_color',
        'title_size',
        'subtitle_color',
        'subtitle_size',
        'intro_color',
        'intro_size',
        'font_family',
        'overlay_opacity',
    ];
}
