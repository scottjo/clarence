<?php

namespace App\Models;

use App\Enums\GradientDirection;
use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header_logo')
            ->singleFile();

        $this->addMediaCollection('footer_logo_left')
            ->singleFile();

        $this->addMediaCollection('footer_logo_right')
            ->singleFile();

        $this->addMediaCollection('membership_application_form')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

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
        'show_fixtures_results',
        'winner_col_bg',
        'winner_col_bg_dark',
        'winner_comp_text_color',
        'winner_comp_text_color_dark',
        'winner_name_text_color',
        'winner_name_text_color_dark',
        'useful_contacts_message',
        'countdown_active',
        'countdown_message',
        'countdown_target_date',
        'countdown_event_id',
        'members_password',
        'members_area_heading',
        'members_area_intro',
    ];

    protected function casts(): array
    {
        return [
            'header_gradient_direction' => GradientDirection::class,
            'footer_gradient_direction' => GradientDirection::class,
            'sponsor_panel_show_on_all_pages' => 'boolean',
            'sponsor_panel_pages' => 'array',
            'show_fixtures_results' => 'boolean',
            'countdown_active' => 'boolean',
            'countdown_target_date' => 'datetime',
        ];
    }

    public function countdownEvent(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'countdown_event_id');
    }
}
