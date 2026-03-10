<?php

namespace Tests\Feature;

use App\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_announcement_is_returned_by_scope(): void
    {
        Announcement::create([
            'header' => 'Active',
            'text' => 'This is active',
            'type' => 'info',
            'is_active' => true,
        ]);

        $this->assertEquals(1, Announcement::active()->count());
    }

    public function test_inactive_announcement_is_not_returned_by_scope(): void
    {
        Announcement::create([
            'header' => 'Inactive',
            'text' => 'This is inactive',
            'type' => 'info',
            'is_active' => false,
        ]);

        $this->assertEquals(0, Announcement::active()->count());
    }

    public function test_announcement_with_future_starts_at_is_not_returned(): void
    {
        Announcement::create([
            'header' => 'Future',
            'text' => 'This is future',
            'type' => 'info',
            'is_active' => true,
            'starts_at' => now()->addDay(),
        ]);

        $this->assertEquals(0, Announcement::active()->count());
    }

    public function test_announcement_with_past_ends_at_is_not_returned(): void
    {
        Announcement::create([
            'header' => 'Past',
            'text' => 'This is past',
            'type' => 'info',
            'is_active' => true,
            'ends_at' => now()->subDay(),
        ]);

        $this->assertEquals(0, Announcement::active()->count());
    }

    public function test_announcement_within_date_range_is_returned(): void
    {
        Announcement::create([
            'header' => 'Valid',
            'text' => 'This is valid',
            'type' => 'info',
            'is_active' => true,
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addDay(),
        ]);

        $this->assertEquals(1, Announcement::active()->count());
    }

    public function test_announcement_is_visible_on_home_page(): void
    {
        Announcement::create([
            'header' => 'Home Page Alert',
            'text' => 'Important news!',
            'type' => 'danger',
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Home Page Alert');
        $response->assertSee('Important news!');
    }

    public function test_announcement_is_visible_on_news_page(): void
    {
        Announcement::create([
            'header' => 'News Page Alert',
            'text' => 'Important news!',
            'type' => 'danger',
            'is_active' => true,
        ]);

        $response = $this->get(route('news'));

        $response->assertStatus(200);
        $response->assertSee('News Page Alert');
        $response->assertSee('Important news!');
    }

    public function test_announcement_is_not_visible_on_other_pages(): void
    {
        Announcement::create([
            'header' => 'Home Page Alert',
            'text' => 'Important news!',
            'type' => 'danger',
            'is_active' => true,
        ]);

        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertDontSee('Home Page Alert');
    }
}
