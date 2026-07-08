<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Resources\MemberAnswers\Pages\CreateMemberAnswer;
use App\Filament\Resources\MemberQuestionComments\Pages\EditMemberQuestionComment;
use App\Filament\Resources\MemberQuestions\Pages\EditMemberQuestion;
use App\Filament\Resources\MemberQuestions\Pages\ListMemberQuestions;
use App\Models\MemberAnswer;
use App\Models\MemberQuestion;
use App\Models\MemberQuestionComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberQuestionModerationFilamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_moderator_can_render_question_moderation_list(): void
    {
        $this->actingAs(User::factory()->create([
            'roles' => [UserRole::QuestionModerator->value],
        ]));

        MemberQuestion::factory()->create([
            'title' => 'Question to moderate',
        ]);

        Livewire::test(ListMemberQuestions::class)
            ->assertStatus(200)
            ->assertSee('Question to moderate');
    }

    public function test_question_moderator_can_censor_question_and_comment(): void
    {
        $this->actingAs(User::factory()->create([
            'roles' => [UserRole::QuestionModerator->value],
        ]));

        $question = MemberQuestion::factory()->create([
            'title' => 'Original question title',
            'body' => 'Original question details.',
        ]);
        $comment = MemberQuestionComment::factory()->create([
            'body' => 'Original comment body.',
        ]);

        Livewire::test(EditMemberQuestion::class, [
            'record' => $question->id,
        ])
            ->fillForm([
                'title' => 'Censored question title',
                'body' => 'Censored question details.',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        Livewire::test(EditMemberQuestionComment::class, [
            'record' => $comment->id,
        ])
            ->fillForm([
                'body' => 'Censored comment body.',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(MemberQuestion::class, [
            'id' => $question->id,
            'title' => 'Censored question title',
            'body' => 'Censored question details.',
        ]);
        $this->assertDatabaseHas(MemberQuestionComment::class, [
            'id' => $comment->id,
            'body' => 'Censored comment body.',
        ]);
    }

    public function test_question_answerer_can_create_answer_in_filament(): void
    {
        $answerer = User::factory()->create([
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);
        $question = MemberQuestion::factory()->create([
            'title' => 'Question that needs an answer',
        ]);

        $this->actingAs($answerer);

        Livewire::test(CreateMemberAnswer::class)
            ->fillForm([
                'member_question_id' => $question->id,
                'body' => 'An official answer from Filament.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(MemberAnswer::class, [
            'member_question_id' => $question->id,
            'user_id' => $answerer->id,
            'body' => 'An official answer from Filament.',
        ]);
    }
}
