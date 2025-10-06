<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// policies
use App\Models\Tag;
use App\Policies\TagPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    \App\Models\Blog::class => \App\Policies\BlogPolicy::class,
    Tag::class => TagPolicy::class,
    \App\Models\CategorieBlog::class => \App\Policies\CategorieBlogPolicy::class,
    \App\Models\Adresse::class => \App\Policies\AdressePolicy::class,
    \App\Models\Produit::class => \App\Policies\ProduitPolicy::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // (optionnel / conseillé) Gate::before global pour admin
        Gate::before(function ($user, $ability) {
            if ($user->role_id === 1) { // si admin
                return true;
            }
        });
    }
}
