import { usePage } from "@inertiajs/react";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";
import axios from "axios";

export default function Show() {
  // ✅ Récupération des props envoyées par Laravel
  const { produit, auth } = usePage().props;

  // 👀 Vérification côté console
  console.log("Utilisateur connecté :", auth);
  console.log("Produit affiché :", produit);

  // ✅ Fonction d'ajout au panier
  const handleAddToCart = async () => {
    console.log("🛒 Tentative d’ajout au panier pour :", produit.id);

    try {
      await axios.post(route("panier.add", produit.slug));
      alert("✅ Produit ajouté au panier !");
    } catch (error) {
      console.error("❌ Erreur lors de l’ajout au panier :", error);
      alert("Une erreur est survenue.");
    }
  };

  return (
    <Front>
      <Breadcrumb title="Shop" subtitle="Home - Produit" />

      <div className="container py-5">
        <div className="row">
          {/* 🖼️ Image du produit */}
          <div className="col-md-6">
            <img
              src={`/storage/${produit.image_path}`}
              alt={produit.titre}
              className="img-fluid rounded shadow-sm"
            />
          </div>

          {/* 📄 Détails du produit */}
          <div className="col-md-6 d-flex flex-column justify-content-center">
            <h2>{produit.titre}</h2>
            <p className="text-muted">{produit.description}</p>
            <h4>{produit.prix} €</h4>

            {/* 🛒 Bouton d’ajout au panier */}
            <button
              onClick={handleAddToCart}
              className="btn btn-primary mt-3"
            >
              Ajouter au panier
            </button>
          </div>
        </div>
      </div>
    </Front>
  );
}
