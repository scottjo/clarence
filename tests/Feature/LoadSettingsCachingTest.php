<?php

namespace Tests\Feature;

use App\Enums\SocialPlatform;
use App\Models\Hero;
use App\Models\IntroBlock;
use App\Models\Setting;
use App\Models\SocialMediaLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LoadSettingsCachingTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_are_cached_after_first_request(): void
    {
        Setting::create(['club_name' => 'Test Club']);

        $this->get(route('home'));

        $this->assertNotNull(Cache::get('settings'));
        $this->assertEquals('Test Club', Cache::get('settings')->club_name);
    }

    public function test_social_links_are_cached_after_first_request(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        SocialMediaLink::create([
            'platform' => SocialPlatform::Facebook,
            'url' => 'https://facebook.com/test',
            'icon' => '<svg></svg>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('home'));

        $cached = Cache::get('social_links');
        $this->assertNotNull($cached);
        $this->assertCount(1, $cached);
        $this->assertEquals(SocialPlatform::Facebook, $cached->first()->platform);
    }

    public function test_hero_is_cached_per_route(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        Hero::create([
            'page_identifier' => 'home',
            'title' => 'Welcome Home',
        ]);

        $this->get(route('home'));

        $cached = Cache::get('hero:home');
        $this->assertNotNull($cached);
        $this->assertEquals('Welcome Home', $cached->title);
    }

    public function test_intro_block_is_cached_per_route(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        IntroBlock::create([
            'page_identifier' => 'home',
            'content' => 'Welcome content',
            'is_active' => true,
        ]);

        $this->get(route('home'));

        $cached = Cache::get('intro_block:home');
        $this->assertNotNull($cached);
        $this->assertEquals('Welcome content', $cached->content);
    }

    public function test_settings_cache_is_cleared_on_update(): void
    {
        $settings = Setting::create(['club_name' => 'Old Name']);

        $this->get(route('home'));
        $this->assertEquals('Old Name', Cache::get('settings')->club_name);

        $settings->update(['club_name' => 'New Name']);

        $this->assertNull(Cache::get('settings'));
    }

    public function test_settings_cache_is_cleared_on_delete(): void
    {
        $settings = Setting::create(['club_name' => 'Test Club']);

        $this->get(route('home'));
        $this->assertNotNull(Cache::get('settings'));

        $settings->delete();

        $this->assertNull(Cache::get('settings'));
    }

    public function test_social_links_cache_is_cleared_on_save(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $link = SocialMediaLink::create([
            'platform' => SocialPlatform::Facebook,
            'url' => 'https://facebook.com/test',
            'icon' => '<svg></svg>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('home'));
        $this->assertNotNull(Cache::get('social_links'));

        $link->update(['platform' => SocialPlatform::Twitter]);

        $this->assertNull(Cache::get('social_links'));
    }

    public function test_social_links_cache_is_cleared_on_delete(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $link = SocialMediaLink::create([
            'platform' => SocialPlatform::Facebook,
            'url' => 'https://facebook.com/test',
            'icon' => '<svg></svg>',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('home'));
        $this->assertNotNull(Cache::get('social_links'));

        $link->delete();

        $this->assertNull(Cache::get('social_links'));
    }

    public function test_hero_cache_is_cleared_on_update(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $hero = Hero::create([
            'page_identifier' => 'home',
            'title' => 'Old Title',
        ]);

        $this->get(route('home'));
        $this->assertEquals('Old Title', Cache::get('hero:home')->title);

        $hero->update(['title' => 'New Title']);

        $this->assertNull(Cache::get('hero:home'));
    }

    public function test_hero_cache_is_cleared_on_delete(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $hero = Hero::create([
            'page_identifier' => 'home',
            'title' => 'Welcome',
        ]);

        $this->get(route('home'));
        $this->assertNotNull(Cache::get('hero:home'));

        $hero->delete();

        $this->assertNull(Cache::get('hero:home'));
    }

    public function test_intro_block_cache_is_cleared_on_update(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $intro = IntroBlock::create([
            'page_identifier' => 'home',
            'content' => 'Old content',
            'is_active' => true,
        ]);

        $this->get(route('home'));
        $this->assertEquals('Old content', Cache::get('intro_block:home')->content);

        $intro->update(['content' => 'New content']);

        $this->assertNull(Cache::get('intro_block:home'));
    }

    public function test_intro_block_cache_is_cleared_on_delete(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        $intro = IntroBlock::create([
            'page_identifier' => 'home',
            'content' => 'Welcome',
            'is_active' => true,
        ]);

        $this->get(route('home'));
        $this->assertNotNull(Cache::get('intro_block:home'));

        $intro->delete();

        $this->assertNull(Cache::get('intro_block:home'));
    }

    public function test_different_routes_have_separate_hero_caches(): void
    {
        Setting::create(['club_name' => 'Test Club']);
        Hero::create(['page_identifier' => 'home', 'title' => 'Home Hero']);
        Hero::create(['page_identifier' => 'about', 'title' => 'About Hero']);

        $this->get(route('home'));
        $this->assertEquals('Home Hero', Cache::get('hero:home')->title);

        // Updating home hero doesn't affect about hero cache
        Hero::where('page_identifier', 'home')->first()->update(['title' => 'Updated Home']);
        $this->assertNull(Cache::get('hero:home'));

        // About hero remains untouched in cache after home is busted
        $this->get(route('about'));
        $this->assertEquals('About Hero', Cache::get('hero:about')->title);
    }

    public function test_null_hero_and_intro_are_cached_to_prevent_repeated_queries(): void
    {
        Setting::create(['club_name' => 'Test Club']);

        // First request caches null hero/intro for "home"
        $this->get(route('home'));

        // Second request should not query heroes or intro_blocks tables
        $middlewareQueries = [];
        \Illuminate\Support\Facades\DB::listen(function ($query) use (&$middlewareQueries): void {
            if (str_contains($query->sql, 'heroes') || str_contains($query->sql, 'intro_blocks')
                || str_contains($query->sql, 'settings') || str_contains($query->sql, 'social_media_links')) {
                $middlewareQueries[] = $query->sql;
            }
        });

        $this->get(route('home'));

        $this->assertEmpty($middlewareQueries, 'Cached middleware data should not trigger DB queries: '.implode(', ', $middlewareQueries));
    }
}
