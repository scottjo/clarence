<?php

namespace App\Models;

use Database\Factories\HealthSafetyPageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HealthSafetyPage extends Model implements HasMedia
{
    /** @use HasFactory<HealthSafetyPageFactory> */
    use HasFactory;

    use InteractsWithMedia;

    protected $fillable = ['title', 'slug', 'subtitle', 'content', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('title_image')->singleFile();
        $this->addMediaCollection('attachments');
    }
}
