import { Link, router, usePage } from "@inertiajs/react";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";
import { useState } from "react";

export default function PanierIndex() {
  const { panier = {}, total = 0 } = usePage().props;
  const [localPanier, setLocalPanier] = useState(panier);

  const handleRemove = (id) => {
    router.delete(route("panier.remove", id));
  };

  const handleClear = () => {
    if (confirm("Vider tout le panier ?")) {
      router.post(route("panier.clear"));
    }
  };

  const handleQuantityChange = (id, newQty) => {
    if (newQty < 1) return;
    const updated = { ...localPanier };
    updated[id].quantite = newQty;
    setLocalPanier(updated);
    router.post(route("panier.add", id), { quantite: newQty }, { preserveScroll: true });
  };

  return (
    <Front>
      <Breadcrumb title="Votre panier" subtitle="Accueil - Panier" />

      <div className="container py-5">

        {Object.keys(localPanier).length === 0 ? (
          <p className="text-center fs-5">Votre panier est vide.</p>
        ) : (
          <div className="table-responsive">
            <table className="table align-middle text-center">
              <thead className="bg-light">
                <tr>
                  <th>Produit</th>
                  <th>Prix</th>
                  <th>Quantité</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {Object.values(localPanier).map((item) => (
                  <tr key={item.id} className="align-middle">
                    <td className="d-flex align-items-center gap-3 text-start">
                      <img
                        src={`/storage/${item.image}`}
                        alt={item.nom}
                        width="70"
                        height="70"
                        className="rounded"
                        style={{ objectFit: "cover" }}
                      />
                      <span className="fw-semibold">{item.nom}</span>
                    </td>
                    <td className="fs-6">{item.prix.toFixed(2)} €</td>
                    <td>
                      <div className="d-flex justify-content-center align-items-center gap-2">
                        <button
                          className="btn btn-sm btn-outline-secondary"
                          onClick={() =>
                            handleQuantityChange(item.id, item.quantite - 1)
                          }
                        >
                          −
                        </button>
                        <input
                          type="number"
                          value={item.quantite}
                          min="1"
                          readOnly
                          className="form-control text-center"
                          style={{ width: "60px" }}
                        />
                        <button
                          className="btn btn-sm btn-outline-secondary"
                          onClick={() =>
                            handleQuantityChange(item.id, item.quantite + 1)
                          }
                        >
                          +
                        </button>
                      </div>
                    </td>
                    <td className="fw-semibold">
                      {(item.prix * item.quantite).toFixed(2)} €
                    </td>
                    <td>
                      <button
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => handleRemove(item.id)}
                      >
                        ✕
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>

            <div className="d-flex justify-content-end mt-4">
              <div className="text-end">
                <h5 className="mb-3 fw-semibold">
                  Sous-total : <span className="text-primary">{total.toFixed(2)} €</span>
                </h5>
                <div className="d-flex gap-3 justify-content-end">
                  <button
                    className="btn btn-outline-secondary rounded-pill px-4"
                    onClick={handleClear}
                  >
                    Vider le panier
                  </button>
                  <Link
                    href={route("shop")}
                    className="btn btn-light border rounded-pill px-4"
                  >
                    Continuer mes achats
                  </Link>
                  <Link
                    href={route("checkout.index")}
                    className="btn btn-primary rounded-pill px-4"
                  >
                    🧾 Passer à la caisse
                  </Link>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    </Front>
  );
}
