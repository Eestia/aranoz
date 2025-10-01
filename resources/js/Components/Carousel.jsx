export default function Carousel({ produits }) {
  return (
    <div id="carouselExample" className="carousel slide" style={{ backgroundColor: 'rgb(236, 253, 255)'}}>
      <div className="carousel-inner">
        {produits.map((produit, index) => (
          <div
            key={produit.id}
            className={`carousel-item ${index === 0 ? 'active' : ''}`}
          >
            <div className="d-flex align-items-center container" style={{ minHeight: '300px' }}>
            {/* Texte à gauche */}
            <div className="me-5" style={{ flex: 1 }}>
                <h3>{produit.titre}</h3>
                <p>{produit.description}</p>
            </div>
            {/* Image à droite */}
            <div style={{ flex: 1 }}>
                <img
                src={`/storage/${produit.image_path}`}
                className="d-block w-100"
                alt={produit.titre}
                style={{ objectFit: 'contain', maxHeight: '300px' }}
                />
            </div>
            </div>
          </div>
        ))}
      </div>

      {/* Contrôles du carousel */}
      <button
        className="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExample"
        data-bs-slide="prev"
      >
        <span className="carousel-control-prev-icon" aria-hidden="true"></span>
        <span className="visually-hidden">Previous</span>
      </button>
      <button
        className="carousel-control-next"
        type="button"
        data-bs-target="#carouselExample"
        data-bs-slide="next"
      >
        <span className="carousel-control-next-icon" aria-hidden="true"></span>
        <span className="visually-hidden">Next</span>
      </button>
    </div>
  );
}
