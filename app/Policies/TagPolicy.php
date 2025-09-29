<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
{

    public function viewAny(User $user): bool
    {
        // ----------Tout utilisateur connecté peut voir la liste
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // ----------Admin ou Rédacteur peuvent créer
        return in_array($user->role, ['admin', 'redacteur']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag): bool
    {
        // ----------Admin ou Rédacteur peuvent modifier
        return in_array($user->role, ['admin', 'redacteur']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag): bool
    {
        // ----------Admin ou Rédacteur peuvent supprimer
        return in_array($user->role, ['admin', 'redacteur']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return false;
    }
}
