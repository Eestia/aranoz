import Breadcrumb from "@/Components/Breadcrumb";
import Front from "@/Layouts/Front";
import { Home, Phone, Mail } from "lucide-react"; // 👈 icônes Lucide

export default function Contact({ admin }) {
  const adresse = admin?.adresse;

  return (
    <Front>
      <Breadcrumb title="Contact" subtitle="Nos informations de contact" />

      {/* Google Map */}
      <div className="w-100" style={{ height: "400px" }}>
        {adresse ? (
          <iframe
            src={`https://www.google.com/maps?q=${encodeURIComponent(
              `${adresse.rue} ${adresse.numero}, ${adresse.ville}, ${adresse.code_postal}, ${adresse.pays}`
            )}&output=embed`}
            width="100%"
            height="100%"
            style={{ border: 0 }}
            allowFullScreen=""
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
          ></iframe>
        ) : (
          <p className="text-center text-danger fw-bold">
            Adresse non disponible
          </p>
        )}
      </div>

      <div className="container py-5">
        <div className="row g-5">
          {/* Formulaire contact */}
          <div className="col-md-6">
            <div className="card shadow-sm border-0">
              <div className="card-body">
                <h2 className="card-title mb-4">Get in Touch</h2>
                <form>
                  <div className="mb-3">
                    <textarea
                      placeholder="Enter Message"
                      className="form-control"
                      rows="5"
                    ></textarea>
                  </div>
                  <div className="row">
                    <div className="col-md-6 mb-3">
                      <input
                        type="text"
                        placeholder="Enter your name"
                        className="form-control"
                      />
                    </div>
                    <div className="col-md-6 mb-3">
                      <input
                        type="email"
                        placeholder="Enter email address"
                        className="form-control"
                      />
                    </div>
                  </div>
                  <div className="mb-3">
                    <input
                      type="text"
                      placeholder="Enter Subject"
                      className="form-control"
                    />
                  </div>
                  <button type="submit" className="btn btn-primary w-100">
                    SEND MESSAGE
                  </button>
                </form>
              </div>
            </div>
          </div>

          {/* Infos admin */}
          <div className="col-md-6">
            <div className="card shadow-sm border-0">
              <div className="card-body">
                <h2 className="card-title mb-4">Nos informations</h2>

                <div className="d-flex align-items-start mb-4">
                  <Home className="me-3 text-primary" size={28} /> {/* Icône */}
                  <div>
                    <h5 className="fw-bold">Adresse</h5>
                    {adresse ? (
                      <p className="mb-0">
                        {adresse.rue} {adresse.numero}, {adresse.ville}
                        <br />
                        {adresse.pays} {adresse.code_postal}
                      </p>
                    ) : (
                      <p>Adresse non renseignée</p>
                    )}
                  </div>
                </div>

                <div className="d-flex align-items-start mb-4">
                  <Phone className="me-3 text-success" size={28} /> {/* Icône */}
                  <div>
                    <h5 className="fw-bold">Téléphone</h5>
                    <p className="mb-0">{admin?.phone || "Non renseigné"}</p>
                    <small className="text-muted">
                      Mon to Fri 9am to 6pm
                    </small>
                  </div>
                </div>

                <div className="d-flex align-items-start">
                  <Mail className="me-3 text-danger" size={28} /> {/* Icône */}
                  <div>
                    <h5 className="fw-bold">Email</h5>
                    <p className="mb-0">{admin?.email || "Non renseigné"}</p>
                    <small className="text-muted">
                      Send us your query anytime!
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Front>
  );
}
