<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use App\Models\User;

class AdresseController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(\App\Models\Adresse::class, 'adresse');
    }

    //---------Afficher la page contact avec l’adresse de l’admin
    public function contact()
    {
        $admin = User::with('adresse')->where('role_id', 1)->first();

        return Inertia::render('Contact/Index', [
            'admin' => $admin
        ]);
    }

    // ✅ Créer ou mettre à jour l’adresse de l’utilisateur connecté
    public function store(Request $request)
    {
        $request->validate([
            'rue'         => 'required|string',
            'numero'      => 'required|string',
            'ville'       => 'required|string',
            'code_postal' => 'required|string',
            'pays'        => 'required|string',
            'code_pays'   => 'required|string',
        ]);

        $user = $request->user();

        if ($user->adresse) {
            // si l'utilisateur a déjà une adresse → update
            $user->adresse->update($request->all());
        } else {
            // sinon → création
            $user->adresse()->create($request->all());
        }

        return back()->with('success', 'Adresse enregistrée avec succès.');
    }
}
