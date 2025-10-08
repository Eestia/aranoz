import { useForm, Link, usePage } from "@inertiajs/react";
import axios from "axios";
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";
import Back from "../../../Layouts/Back";

export default function Edit() {
  const { produit, categories, couleurs } = usePage().props;

  const { data, setData, post, put, progress, errors, processing } = useForm({
    titre: produit.titre || "",
    description: produit.description || "",
    prix: produit.prix || 0,
    stock: produit.stock || 0,
    couleur_id: produit.couleur_id || "",
    categorie_id: produit.categorie_id || "",
    en_reduction: produit.en_reduction || false,
    reduction_pct: produit.reduction_pct || 0,
    is_pinned: produit.is_pinned || false,
  });

  // ✅ Fonction séparée pour gérer l'upload d'image
  const handleImageChange = async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append("image", file);

    try {
      const response = await axios.post(
        route("admin.products.upload-image", { produit: produit.slug }),
        formData,
        {
            headers: { "Content-Type": "multipart/form-data" },
        }
        );
      console.log(" Image uploadée :", response.data);
    } catch (error) {
      console.error(" Erreur upload image :", error);
    }
  };

  // ✅ Fonction de soumission du formulaire (texte)
  const handleSubmit = (e) => {
    e.preventDefault();

    put(route("admin.products.update", produit.slug), {
      data,
      onSuccess: () => console.log("✅ Produit mis à jour avec succès"),
      onError: (errors) => console.error(errors),
    });
  };

  return (
    <Back>
      <BreadcrumbAdmin title="Modifier un produit" subtitle="Aranoz - Produits" />

      <div className="container py-5">
        <div className="card shadow-sm border-0">
          <div className="card-body">
            <h4 className="mb-4 fw-bold">Modifier le produit</h4>

            <form onSubmit={handleSubmit} encType="multipart/form-data">
              {/* --- Titre --- */}
              <div className="mb-3">
                <label className="form-label">Titre</label>
                <input
                  type="text"
                  value={data.titre}
                  onChange={(e) => setData("titre", e.target.value)}
                  className="form-control"
                />
                {errors.titre && <div className="text-danger">{errors.titre}</div>}
              </div>

              {/* --- Description --- */}
              <div className="mb-3">
                <label className="form-label">Description</label>
                <textarea
                  rows="3"
                  value={data.description}
                  onChange={(e) => setData("description", e.target.value)}
                  className="form-control"
                />
                {errors.description && (
                  <div className="text-danger">{errors.description}</div>
                )}
              </div>

              {/* --- Prix et Stock --- */}
              <div className="row">
                <div className="col-md-6 mb-3">
                  <label className="form-label">Prix (€)</label>
                  <input
                    type="number"
                    value={data.prix}
                    onChange={(e) => setData("prix", e.target.value)}
                    className="form-control"
                  />
                  {errors.prix && <div className="text-danger">{errors.prix}</div>}
                </div>

                <div className="col-md-6 mb-3">
                  <label className="form-label">Stock</label>
                  <input
                    type="number"
                    value={data.stock}
                    onChange={(e) => setData("stock", e.target.value)}
                    className="form-control"
                  />
                  {errors.stock && <div className="text-danger">{errors.stock}</div>}
                </div>
              </div>

              {/* --- Catégorie et Couleur --- */}
              <div className="row">
                <div className="col-md-6 mb-3">
                  <label className="form-label">Catégorie</label>
                  <select
                    value={data.categorie_id}
                    onChange={(e) => setData("categorie_id", e.target.value)}
                    className="form-select"
                  >
                    <option value="">-- Sélectionner --</option>
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>
                        {cat.nom}
                      </option>
                    ))}
                  </select>
                  {errors.categorie_id && (
                    <div className="text-danger">{errors.categorie_id}</div>
                  )}
                </div>

                <div className="col-md-6 mb-3">
                  <label className="form-label">Couleur</label>
                  <select
                    value={data.couleur_id}
                    onChange={(e) => setData("couleur_id", e.target.value)}
                    className="form-select"
                  >
                    <option value="">-- Sélectionner --</option>
                    {couleurs.map((clr) => (
                      <option key={clr.id} value={clr.id}>
                        {clr.nom}
                      </option>
                    ))}
                  </select>
                  {errors.couleur_id && (
                    <div className="text-danger">{errors.couleur_id}</div>
                  )}
                </div>
              </div>

              {/* --- Images --- */}
              <div className="row mb-3">
                {["image", "image2", "image3"].map((img, idx) => (
                  <div key={idx} className="col-md-4 mb-3">
                    <label className="form-label">Image {idx + 1}</label>
                    <input type="file" onChange={handleImageChange} />
                    {produit[`${img}_path`] && (
                      <img
                        src={`/storage/${produit[`${img}_path`]}`}
                        alt={`Image ${idx + 1}`}
                        className="rounded mt-2"
                        width="100"
                        height="100"
                      />
                    )}
                  </div>
                ))}
              </div>

              {/* --- Boutons --- */}
              <div className="d-flex justify-content-between mt-4">
                <Link
                  href={route("admin.products.index")}
                  className="btn btn-secondary"
                >
                  Annuler
                </Link>
                <button
                  type="submit"
                  className="btn btn-success"
                  disabled={processing}
                >
                  Enregistrer les modifications
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Back>
  );
}
