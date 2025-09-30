<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\CommandeEnvoyee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

class CommandeController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth'); // tout le monde doit être connecté
        $this->middleware('role:admin,agent')->only(['index', 'updateStatus', 'contactClient']);
    }

    //---------- Liste des commandes (admin ou agent via policy)
    public function index()
    {
        $this->authorize('viewAny', Commande::class);

        $commandes = Commande::with('user','commandeItems.produit')->get();

        return Inertia::render('Commandes/Index', [
            'commandes' => $commandes
        ]);
    }

    //--------- Valider une commande (utilisateur)
    public function store(Request $request)
    {
        $user = $request->user();
        $panierItems = $user->panierItems()->with('produit')->get();

        $total = $panierItems->sum(function($item) {
            return $item->produit->prix * $item->quantite;
        });

        $commande = $user->commandes()->create([
            'total' => $total,
            'mode_paiement' => $request->mode_paiement,
            'status' => 'en_attente'
        ]);

        foreach($panierItems as $item) {
            $commande->commandeItems()->create([
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'prix' => $item->produit->prix
            ]);
        }

        // Vider le panier
        $user->panierItems()->delete();

        return redirect()->route('panier.index')->with('success', 'Commande validée !');
    }

    //----------- Changer le statut d'une commande (agent/admin via policy)
    public function updateStatus(Request $request, Commande $commande)
    {
        $this->authorize('updateStatus', $commande); // vérifie rôle via policy

        $commande->update(['status' => 'livre']); // ou "envoyé"

        // Envoi mail à l’utilisateur
        Mail::to($commande->user->email)->send(new CommandeEnvoyee($commande));

        return redirect()->back()->with('success', 'Statut mis à jour et mail envoyé.');
    }

    //----------- Optionnel : contacter le client par mail
    public function contactClient(Request $request, Commande $commande)
    {
        $this->authorize('contact', $commande);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Mail::to($commande->user->email)->send(new \App\Mail\ContactClient($request->message, $commande));

        return redirect()->back()->with('success', 'Mail envoyé au client.');
    }
}
