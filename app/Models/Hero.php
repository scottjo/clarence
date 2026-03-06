<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Hero extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\HeroFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

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
