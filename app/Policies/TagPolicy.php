<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // tout utilisateur connecté
    }

    public function view(User $user, Tag $tag): bool
    {
        return true; // tu peux même autoriser tout le monde si tu veux
    }

    public function create(User $user): bool
    {
        // Admin (1) ou Rédacteur (2)
        return in_array($user->role_id, [1, 3]);
    }

    public function update(User $user, Tag $tag): bool
    {
        return in_array($user->role_id, [1, 3]);
    }
    public function before(User $user, $ability)
    {
        if ($user->role_id === 1) { // admin
            return true;
        }
    }

    public function delete(User $user, Tag $tag): bool
    {
        dd($user->role_id); // ou $user->role selon ton modèle
        return $user->role_id === 1 || $user->role_id === 3;
    }

    public function restore(User $user, Tag $tag): bool
    {
        return false;
    }

    public function forceDelete(User $user, Tag $tag): bool
    {
        return false;
    }
}
