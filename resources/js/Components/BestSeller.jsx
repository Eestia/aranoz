import React from "react";
import Slider from "react-slick";
import { Link } from "@inertiajs/react";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import "../../css/app.css";

export default function BestSellersCarousel({ produits = [] }) {
  const items = Array.isArray(produits) ? produits : Object.values(produits);

  // garde seulement 8 produits et découpe en 2 slides de 4
  const topProduits = items.slice(0, 8);

  const chunk = (arr, size) => {
    const out = [];
    for (let i = 0; i < arr.length; i += size) out.push(arr.slice(i, i + size));
    return out;
  };
  const groups = chunk(topProduits, 4);

  const settings = {
    dots: true,
    arrows: true,
    infinite: false,
    speed: 450,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: true,
  };

  const formatPrice = (n) =>
    Number(n).toLocaleString(undefined, {
      minimumFractionDigits: Number.isInteger(Number(n)) ? 0 : 2,
      maximumFractionDigits: 2,
    });

  return (
    <div className="container my-5">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2 className="fw-bold">Best Sellers</h2>
        <Link href={route("produits.index")} className="text-muted fw-bold">
          Shop
        </Link>
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
                      {/* Image cliquable */}
                      <Link href={route("produits.show", produit.slug)}>
                        <img
                          src={`/storage/${produit.image_path}`}
                          alt={produit.titre}
                          className="card-img-top img-fluid"
                          style={{ objectFit: "contain", maxHeight: 200 }}
                        />
                      </Link>

                      <div className="card-body">
                        <h6 className="fw-bold text-capitalize">
                          <Link
                            href={route("produits.show", produit.slug)}
                            className="text-decoration-none text-dark"
                          >
                            {produit.titre}
                          </Link>
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
                          <p className="fw-bold mb-0">{formatPrice(produit.prix)}€</p>
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
