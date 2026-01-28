<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class IntroBlock extends Model
{
    /** @use HasFactory<\Database\Factories\IntroBlockFactory> */
    use HasFactory;

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
        'left_image',
        'right_image',
        'is_active',
    ];
}
