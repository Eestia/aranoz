import React, { useState } from "react";
import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
import "../../css/app.css";
import { Link } from "@inertiajs/react";

export default function CarouselProduits({ produits = [], categories = [], couleurs = [] }) {
  const items = Array.isArray(produits) ? produits : Object.values(produits);

  const [selectedCategorie, setSelectedCategorie] = useState(null);
  const [selectedCouleur, setSelectedCouleur] = useState(null);
  const [search, setSearch] = useState("");

  const filteredProduits = items.filter((p) => {
    const matchCategorie = selectedCategorie ? p.categorie?.nom === selectedCategorie : true;
    const matchCouleur = selectedCouleur ? p.couleur?.nom === selectedCouleur : true;
    const matchSearch = search
      ? p.titre.toLowerCase().includes(search.toLowerCase())
      : true;
    return matchCategorie && matchCouleur && matchSearch;
  });

  const chunk = (arr, size) => {
    const out = [];
    for (let i = 0; i < arr.length; i += size) out.push(arr.slice(i, i + size));
    return out;
  };
  const groups = chunk(filteredProduits, 12);

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
    return Number(n).toLocaleString(undefined, {
      minimumFractionDigits: Number.isInteger(Number(n)) ? 0 : 2,
      maximumFractionDigits: 2,
    });
  };

  // ✅ Extraction du contenu filtres pour réutiliser (desktop + offcanvas)
  const Filtres = () => (
    <>
      <input
        type="text"
        placeholder="Recherche..."
        className="form-control mb-3"
        value={search}
        onChange={(e) => setSearch(e.target.value)}
      />

      <h6 className="fw-bold">Catégories</h6>
      <ul className="list-unstyled">
        {categories.map((c) => (
          <li key={c}>
            <button
              className={`btn btn-sm w-100 text-start mb-1 ${
                selectedCategorie === c ? "btn-dark text-white" : "btn-light"
              }`}
              onClick={() => setSelectedCategorie(selectedCategorie === c ? null : c)}
            >
              {c}
            </button>
          </li>
        ))}
      </ul>

      <h6 className="fw-bold mt-4">Couleurs</h6>
      <ul className="list-unstyled">
        {couleurs.map((clr) => (
          <li key={clr}>
            <button
              className={`btn btn-sm w-100 text-start mb-1 ${
                selectedCouleur === clr ? "btn-dark text-white" : "btn-light"
              }`}
              onClick={() => setSelectedCouleur(selectedCouleur === clr ? null : clr)}
            >
              {clr}
            </button>
          </li>
        ))}
      </ul>
    </>
  );

  return (
    <div className="container my-5">
      <div className="row">
        {/* Sidebar desktop */}
        <div className="col-md-3 d-none d-md-block">
          <Filtres />
        </div>

        {/* Contenu produits */}
        <div className="col-md-9">
          <div className="d-flex justify-content-between align-items-center mb-4">
            <h2 className="fw-bold">Produits</h2>

            {/* Bouton menu burger visible uniquement sur mobile */}
            <button
              className="btn btn-outline-dark d-md-none"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasFiltres"
            >
              <i className="bi bi-funnel"></i> Filtres
            </button>
          </div>

          {/* Offcanvas Bootstrap pour filtres mobile */}
          <div
            className="offcanvas offcanvas-start"
            tabIndex="-1"
            id="offcanvasFiltres"
          >
            <div className="offcanvas-header">
              <h5 className="offcanvas-title">Filtres</h5>
              <button
                type="button"
                className="btn-close"
                data-bs-dismiss="offcanvas"
              ></button>
            </div>
            <div className="offcanvas-body">
              <Filtres />
            </div>
          </div>

          {/* Carousel */}
          {groups.length > 0 ? (
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
                                  href={route("produits.show", produit.id)}
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
          ) : (
            <p>Aucun produit trouvé...</p>
          )}
        </div>
      </div>
    </div>
  );
}
