import React from 'react';
import { Head, usePage } from '@inertiajs/react';

export default function Track() {
    const { commande } = usePage().props;

    return (
        <div className="max-w-4xl mx-auto py-12">
            <Head title="Track Your Order" />
            <h1 className="text-2xl font-bold mb-6 text-center">Track Your Order</h1>

            <div className="bg-blue-50 p-6 rounded-lg shadow">
                <h2 className="font-semibold text-lg mb-4">Order #{commande.id}</h2>

                <p><strong>Date:</strong> {commande.created_at}</p>
                <p><strong>Total:</strong> ${commande.total}</p>
                <p><strong>Status:</strong> {commande.status}</p>

                <h3 className="mt-6 font-semibold text-lg">Items</h3>
                <ul className="list-disc list-inside">
                    {commande.details.map((item) => (
                        <li key={item.id}>
                            {item.produit.nom} × {item.quantite} — ${item.total}
                        </li>
                    ))}
                </ul>
            </div>

            <div className="text-center mt-8">
                <a href="/" className="text-blue-600 hover:underline">
                    Retour à l’accueil
                </a>
            </div>
        </div>
    );
}
