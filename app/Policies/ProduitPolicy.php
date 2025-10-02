<?php

namespace App\Policies;

use App\Models\Produit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProduitPolicy
{
    //------- Voir la liste ou un produit

    public function viewAny(?User $user): bool
    {
        // tout le monde, connecté ou non
        return true;
    }

    public function view(?User $user, Produit $produit): bool
    {
        // tout le monde, connecté ou non
        return true;
    }

    //------- Créer un produit : Admin + Webmaster
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin','webmaster']);
    }

    //------- Mettre à jour un produit : Admin + Webmaster
    public function update(User $user, Produit $produit): bool
    {
        return in_array($user->role, ['admin','webmaster']);
    }

    //------- Supprimer un produit : Admin uniquement
    public function delete(User $user, Produit $produit): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Produit $produit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Produit $produit): bool
    {
        return false;
    }

}
