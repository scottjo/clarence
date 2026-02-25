<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    /** @use HasFactory<\Database\Factories\NewsArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'attachments',
        'is_active',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'datetime',
            'attachments' => 'array',
        ];
    }
}
