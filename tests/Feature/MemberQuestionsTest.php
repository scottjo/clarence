<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\MemberAnswer;
use App\Models\MemberQuestion;
use App\Models\MemberQuestionComment;
use App\Models\MemberQuestionPollOption;
use App\Models\MemberQuestionPollVote;
use App\Models\MemberQuestionVote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class MemberQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_ask_question_anonymously(): void
    {
        $user = User::factory()->create([
            'name' => 'Jane Member',
        ]);

        Livewire::actingAs($user)
            ->test('member-questions')
            ->set('title', 'When is roll up night?')
            ->set('body', 'I would like to know the summer roll up schedule.')
            ->set('isAnonymous', true)
            ->call('askQuestion')
            ->assertHasNoErrors()
            ->assertSee('When is roll up night?')
            ->assertSee('Anonymous member')
            ->assertDontSee('Jane Member');

        $this->assertDatabaseHas(MemberQuestion::class, [
            'title' => 'When is roll up night?',
            'is_anonymous' => true,
            'display_name' => null,
        ]);
    }

    public function test_question_form_opens_as_dialog_from_toolbar(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('member-questions')
            ->assertSet('showQuestionForm', false)
            ->assertSee('Ask question')
            ->assertDontSee('Post question')
            ->call('openQuestionForm')
            ->assertSet('showQuestionForm', true)
            ->assertSee('Post question')
            ->set('title', 'Can I bring a guest?')
            ->set('body', '')
            ->call('askQuestion')
            ->assertHasNoErrors()
            ->assertSet('showQuestionForm', false)
            ->assertSee('Can I bring a guest?');

        $this->assertDatabaseHas(MemberQuestion::class, [
            'title' => 'Can I bring a guest?',
            'body' => null,
        ]);
    }

    public function test_designated_member_can_answer_question(): void
    {
        $answerer = User::factory()->create([
            'name' => 'Club Secretary',
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);

        $question = MemberQuestion::factory()->create([
            'title' => 'Fixture question',
        ]);

        Livewire::actingAs($answerer)
            ->test('member-questions')
            ->set("answerBodies.{$question->id}", 'The fixture list is updated every Monday.')
            ->call('answerQuestion', $question->id)
            ->assertHasNoErrors()
            ->assertSee('The fixture list is updated every Monday.')
            ->assertSee('Club Secretary');

        $this->assertDatabaseHas(MemberAnswer::class, [
            'member_question_id' => $question->id,
            'user_id' => $answerer->id,
            'body' => 'The fixture list is updated every Monday.',
        ]);
    }

    public function test_member_can_delete_their_own_answer(): void
    {
        $answerer = User::factory()->create([
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);
        $answer = MemberAnswer::factory()->create([
            'user_id' => $answerer->id,
            'body' => 'This answer should be deleted.',
        ]);
        $comment = MemberQuestionComment::factory()->create([
            'member_answer_id' => $answer->id,
            'body' => 'This comment should be deleted with the answer.',
        ]);

        Livewire::actingAs($answerer)
            ->test('member-questions')
            ->assertSee('This answer should be deleted.')
            ->assertSee('This comment should be deleted with the answer.')
            ->call('deleteAnswer', $answer->id)
            ->assertHasNoErrors()
            ->assertDontSee('This answer should be deleted.')
            ->assertDontSee('This comment should be deleted with the answer.');

        $this->assertDatabaseMissing(MemberAnswer::class, [
            'id' => $answer->id,
        ]);
        $this->assertDatabaseMissing(MemberQuestionComment::class, [
            'id' => $comment->id,
        ]);
    }

    public function test_member_cannot_delete_another_members_answer(): void
    {
        $member = User::factory()->create();
        $answerer = User::factory()->create([
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);
        $answer = MemberAnswer::factory()->create([
            'user_id' => $answerer->id,
            'body' => 'This answer should remain.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->call('deleteAnswer', $answer->id)
            ->assertForbidden();

        $this->assertDatabaseHas(MemberAnswer::class, [
            'id' => $answer->id,
            'body' => 'This answer should remain.',
        ]);
    }

    public function test_member_can_ask_question_without_details(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('member-questions')
            ->set('title', 'Can I book a rink online?')
            ->set('body', '')
            ->call('askQuestion')
            ->assertHasNoErrors()
            ->assertSee('Can I book a rink online?');

        $this->assertDatabaseHas(MemberQuestion::class, [
            'title' => 'Can I book a rink online?',
            'body' => null,
        ]);
    }

    public function test_regular_member_cannot_answer_question(): void
    {
        $member = User::factory()->create();
        $question = MemberQuestion::factory()->create();

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set("answerBodies.{$question->id}", 'I should not be able to answer officially.')
            ->call('answerQuestion', $question->id)
            ->assertHasErrors(['answerAuthorization']);

        $this->assertDatabaseMissing(MemberAnswer::class, [
            'member_question_id' => $question->id,
            'body' => 'I should not be able to answer officially.',
        ]);
    }

    public function test_question_can_allow_any_member_to_answer(): void
    {
        $member = User::factory()->create([
            'name' => 'Helpful Member',
        ]);
        $question = MemberQuestion::factory()->create([
            'title' => 'Open answer question',
            'allow_member_answers' => true,
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('Open answers')
            ->set("answerBodies.{$question->id}", 'Any member can answer this one.')
            ->call('answerQuestion', $question->id)
            ->assertHasNoErrors()
            ->assertSee('Any member can answer this one.')
            ->assertSee('Helpful Member');

        $this->assertDatabaseHas(MemberAnswer::class, [
            'member_question_id' => $question->id,
            'user_id' => $member->id,
            'body' => 'Any member can answer this one.',
        ]);
    }

    public function test_member_can_create_question_with_poll_options(): void
    {
        $member = User::factory()->create();

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set('title', 'Which social night should we run?')
            ->set('hasPoll', true)
            ->set('pollOptions', ['Friday bowls', 'Saturday quiz', ''])
            ->call('askQuestion')
            ->assertHasNoErrors()
            ->assertSee('Which social night should we run?')
            ->assertSee('Friday bowls')
            ->assertSee('Saturday quiz');

        $question = MemberQuestion::query()
            ->where('title', 'Which social night should we run?')
            ->firstOrFail();

        $this->assertDatabaseHas(MemberQuestionPollOption::class, [
            'member_question_id' => $question->id,
            'label' => 'Friday bowls',
            'sort_order' => 0,
        ]);
        $this->assertDatabaseHas(MemberQuestionPollOption::class, [
            'member_question_id' => $question->id,
            'label' => 'Saturday quiz',
            'sort_order' => 1,
        ]);
        $this->assertSame(2, $question->pollOptions()->count());
    }

    public function test_member_can_vote_on_question_poll(): void
    {
        $member = User::factory()->create();
        $question = MemberQuestion::factory()->create([
            'title' => 'Preferred green speed',
        ]);
        $slow = MemberQuestionPollOption::factory()->create([
            'member_question_id' => $question->id,
            'label' => 'Slower',
            'sort_order' => 0,
        ]);
        $fast = MemberQuestionPollOption::factory()->create([
            'member_question_id' => $question->id,
            'label' => 'Faster',
            'sort_order' => 1,
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('Preferred green speed')
            ->assertSee('Slower')
            ->call('votePollOption', $slow->id)
            ->assertHasNoErrors()
            ->call('votePollOption', $fast->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas(MemberQuestionPollVote::class, [
            'member_question_id' => $question->id,
            'member_question_poll_option_id' => $fast->id,
            'user_id' => $member->id,
        ]);
        $this->assertDatabaseMissing(MemberQuestionPollVote::class, [
            'member_question_id' => $question->id,
            'member_question_poll_option_id' => $slow->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_member_can_comment_on_an_answer(): void
    {
        $member = User::factory()->create([
            'name' => 'Commenting Member',
        ]);
        $answer = MemberAnswer::factory()->create([
            'body' => 'This is the answer.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set("commentBodies.{$answer->id}", 'Thanks, that helps.')
            ->call('addComment', $answer->id)
            ->assertHasNoErrors()
            ->assertSee('Thanks, that helps.')
            ->assertSee('Commenting Member');

        $this->assertDatabaseHas(MemberQuestionComment::class, [
            'member_answer_id' => $answer->id,
            'user_id' => $member->id,
            'body' => 'Thanks, that helps.',
        ]);
    }

    public function test_member_can_delete_their_own_comment(): void
    {
        $member = User::factory()->create();
        $comment = MemberQuestionComment::factory()->create([
            'user_id' => $member->id,
            'body' => 'This comment should be deleted.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('This comment should be deleted.')
            ->call('deleteComment', $comment->id)
            ->assertHasNoErrors()
            ->assertDontSee('This comment should be deleted.');

        $this->assertDatabaseMissing(MemberQuestionComment::class, [
            'id' => $comment->id,
        ]);
    }

    public function test_member_cannot_delete_another_members_comment(): void
    {
        $member = User::factory()->create();
        $commentOwner = User::factory()->create();
        $comment = MemberQuestionComment::factory()->create([
            'user_id' => $commentOwner->id,
            'body' => 'This comment should remain.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->call('deleteComment', $comment->id)
            ->assertForbidden();

        $this->assertDatabaseHas(MemberQuestionComment::class, [
            'id' => $comment->id,
            'body' => 'This comment should remain.',
        ]);
    }

    public function test_member_can_vote_thumbs_up_or_thumbs_down_on_question(): void
    {
        $member = User::factory()->create();
        $question = MemberQuestion::factory()->create();

        Livewire::actingAs($member)
            ->test('member-questions')
            ->call('voteQuestion', $question->id, 1);

        $this->assertDatabaseHas(MemberQuestionVote::class, [
            'member_question_id' => $question->id,
            'user_id' => $member->id,
            'value' => 1,
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->call('voteQuestion', $question->id, -1);

        $this->assertDatabaseHas(MemberQuestionVote::class, [
            'member_question_id' => $question->id,
            'user_id' => $member->id,
            'value' => -1,
        ]);

        $this->assertDatabaseMissing(MemberQuestionVote::class, [
            'member_question_id' => $question->id,
            'user_id' => $member->id,
            'value' => 1,
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->call('voteQuestion', $question->id, -1);

        $this->assertDatabaseMissing(MemberQuestionVote::class, [
            'member_question_id' => $question->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_questions_are_searchable_across_answers_and_comments(): void
    {
        $member = User::factory()->create();
        $visibleQuestion = MemberQuestion::factory()->create([
            'title' => 'Green opening',
        ]);
        $hiddenQuestion = MemberQuestion::factory()->create([
            'title' => 'Bar rota',
        ]);
        $answer = MemberAnswer::factory()->create([
            'member_question_id' => $visibleQuestion->id,
            'body' => 'The keyword is rink fees.',
        ]);
        MemberQuestionComment::factory()->create([
            'member_answer_id' => $answer->id,
            'body' => 'This comment mentions summer mats.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set('search', 'summer mats')
            ->assertSee('Green opening')
            ->assertDontSee('Bar rota')
            ->set('search', 'rink fees')
            ->assertSee('Green opening')
            ->assertDontSee('Bar rota');

        $this->assertDatabaseHas(MemberQuestion::class, [
            'id' => $hiddenQuestion->id,
        ]);
    }

    public function test_questions_can_be_sorted_by_date_and_reverse_order(): void
    {
        $member = User::factory()->create();
        $olderQuestion = MemberQuestion::factory()->create([
            'title' => 'Older question',
            'created_at' => now()->subDays(2),
        ]);
        $newerQuestion = MemberQuestion::factory()->create([
            'title' => 'Newer question',
            'created_at' => now(),
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSeeInOrder(['Newer question', 'Older question'])
            ->call('toggleSortDirection')
            ->assertSeeInOrder(['Older question', 'Newer question']);

        $this->assertDatabaseHas(MemberQuestion::class, [
            'id' => $olderQuestion->id,
        ]);
        $this->assertDatabaseHas(MemberQuestion::class, [
            'id' => $newerQuestion->id,
        ]);
    }

    public function test_questions_can_be_sorted_by_votes(): void
    {
        $member = User::factory()->create();
        $popularQuestion = MemberQuestion::factory()->create([
            'title' => 'Popular question',
        ]);
        $unpopularQuestion = MemberQuestion::factory()->create([
            'title' => 'Unpopular question',
        ]);
        MemberQuestion::factory()->create([
            'title' => 'Quiet question',
        ]);

        MemberQuestionVote::factory()->count(2)->create([
            'member_question_id' => $popularQuestion->id,
        ]);
        MemberQuestionVote::factory()->count(3)->down()->create([
            'member_question_id' => $unpopularQuestion->id,
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('👍')
            ->assertSee('👎')
            ->assertSee('Score')
            ->set('sortBy', 'votes')
            ->assertSeeInOrder(['Popular question', 'Unpopular question']);
    }

    public function test_question_can_be_minimised_with_answer_and_comment_summary(): void
    {
        $member = User::factory()->create();
        $question = MemberQuestion::factory()->create([
            'title' => 'Collapsed question',
            'body' => 'Expanded details are visible only when open.',
        ]);
        $answer = MemberAnswer::factory()->create([
            'member_question_id' => $question->id,
            'body' => 'Expanded answer is visible only when open.',
        ]);
        MemberQuestionComment::factory()->create([
            'member_answer_id' => $answer->id,
            'body' => 'A comment for the summary count.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('Expanded details are visible only when open.')
            ->assertSee('Expanded answer is visible only when open.')
            ->call('toggleCollapsed', $question->id)
            ->assertSee('This question has been answered.')
            ->assertSee('It has 1 comment.')
            ->assertDontSee('Expanded details are visible only when open.')
            ->assertDontSee('Expanded answer is visible only when open.');
    }

    public function test_questions_are_paginated_by_selected_page_size(): void
    {
        $member = User::factory()->create();

        foreach (range(1, 6) as $number) {
            MemberQuestion::factory()->create([
                'title' => "Pagination question {$number}",
                'created_at' => now()->addMinutes($number),
            ]);
        }

        Livewire::actingAs($member)
            ->test('member-questions')
            ->assertSee('Pagination question 6')
            ->assertDontSee('Pagination question 1')
            ->set('perPage', 10)
            ->assertSee('Pagination question 6')
            ->assertSee('Pagination question 1');
    }

    public function test_designated_member_can_lock_question_to_stop_answers_and_comments(): void
    {
        $answerer = User::factory()->create([
            'roles' => [UserRole::QuestionAnswerer->value],
        ]);
        $member = User::factory()->create();
        $question = MemberQuestion::factory()->create();
        $answer = MemberAnswer::factory()->create([
            'member_question_id' => $question->id,
        ]);

        Livewire::actingAs($answerer)
            ->test('member-questions')
            ->call('toggleLocked', $question->id)
            ->assertSee('Locked')
            ->set("answerBodies.{$question->id}", 'This answer should be blocked.')
            ->call('answerQuestion', $question->id)
            ->assertHasErrors(["answerBodies.{$question->id}"]);

        $this->assertDatabaseHas(MemberQuestion::class, [
            'id' => $question->id,
            'is_locked' => true,
        ]);
        $this->assertDatabaseMissing(MemberAnswer::class, [
            'member_question_id' => $question->id,
            'body' => 'This answer should be blocked.',
        ]);

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set("commentBodies.{$answer->id}", 'This comment should be blocked.')
            ->call('addComment', $answer->id)
            ->assertHasErrors(["commentBodies.{$answer->id}"]);

        $this->assertDatabaseMissing(MemberQuestionComment::class, [
            'member_answer_id' => $answer->id,
            'body' => 'This comment should be blocked.',
        ]);
    }

    public function test_profane_questions_are_blocked(): void
    {
        $member = User::factory()->create();

        Livewire::actingAs($member)
            ->test('member-questions')
            ->set('title', 'A normal title')
            ->set('body', 'This question contains shit language.')
            ->call('askQuestion')
            ->assertHasErrors(['body']);

        $this->assertDatabaseMissing(MemberQuestion::class, [
            'title' => 'A normal title',
        ]);
    }
}
