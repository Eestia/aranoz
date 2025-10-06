<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use App\Models\User;

class AdresseController extends Controller
{
    use AuthorizesRequests;

    // ---------------------------
    // PAGE PUBLIQUE CONTACT
    // ---------------------------
    public function contact()
    {
        $admin = User::with('adresse')->where('role_id', 1)->first();

        return Inertia::render('Contact/Index', [
            'admin' => $admin
        ]);
    }

    // ---------------------------
    // PAGE ADMIN : FORMULAIRE D'ÉDITION
    // ---------------------------
    public function edit()
    {
        $admin = User::with('adresse')->where('role_id', 1)->first();

        return Inertia::render('Admin/Contact/Edit', [
            'admin' => $admin
        ]);
    }

    // ---------------------------
    // UPDATE ADRESSE ADMIN
    // ---------------------------
    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'rue'         => 'required|string|max:255',
            'numero'      => 'required|string|max:50',
            'ville'       => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'pays'        => 'required|string|max:100',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:255',
        ]);

        // Données pour l’adresse uniquement
        $adresseData = collect($validated)->except(['email', 'phone'])->toArray();

        // Si l’admin a déjà une adresse → update, sinon → création
        if ($admin->adresse) {
            $admin->adresse->update($adresseData);
        } else {
            $admin->adresse()->create($adresseData);
        }

        // Met à jour les infos de contact de l'utilisateur
        $admin->update([
            'phone' => $validated['phone'] ?? $admin->phone,
            'email' => $validated['email'] ?? $admin->email,
        ]);

        return back()->with('success', 'Adresse mise à jour avec succès.');
    }

}
