<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_area_uses_internal_route_when_legacy_url_is_set(): void
    {
        Setting::factory()->create([
            'member_login_url' => 'https://example.com/login',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Members Area');
        $response->assertSee('href="'.route('members').'"', false);
        $response->assertDontSee('https://example.com/login');
    }

    public function test_members_area_is_visible_without_a_legacy_url(): void
    {
        Setting::factory()->create([
            'member_login_url' => null,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Members Area');
        $response->assertSee('href="'.route('members').'"', false);
    }
}
