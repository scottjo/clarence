<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookARinkAdvertTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_shows_default_book_a_rink_advert(): void
    {
        Setting::factory()->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Book a rink')
            ->assertSee('Turn up and play')
            ->assertSee('£5 per person per session')
            ->assertSee('07895 255006')
            ->assertSee('tel:07895255006', false);
    }

    public function test_home_page_uses_configured_book_a_rink_advert_details(): void
    {
        Setting::factory()->create([
            'book_a_rink_price' => '£7.50 per visitor',
            'book_a_rink_phone' => '01934 123456',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('£7.50 per visitor')
            ->assertSee('01934 123456')
            ->assertSee('tel:01934123456', false);
    }

    public function test_home_page_can_hide_book_a_rink_advert(): void
    {
        Setting::factory()->create([
            'book_a_rink_advert_enabled' => false,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Book a rink')
            ->assertDontSee('Turn up and play');
    }
}
