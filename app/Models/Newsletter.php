<?php

namespace App\Models;

use Database\Factories\NewsletterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Newsletter extends Model implements HasMedia
{
    /** @use HasFactory<NewsletterFactory> */
    use HasFactory;

    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'type',
        'issue_date',
        'is_active',
    ];

    public const TYPE_NEWSLETTER = 'newsletter';

    public const TYPE_MINUTES = 'minutes';

    public const TYPE_OTHER = 'other';

    /**
     * @return array<string, string>
     */
    public static function typeOptions(): array
    {
        return [
            self::TYPE_NEWSLETTER => 'Newsletter',
            self::TYPE_MINUTES => 'Committee Minutes',
            self::TYPE_OTHER => 'Other',
        ];
    }

    public function typeLabel(): string
    {
        return self::typeOptions()[$this->type] ?? ucfirst((string) $this->type);
    }

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function isRecent(): bool
    {
        return $this->created_at->gt(now()->subDays(14));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('newsletter_pdf')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(280)
            ->sharpen(10)
            ->nonQueued();
    }
}
