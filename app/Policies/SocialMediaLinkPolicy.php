<?php

namespace App\Policies;

use App\Models\SocialMediaLink;
use App\Models\User;

class SocialMediaLinkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SocialMediaLink $socialMediaLink): bool
    {
        return $user->isAdministrator();
    }
}
