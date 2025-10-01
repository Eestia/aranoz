import "../../css/app.css";

export default function FeaturedProducts() {
  return (
    <div className="container my-5">
      <h2 className="text-center fw-bold mb-4">Featured Category</h2>

      <div className="row g-4">
        {[
          { title: "Fauteuils", img: "/storage/produits/offer_img.png", alt: "Fauteuil rond bleu claire" },
          { title: "Canapés", img: "/storage/produits/feature_4.png", alt: "Produit spécial" },
          { title: "Fauteuils", img: "/storage/produits/feature_3.png", alt: "Fauteuil rond mignon" },
          { title: "Chaises", img: "/storage/produits/product_2.png", alt: "Chaise Orange Design" },
        ].map((item, idx) => (
          <div className="col-md-6" key={idx}>
            <div className="card-wrapper">
              <div
                className="d-flex justify-content-between align-items-center p-4"
                style={{
                  backgroundColor: "#f8fdff",
                  borderRadius: "10px",
                  minHeight: "200px",
                }}
              >
                <div>
                  <p className="text-muted mb-1">Premium Quality</p>
                  <h4 className="fw-bold">{item.title}</h4>
                </div>
                <img
                  src={item.img}
                  alt={item.alt}
                  style={{ maxHeight: "120px", objectFit: "contain" }}
                />
              </div>

              {/* Overlay Link */}
              <a href="/votre-page" className="explore-link">
                Explore Now!
              </a>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
