<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroBlock extends Model
{
    /** @use HasFactory<\Database\Factories\IntroBlockFactory> */
    use HasFactory;

    protected $fillable = [
        'page_identifier',
        'content',
        'font_color',
        'left_image',
        'right_image',
        'is_active',
    ];
}
