<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class MembershipPageTitleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $settings = Setting::factory()->create(['club_name' => 'Clarence Bowls Club']);
        View::share('settings', $settings);
    }

    public function test_membership_page_has_the_correct_title(): void
    {
        $this->get(route('about.membership'))
            ->assertStatus(200)
            ->assertSee('<title>Join Clarence Bowls Club | Lawn Bowls in Weston-super-Mare</title>', false);
    }
}
