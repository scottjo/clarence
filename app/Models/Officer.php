<?php

namespace App\Models;

use App\Enums\OfficerRole;
use Database\Factories\OfficerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Officer extends Model implements HasMedia
{
    /** @use HasFactory<OfficerFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    protected $fillable = [
        'name',
        'biography',
        'role',
        'sort_order',
        'is_active',
        'classification_id',
    ];

    protected function casts(): array
    {
        return [
            'role' => OfficerRole::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(OfficerClassification::class, 'classification_id');
    }
}
