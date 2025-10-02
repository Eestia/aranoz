import React from "react";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import "../../css/app.css";
/**
 * CarouselProduits
 * Props:
 *   - produits: array de produits (tu envoies tous les produits depuis ton controller Laravel / Inertia)
 *
 * Affiche 8 produits par "slide". Chaque carte reprend la structure exacte
 * que tu as demandé : image + titre + prix (barré si réduction + prix réduit en rouge).
 */
export default function CarouselProduits({ produits = [] }) {
  // Si Inertia retourne un objet (par ex pagination), on essaie de convertir en array
  const items = Array.isArray(produits) ? produits : Object.values(produits);

  // découpe en groupes de 8
  const chunk = (arr, size) => {
    const out = [];
    for (let i = 0; i < arr.length; i += size) out.push(arr.slice(i, i + size));
    return out;
  };
  const groups = chunk(items, 8);

  const settings = {
    dots: true,
    arrows: true,
    infinite: false,
    speed: 450,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: true,
  };

  const formatPrice = (n) => {
    if (n == null) return "";
    // Affiche sans décimales si entier, sinon 2 décimales
    return Number(n).toLocaleString(undefined, {
      minimumFractionDigits: Number.isInteger(Number(n)) ? 0 : 2,
      maximumFractionDigits: 2,
    });
  };

  return (
    <div className="container my-5">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2 className="fw-bold">Awesome</h2>
        <a href="#" className="text-muted fw-bold">Shop</a>
      </div>

      <Slider {...settings}>
        {groups.map((group, idx) => (
          <div key={idx}>
            <div className="row g-4">
              {group.map((produit) => {
                const prixReduit =
                  produit.en_reduction && produit.reduction_pct
                    ? produit.prix - (produit.prix * produit.reduction_pct) / 100
                    : null;

                return (
                  <div key={produit.id} className="col-md-3 col-sm-6">
                    <div className="card h-100 border-0 text-center">
                      {/* Image */}
                      <img
                        src={`/storage/${produit.image_path}`}
                        alt={produit.titre}
                        className="card-img-top img-fluid"
                        style={{ objectFit: "contain", maxHeight: 200 }}
                      />

                      {/* Contenu (structure demandée) */}
                      <div className="card-body">
                        <h6 className="fw-bold text-capitalize">
                          {produit.titre}
                        </h6>

                        {prixReduit ? (
                          <p className="mb-0">
                            <span className="text-decoration-line-through text-muted">
                              {formatPrice(produit.prix)}€
                            </span>
                            <span className="text-danger fw-bold ms-1">
                              (-{produit.reduction_pct}%) {formatPrice(prixReduit)}€
                            </span>
                          </p>
                        ) : (
                          <p className="fw-bold mb-0">
                            {formatPrice(produit.prix)}€
                          </p>
                        )}
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        ))}
      </Slider>
    </div>
  );
}
