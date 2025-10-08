import { Link, router, usePage } from "@inertiajs/react";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";

export default function PanierIndex() {
  const { panier = {}, total = 0 } = usePage().props;

  const handleRemove = (id) => {
    router.delete(route("panier.remove", id));
  };

  const handleClear = () => {
    if (confirm("Vider tout le panier ?")) {
      router.post(route("panier.clear"));
    }
  };

  return (
    <Front>
      <Breadcrumb title="Panier" subtitle="Home - Panier" />

      <div className="container py-5">
        <h2 className="mb-4">🛒 Votre panier</h2>

        {Object.keys(panier).length === 0 ? (
          <p>Votre panier est vide </p>
        ) : (
          <>
            <table className="table align-middle">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Produit</th>
                  <th>Prix</th>
                  <th>Quantité</th>
                  <th>Sous-total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {Object.values(panier).map((item) => (
                  <tr key={item.id}>
                    <td>
                      {item.image ? (
                        <img
                          src={`/storage/${item.image}`}
                          alt={item.nom}
                          width="60"
                          className="rounded"
                        />
                      ) : (
                        <span>—</span>
                      )}
                    </td>
                    <td>{item.nom}</td>
                    <td>{item.prix} €</td>
                    <td>{item.quantite}</td>
                    <td>{(item.prix * item.quantite).toFixed(2)} €</td>
                    <td>
                      <button
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => handleRemove(item.id)}
                      >
                        Supprimer
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>

            <div className="d-flex justify-content-between align-items-center mt-4">
              <button
                className="btn btn-outline-secondary"
                onClick={handleClear}
              >
                🧹 Vider le panier
              </button>
              <h4>Total : {total.toFixed(2)} €</h4>
            </div>
          </>
        )}

        <div className="mt-4">
          <Link href={route("shop")} className="btn btn-primary">
            Continuer mes achats
          </Link>
        </div>
      </div>
    </Front>
  );
}
