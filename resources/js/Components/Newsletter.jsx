export default function NewsletterSection() {
  return (
    <section
      className="py-5"
      style={{ backgroundColor: "#f7fbff" }} // couleur claire comme sur ton screen
    >
      <div className="container text-center">
        {/* Petit texte au-dessus */}
        <p className="text-uppercase text-danger fw-bold mb-2" style={{ fontSize: "0.9rem" }}>
          Join our newsletter
        </p>

        {/* Titre principal */}
        <h2 className="fw-bold mb-4" style={{ fontSize: "2rem" }}>
          Subscribe to get Updated <br /> with new offers
        </h2>

        {/* Formulaire */}
        <div className="d-flex justify-content-center">
          <input
            type="email"
            placeholder="Enter Email Address"
            className="form-control"
            style={{
              maxWidth: "400px",
              borderTopRightRadius: "0",
              borderBottomRightRadius: "0",
            }}
          />
          <button
            className="btn fw-bold text-white"
            style={{
              background: "linear-gradient(90deg, #ff416c, #ff4b2b)", // gradient rouge/rose
              borderTopLeftRadius: "0",
              borderBottomLeftRadius: "0",
            }}
          >
            SUBSCRIBE NOW
          </button>
        </div>
      </div>
    </section>
  );
}
