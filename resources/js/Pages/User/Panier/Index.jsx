import { Link, usePage } from "@inertiajs/react";
import Front from "@/Layouts/Front";

export default function Panier() {
  const { panier } = usePage().props;

  const total = Object.values(panier).reduce(
    (sum, item) => sum + item.prix * item.quantite,
    0
  );

  return (
    <Front>
      <div className="container py-5">
        <h2>🛒 Mon Panier</h2>
        {Object.keys(panier).length === 0 ? (
          <p>Votre panier est vide.</p>
        ) : (
          <>
            <table className="table">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th>Quantité</th>
                  <th>Prix</th>
                </tr>
              </thead>
              <tbody>
                {Object.values(panier).map((item, index) => (
                  <tr key={index}>
                    <td>{item.titre}</td>
                    <td>{item.quantite}</td>
                    <td>{item.prix * item.quantite} €</td>
                  </tr>
                ))}
              </tbody>
            </table>

            <h4 className="mt-3">Total : {total} €</h4>

            <Link href={route("commande.store")} method="post" className="btn btn-success mt-3">
              Passer la commande
            </Link>
          </>
        )}
      </div>
    </Front>
  );
}
