<?php

namespace App\Models;

use App\Enums\GradientDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'club_name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'header_logo',
        'footer_logo_left',
        'footer_logo_right',
        'menu_color',
        'footer_color',
        'menu_text_color',
        'footer_text_color',
        'page_bg_color',
        'page_bg_color_dark',
        'header_gradient_start',
        'header_gradient_end',
        'header_gradient_direction',
        'footer_gradient_start',
        'footer_gradient_end',
        'footer_gradient_direction',
        'pinstripe_color',
        'pinstripe_width',
        'pinstripe_style',
    ];

    protected function casts(): array
    {
        return [
            'header_gradient_direction' => GradientDirection::class,
            'footer_gradient_direction' => GradientDirection::class,
        ];
    }
}
