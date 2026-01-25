<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_are_protected(): void
    {
        $this->get('/admin')
            ->assertRedirect('/admin/login');
    }

    public function test_contact_form_is_accessible(): void
    {
        $this->get('/contact')
            ->assertStatus(200);
    }

    public function test_debug_mode_is_on_in_local_but_recommends_off_for_production(): void
    {
        $this->assertTrue(config('app.debug'), 'Debug mode should be enabled in local for development, but must be disabled in production.');
    }

    public function test_environment_is_local_or_testing(): void
    {
        $this->assertContains(config('app.env'), ['local', 'testing']);
    }
}
