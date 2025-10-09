<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier_item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Mail\CommandeEnvoyee;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    // ---------- 🧾 Liste des commandes (admin / agent ou utilisateur)
    public function index()
    {
        if (auth()->user()->hasRole(['admin', 'agent'])) {
            $commandes = Commande::with('user', 'commandeItems.produit')->latest()->get();
        } else {
            $commandes = auth()->user()->commandes()->with('commandeItems.produit')->latest()->get();
        }

        return Inertia::render('Commandes/Index', [
            'commandes' => $commandes
        ]);
    }

    // ---------- 💳 Création d’une commande (depuis Checkout)
   public function store(Request $request)
{
    $total = 0;
    $panier = session()->get('panier', []);
    foreach ($panier as $item) {
        $total += $item['prix'] * $item['quantite'];
    }

    $commande = Commande::create([
        'user_id' => auth()->id(),
        'status' => 'en_attente',
        'total' => $total,
        'mode_paiement' => $request->mode_paiement ?? 'Check Payments',
        'billing' => json_encode($request->billing),
        'shipping' => json_encode($request->shipping ?? []),
    ]);

    // Optionnel : sauvegarde des produits liés
    foreach ($panier as $item) {
        $commande->items()->create([
            'produit_id' => $item['id'],
            'quantite' => $item['quantite'],
            'prix' => $item['prix'],
        ]);
    }

    // Vide le panier
    session()->forget('panier');

    // ✅ Redirection Inertia vers la page de suivi
    return redirect()->route('commandes.track', $commande->id)
        ->with('success', 'Commande enregistrée avec succès !')
        ->with('commande_id', $commande->id);
}






    // ---------- 🚚 Détails d’une commande (Track your order)
    public function show(Commande $commande)
    {
        $this->authorize('view', $commande);

        $commande->load('commandeItems.produit', 'user');

        return Inertia::render('Commandes/Show', [
            'commande' => $commande,
        ]);
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
    public function track($id)
    {
        $commande = Commande::with('items.produit')->findOrFail($id);

        return inertia('Commandes/Track', [
            'commande' => $commande,
        ]);
    }

}
