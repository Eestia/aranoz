<?php

namespace App\Policies;

use App\Models\Adresse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdressePolicy
{
    //----------------- Tout utilisateur connecté peut voir la liste
     
    public function viewAny(User $user): bool
    {
        return true;
    }
    //----------------- Voir une adresse précise
    public function view(User $user, Adresse $adresse): bool
    {
        // Un utilisateur peut voir sa propre adresse
        // Le webmaster peut voir toutes les adresses
        return $user->id === $adresse->user_id || $user->role === 'webmaster' || $user->role === 'admin';
    }

    //----------------- Créer une adresse
    public function create(User $user): bool
    {
        // Chaque user peut créer sa propre adresse
        // Webmaster et admin peuvent aussi créer
        return in_array($user->role, ['admin','webmaster','user']);
    }

    //----------------- Mettre à jour une adresse
    public function update(User $user, Adresse $adresse): bool
    {
        // Le propriétaire, l’admin ou le webmaster peuvent modifier
        return $user->id === $adresse->user_id || in_array($user->role, ['admin','webmaster']);
    }

    //----------------- Supprimer une adresse

     public function delete(User $user, Adresse $adresse): bool
    {
        // Le propriétaire, l’admin ou le webmaster peuvent supprimer
        return $user->id === $adresse->user_id || in_array($user->role, ['admin','webmaster']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Adresse $adresse): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Adresse $adresse): bool
    {
        return false;
    }
}
