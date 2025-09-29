<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    \App\Models\Blog::class => \App\Policies\BlogPolicy::class,
    \App\Models\Tag::class => \App\Policies\TagPolicy::class,
    \App\Models\Adresse::class => \App\Policies\AdressePolicy::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
