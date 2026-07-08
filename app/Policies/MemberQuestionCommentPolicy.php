<?php

namespace App\Policies;

use App\Models\MemberQuestionComment;
use App\Models\User;

class MemberQuestionCommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MemberQuestionComment $memberQuestionComment): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MemberQuestionComment $memberQuestionComment): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MemberQuestionComment $memberQuestionComment): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MemberQuestionComment $memberQuestionComment): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MemberQuestionComment $memberQuestionComment): bool
    {
        return $user->canModerateMemberQuestions();
    }
}
