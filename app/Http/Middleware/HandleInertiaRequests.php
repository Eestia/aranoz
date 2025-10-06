<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        // parent::share($request) contient déjà les props Inertia par défaut
        return array_merge(parent::share($request), [
            'auth' => [
                // si pas d'utilisateur connecté -> null
                'user' => $request->user()
                    ? [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                        'email' => $request->user()->email,
                        'role_id' => $request->user()->role_id,
                      ]
                    : null,
            ],
            // tu peux aussi partager d'autres choses utiles ici, par ex. flash messages :
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
