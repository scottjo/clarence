<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ContactPageTitleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $settings = Setting::factory()->create(['club_name' => 'Clarence Bowls Club']);
        View::share('settings', $settings);
    }

    public function test_contact_page_has_the_correct_title(): void
    {
        $this->get(route('contact'))
            ->assertStatus(200)
            ->assertSee('<title>Contact Clarence Bowls Club | Weston-super-Mare</title>', false);
    }
}
