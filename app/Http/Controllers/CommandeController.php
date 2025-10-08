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
        // Tout le monde doit être connecté
        $this->middleware('auth');

        // Seuls les admin / agents peuvent gérer et consulter les commandes globales
        $this->middleware('role:admin,agent')->only(['index', 'updateStatus', 'contactClient']);
    }

    // ---------- 🧾 Liste des commandes (admin / agent)
    public function index()
    {
        // Si admin ou agent -> voir toutes les commandes
        if (auth()->user()->hasRole(['admin', 'agent'])) {
            $commandes = Commande::with('user', 'commandeItems.produit')->latest()->get();
        } else {
            // Sinon, afficher uniquement les commandes du user connecté
            $commandes = auth()->user()->commandes()->with('commandeItems.produit')->latest()->get();
        }

        return Inertia::render('Commandes/Index', [
            'commandes' => $commandes
        ]);
    }

    // ---------- 💳 Création d’une commande (utilisateur)
    public function store(Request $request)
    {
        $user = $request->user();

        $panierItems = $user->panierItems()->with('produit')->get();

        if ($panierItems->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $total = $panierItems->sum(fn($item) => $item->produit->prix * $item->quantite);

        $commande = $user->commandes()->create([
            'total' => $total,
            'mode_paiement' => $request->input('mode_paiement', 'non_specifie'),
            'status' => 'en_attente',
        ]);

        foreach ($panierItems as $item) {
            $commande->commandeItems()->create([
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'prix' => $item->produit->prix,
            ]);
        }

        // 🔁 Vider le panier après validation
        $user->panierItems()->delete();

        return redirect()->route('commandes.index')->with('success', 'Commande validée avec succès !');
    }

    // ---------- 🚚 Mise à jour du statut (admin / agent)
    public function updateStatus(Request $request, Commande $commande)
    {
        $this->authorize('updateStatus', $commande);

        $commande->update(['status' => $request->input('status', 'livre')]);

        // Notification par mail
        Mail::to($commande->user->email)->send(new CommandeEnvoyee($commande));

        return redirect()->back()->with('success', 'Statut mis à jour et mail envoyé.');
    }

    // ---------- ✉️ Contacter le client (agent)
    public function contactClient(Request $request, Commande $commande)
    {
        $this->authorize('contact', $commande);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Mail::to($commande->user->email)
            ->send(new \App\Mail\ContactClient($request->message, $commande));

        return redirect()->back()->with('success', 'Mail envoyé au client.');
    }
}
