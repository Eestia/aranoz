<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    public function viewAny(User $user)
    {
        //-------------tout utilisateur connecté peut voir la liste
        return true;
    }

    public function view(User $user, Blog $blog): bool
    {
        return false;
    }

    public function create(User $user)
    {
        //-------------admin OU redacteur peuvent créer
        return $user->role === 'admin' || $user->role === 'redacteur';
    }

    public function update(User $user, Blog $blog)
    {
        //-------------l'admin et redacteur peut modifier
        return $user->role === 'admin' || $user->role === 'redacteur';
    }

    public function delete(User $user, Blog $blog)
    {
        //-------------l'admin et redacteur peut supprimer
        return $user->role === 'admin' || $user->role === 'redacteur';
    }

    public function restore(User $user, Blog $blog): bool
    {
        return false;
    }

    public function forceDelete(User $user, Blog $blog): bool
    {
        return false;
    }
}
