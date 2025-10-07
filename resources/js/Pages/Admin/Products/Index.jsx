import { usePage, Link } from "@inertiajs/react";
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";
import Back from "../../../Layouts/Back";

export default function Index() {
  const { produits = [] } = usePage().props;

  return (
    <Back>
      <BreadcrumbAdmin title="Produits" subtitle="Aranoz - Produits" />

      <div className="container py-5">
        <div className="d-flex justify-content-between align-items-center mb-4">
          <h2 className="fw-bold">Tous les produits</h2>
          <Link href={route("admin.products.create")} className="btn btn-primary">
            + Ajouter un produit
          </Link>
        </div>

        <div className="card shadow-sm border-0">
          <div className="card-body p-0">
            <table className="table table-hover align-middle mb-0 text-center">
              <thead className="table-dark">
                <tr>
                  <th>Image</th>
                  <th>Nom</th>
                  <th>Catégorie</th>
                  <th>Stock</th>
                  <th>Prix</th>
                  <th>Réduction</th>
                  <th>Détails</th>
                  <th>Modifier</th>
                  <th>Supprimer</th>
                </tr>
              </thead>
              <tbody>
                {produits.length > 0 ? (
                  produits.map((produit) => (
                    <tr key={produit.id}>
                      <td>
                        <img
                          src={`/storage/${produit.image_path}`}
                          alt={produit.titre}
                          className="rounded"
                          width="70"
                          height="70"
                        />
                      </td>
                      <td className="fw-semibold">{produit.titre}</td>
                      <td>{produit.categorie ? produit.categorie.nom : "—"}</td>
                      <td>
                        <span
                          className={`badge ${
                            produit.stock === 0
                              ? "bg-danger"
                              : produit.stock < 5
                              ? "bg-warning text-dark"
                              : "bg-success"
                          }`}
                        >
                          {produit.stock} en stock
                        </span>
                      </td>
                      <td>{produit.prix} €</td>
                      <td>
                        {produit.en_reduction
                          ? `-${produit.reduction_pct}%`
                          : "—"}
                      </td>
                      <td>
                        <Link
                          href={route("admin.products.show", produit.id)}
                          className="btn btn-outline-secondary btn-sm"
                        >
                          Voir
                        </Link>
                      </td>
                      <td>
                        <Link
                          href={route("admin.products.edit", produit.id)}
                          className="btn btn-info btn-sm text-white"
                        >
                          Modifier
                        </Link>
                      </td>
                      <td>
                        <Link
                          as="button"
                          method="delete"
                          href={route("admin.products.destroy", produit.id)}
                          className="btn btn-danger btn-sm"
                          onClick={(e) => {
                            if (
                              !confirm(
                                "Voulez-vous vraiment supprimer ce produit ?"
                              )
                            ) {
                              e.preventDefault();
                            }
                          }}
                        >
                          Supprimer
                        </Link>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="9" className="py-4">
                      Aucun produit trouvé.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </Back>
  );
}
