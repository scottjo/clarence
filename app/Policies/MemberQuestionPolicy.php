<?php

namespace App\Policies;

use App\Models\MemberQuestion;
use App\Models\User;

class MemberQuestionPolicy
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
    public function view(User $user, MemberQuestion $memberQuestion): bool
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
    public function update(User $user, MemberQuestion $memberQuestion): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MemberQuestion $memberQuestion): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MemberQuestion $memberQuestion): bool
    {
        return $user->canModerateMemberQuestions();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MemberQuestion $memberQuestion): bool
    {
        return $user->canModerateMemberQuestions();
    }
}
