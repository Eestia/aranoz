import React from 'react';
import { usePage, Link } from '@inertiajs/react';
import Front from '@/Layouts/Front';

export default function Show() {
  const { commande } = usePage().props;

  if (!commande) return <Front><div>Commande introuvable</div></Front>;

  const items = commande.commandeItems || [];

  return (
    <Front>
      <div className="container py-5">
        <h2>Track your order — #{commande.id}</h2>

        <div className="row g-4">
          <div className="col-md-6">
            <h4>Billing</h4>
            <div><strong>Nom:</strong> {commande.billing?.firstname} {commande.billing?.lastname}</div>
            <div><strong>Email:</strong> {commande.billing?.email}</div>
            <div><strong>Address:</strong> {commande.billing?.address}</div>
            <div><strong>City:</strong> {commande.billing?.city}</div>
            <div><strong>Postcode:</strong> {commande.billing?.postcode}</div>
            <div><strong>Country:</strong> {commande.billing?.country}</div>
          </div>

          <div className="col-md-6">
            <h4>Order Info</h4>
            <div><strong>Total:</strong> {commande.total} €</div>
            <div><strong>Status:</strong> {commande.status}</div>
            <div><strong>Payment:</strong> {commande.mode_paiement}</div>
          </div>

          <div className="col-12">
            <h4>Order Details</h4>
            <table className="table">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Quantité</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                {items.map(it => (
                  <tr key={it.id}>
                    <td>{it.produit?.titre ?? it.produit_id}</td>
                    <td>{it.quantite}</td>
                    <td>{(it.prix * it.quantite).toFixed(2)} €</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </Front>
  );
}
