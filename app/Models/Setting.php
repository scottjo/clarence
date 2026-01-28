<?php

namespace App\Models;

use App\Enums\GradientDirection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
        static::deleted(fn () => Cache::forget('settings'));
    }

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
        'member_login_url',
        'sponsor_panel_bg_color',
        'sponsor_panel_bg_color_dark',
        'sponsor_panel_pinstripe_color',
        'sponsor_panel_pinstripe_width',
        'sponsor_panel_pinstripe_style',
        'sponsor_panel_show_on_all_pages',
        'sponsor_panel_pages',
    ];

    protected function casts(): array
    {
        return [
            'header_gradient_direction' => GradientDirection::class,
            'footer_gradient_direction' => GradientDirection::class,
            'sponsor_panel_show_on_all_pages' => 'boolean',
            'sponsor_panel_pages' => 'array',
        ];
    }
}
