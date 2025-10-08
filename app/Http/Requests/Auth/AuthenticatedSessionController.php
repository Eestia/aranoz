<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends Controller
{
    /**
     * Gère la connexion de l'utilisateur.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Si admin → redirection admin.dashboard
        if ($user->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Sinon → page utilisateur
        return redirect()->intended(route('user.home'));
    }

    /**
     * Déconnecte l'utilisateur et détruit la session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Retour à la page d'accueil publique
        return redirect('/');
    }
}
