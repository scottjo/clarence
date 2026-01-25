<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    /** @use HasFactory<\Database\Factories\HeroFactory> */
    use HasFactory;

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
