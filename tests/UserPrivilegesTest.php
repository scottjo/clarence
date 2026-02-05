<?php

use App\Enums\UserRole;
use App\Filament\Pages\Settings;
use App\Models\Competition;
use App\Models\Event;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPrivilegesTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_user_can_access_user_maintenance(): void
    {
        $superUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::SuperUser->value],
        ]);

        $this->actingAs($superUser);

        $this->assertTrue($superUser->can('viewAny', User::class));
    }

    public function test_administrator_cannot_access_user_maintenance(): void
    {
        $admin = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::Administrator->value],
        ]);

        $this->actingAs($admin);

        $this->assertFalse($admin->can('viewAny', User::class));
    }

    public function test_content_maintainer_can_access_events(): void
    {
        $contentUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::ContentMaintainer->value],
        ]);

        $this->actingAs($contentUser);

        $this->assertTrue($contentUser->can('viewAny', Event::class));
    }

    public function test_content_maintainer_cannot_access_sponsors(): void
    {
        $contentUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::ContentMaintainer->value],
        ]);

        $this->actingAs($contentUser);

        $this->assertFalse($contentUser->can('viewAny', Sponsor::class));
    }

    public function test_administrator_can_access_sponsors(): void
    {
        $admin = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::Administrator->value],
        ]);

        $this->actingAs($admin);

        $this->assertTrue($admin->can('viewAny', Sponsor::class));
    }

    public function test_content_maintainer_cannot_access_settings_page(): void
    {
        $contentUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::ContentMaintainer->value, UserRole::MediaUser->value],
        ]);

        $this->actingAs($contentUser);

        $this->assertFalse(Settings::canAccess());
    }

    public function test_content_maintainer_cannot_access_competitions_resource(): void
    {
        $contentUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::ContentMaintainer->value, UserRole::MediaUser->value],
        ]);

        $this->actingAs($contentUser);

        $this->assertFalse($contentUser->can('viewAny', Competition::class));
    }

    public function test_administrator_can_access_settings_page(): void
    {
        $admin = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::Administrator->value],
        ]);

        $this->actingAs($admin);

        $this->assertTrue(Settings::canAccess());
    }

    public function test_emergency_email_acts_as_super_user(): void
    {
        config(['app.super_user_email' => 'emergency@example.com']);

        $user = User::factory()->create([
            'email' => 'emergency@example.com',
            'is_admin' => false,
            'roles' => [],
        ]);

        $this->assertTrue($user->isSuperUser());
        $this->assertTrue($user->can('viewAny', User::class));
    }
}
