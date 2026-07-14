<?php

namespace App\Policies;

use App\Models\KnownMemberEmail;
use App\Models\User;

class KnownMemberEmailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KnownMemberEmail $knownMemberEmail): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KnownMemberEmail $knownMemberEmail): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KnownMemberEmail $knownMemberEmail): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KnownMemberEmail $knownMemberEmail): bool
    {
        return $user->isSuperUser();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KnownMemberEmail $knownMemberEmail): bool
    {
        return $user->isSuperUser();
    }
}
