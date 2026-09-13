<?php

namespace Tests\Feature;

use App\Models\IntroBlock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeVideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_home_video_follows_the_introduction_and_precedes_news(): void
    {
        $intro = IntroBlock::factory()->make([
            'page_identifier' => 'home',
            'content' => '<p>Welcome to our bowling greens.</p>',
        ]);
        unset($intro->left_image, $intro->right_image);
        $intro->save();

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeInOrder(['Welcome to our bowling greens.', 'A view of Clarence', 'Latest News'])
            ->assertSee('data-src="'.asset('images/clarence-club.mp4').'"', false)
            ->assertSee('poster="'.asset('images/clarence-club-poster.jpg').'"', false)
            ->assertSee('preload="none"', false)
            ->assertSee('playsinline', false)
            ->assertSee('muted', false)
            ->assertSee('loop', false)
            ->assertSee('Pause video');
    }

    public function test_home_video_is_available_without_an_introduction(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('A view of Clarence');
    }
}
