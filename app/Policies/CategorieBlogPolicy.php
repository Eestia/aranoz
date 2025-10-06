<?php

namespace App\Policies;

use App\Models\CategorieBlog;
use App\Models\User;

class CategorieBlogPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // tout utilisateur connecté peut voir
    }

    public function view(User $user, CategorieBlog $categorieBlog): bool
    {
        return true; // idem
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id, [1, 3]); // Admin ou Rédacteur
    }

    public function update(User $user, CategorieBlog $categorieBlog): bool
    {
        return in_array($user->role_id, [1, 3]);
    }

    public function delete(User $user, CategorieBlog $categorieBlog): bool
    {
        return in_array($user->role_id, [1, 3]);
    }

    public function restore(User $user, CategorieBlog $categorieBlog): bool
    {
        return false;
    }

    public function forceDelete(User $user, CategorieBlog $categorieBlog): bool
    {
        return false;
    }
}
