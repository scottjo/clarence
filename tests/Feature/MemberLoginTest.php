<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_login_button_is_visible_when_url_is_set(): void
    {
        Setting::factory()->create([
            'member_login_url' => 'https://example.com/login',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Member Login');
        $response->assertSee('https://example.com/login');
        $response->assertSee('target="_blank"', false);
    }

    public function test_member_login_button_is_not_visible_when_url_is_not_set(): void
    {
        Setting::factory()->create([
            'member_login_url' => null,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertDontSee('Member Login');
    }
}
