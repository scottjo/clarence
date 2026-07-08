<?php

namespace Tests;

use App\Enums\UserRole;
use App\Filament\Pages\Settings;
use App\Models\Competition;
use App\Models\Event;
use App\Models\Media;
use App\Models\MemberAnswer;
use App\Models\MemberQuestion;
use App\Models\MemberQuestionComment;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

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

    public function test_media_user_can_access_media_resource(): void
    {
        $mediaUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::MediaUser->value],
        ]);

        $this->actingAs($mediaUser);

        $this->assertTrue($mediaUser->can('viewAny', Media::class));
    }

    public function test_content_maintainer_cannot_access_media_resource(): void
    {
        $contentUser = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::ContentMaintainer->value],
        ]);

        $this->actingAs($contentUser);

        $this->assertFalse($contentUser->can('viewAny', Media::class));
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
        $this->assertTrue($user->can('delete', User::factory()->create()));
        $this->assertTrue($user->can('viewAny', MemberQuestion::class));
        $this->assertTrue($user->can('update', MemberAnswer::factory()->create()));
        $this->assertTrue($user->can('delete', MemberQuestionComment::factory()->create()));
    }

    public function test_question_moderator_can_censor_member_questions_answers_and_comments(): void
    {
        $moderator = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::QuestionModerator->value],
        ]);

        $this->actingAs($moderator);

        $this->assertTrue($moderator->canModerateMemberQuestions());
        $this->assertTrue($moderator->can('viewAny', MemberQuestion::class));
        $this->assertTrue($moderator->can('update', MemberQuestion::factory()->create()));
        $this->assertTrue($moderator->can('delete', MemberQuestion::factory()->create()));
        $this->assertTrue($moderator->can('viewAny', MemberAnswer::class));
        $this->assertTrue($moderator->can('update', MemberAnswer::factory()->create()));
        $this->assertTrue($moderator->can('delete', MemberQuestionComment::factory()->create()));
        $this->assertFalse($moderator->can('viewAny', User::class));
    }

    public function test_question_answerer_can_answer_but_not_censor_member_questions(): void
    {
        $answerer = User::factory()->create([
            'is_admin' => false,
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);

        $this->actingAs($answerer);

        $this->assertTrue($answerer->canAnswerMemberQuestions());
        $this->assertTrue($answerer->can('viewAny', MemberAnswer::class));
        $this->assertTrue($answerer->can('create', MemberAnswer::class));
        $this->assertFalse($answerer->can('viewAny', MemberQuestion::class));
        $this->assertFalse($answerer->can('update', MemberAnswer::factory()->create()));
        $this->assertFalse($answerer->can('delete', MemberQuestionComment::factory()->create()));
    }

    public function test_super_user_can_access_horizon(): void
    {
        $superUser = User::factory()->create([
            'roles' => [UserRole::SuperUser->value],
        ]);

        $this->assertTrue(Gate::forUser($superUser)->allows('viewHorizon'));
    }

    public function test_emergency_email_can_access_horizon(): void
    {
        config(['app.super_user_email' => 'emergency@example.com']);

        $user = User::factory()->create([
            'email' => 'emergency@example.com',
        ]);

        $this->assertTrue(Gate::forUser($user)->allows('viewHorizon'));
    }

    public function test_regular_user_cannot_access_horizon(): void
    {
        $user = User::factory()->create([
            'roles' => [UserRole::ContentMaintainer->value],
        ]);

        $this->assertFalse(Gate::forUser($user)->allows('viewHorizon'));
    }
}
