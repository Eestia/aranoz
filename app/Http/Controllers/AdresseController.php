<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdresseController extends Controller

{
    public function store(Request $request)
    {
        $request->validate([
            'rue'         => 'required|string',
            'numero'      => 'required|string',
            'ville'       => 'required|string',
            'code_postal' => 'required|string',
            'pays'        => 'required|string',
            'code_pays'   => 'required|string',
            'tel'         => 'nullable|string',
            'email'       => 'nullable|email',
        ]);

        // ( ˶°ㅁ°) !! L'utilisateur connecté crée son adresse
        $request->user()->adresses()->create($request->all());

        return back()->with('success', 'Adresse ajoutée avec succès.');
    }
}
