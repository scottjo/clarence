<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class IntroBlock extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\IntroBlockFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('left_image')
            ->singleFile();

        $this->addMediaCollection('right_image')
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
        static::saved(function (IntroBlock $introBlock): void {
            Cache::forget("intro_block:{$introBlock->page_identifier}");
        });
        static::deleted(function (IntroBlock $introBlock): void {
            Cache::forget("intro_block:{$introBlock->page_identifier}");
        });
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected $fillable = [
        'page_identifier',
        'content',
        'font_color',
        'is_active',
    ];
}
