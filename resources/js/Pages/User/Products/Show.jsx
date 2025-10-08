import { useForm, usePage , Link } from "@inertiajs/react";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";

export default function Show() {
  const { produit } = usePage().props;
  const { post, processing } = useForm();

  const handleAddToCart = () => {
    post(route("panier.add", produit.id), {
      onSuccess: () => alert("✅ Produit ajouté au panier !"),
      onError: () => alert("❌ Erreur lors de l’ajout au panier."),
    });
  };

  return (
    <Front>
      <Breadcrumb title="Shop" subtitle="Home - Produit" />
      <div className="container py-5">
        <div className="row">
          {/* Image */}
          <div className="col-md-6">
            <img
              src={`/storage/${produit.image_path}`}
              alt={produit.titre}
              className="img-fluid rounded shadow-sm"
            />
          </div>

          {/* Infos */}
          <div className="col-md-6 d-flex flex-column justify-content-center">
            <h2>{produit.titre}</h2>
            <p className="text-muted">{produit.description}</p>
            <h4>{produit.prix} €</h4>

            <Link
                href={route('panier.add', produit.id)}
                method="post"
                as="button"
                className="btn btn-primary"
                >
                Ajouter au panier
            </Link>
          </div>
        </div>
      </div>
    </Front>
  );
}
