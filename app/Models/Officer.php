<?php

namespace App\Models;

use App\Enums\OfficerRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Officer extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
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

    public function classification(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficerClassification::class, 'classification_id');
    }
}
