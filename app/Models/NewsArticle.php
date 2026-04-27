<?php

namespace App\Models;

use Database\Factories\NewsArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NewsArticle extends Model implements HasMedia
{
    /** @use HasFactory<NewsArticleFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('title_image')
            ->singleFile();

        $this->addMediaCollection('gallery');

        $this->addMediaCollection('attachments');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->performOnCollections('title_image', 'gallery');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->performOnCollections('gallery');
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'is_members_only',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_members_only' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
