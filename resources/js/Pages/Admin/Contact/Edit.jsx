import { useForm } from "@inertiajs/react";
import BreadcrumbAdmin from '@/Components/BreadcrumbAdmin';
import Back from "../../../Layouts/Back";

export default function EditContact({ admin }) {
  const { data, setData, put, processing, errors } = useForm({
    rue: admin?.adresse?.rue || "",
    numero: admin?.adresse?.numero || "",
    ville: admin?.adresse?.ville || "",
    code_postal: admin?.adresse?.code_postal || "",
    pays: admin?.adresse?.pays || "",
    phone: admin?.phone || "",
    email: admin?.email || "",
  });

  const submit = (e) => {
    e.preventDefault();
    put(route("admin.contact.update", admin.id));
  };

  const adresse = admin?.adresse;

  return (
    <Back>
      <BreadcrumbAdmin title="Contact" subtitle="Aranoz - Contact" />
      <div className="container py-5">
        <h2 className="fw-bold mb-4">Update your contact datas</h2>

        {/* Google Map au-dessus */}
        {adresse && (
          <div className="mb-5">
            <div className="w-100" style={{ height: "400px" }}>
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
            </div>
          </div>
        )}

        {/* Formulaire */}
        <form onSubmit={submit} className="card p-4 shadow-sm">
          <div className="row g-3">
            <div className="col-md-6">
              <label className="form-label">Rue</label>
              <input
                type="text"
                className="form-control"
                value={data.rue}
                onChange={(e) => setData("rue", e.target.value)}
              />
              {errors.rue && <div className="text-danger small">{errors.rue}</div>}
            </div>

            <div className="col-md-6">
              <label className="form-label">Numéro</label>
              <input
                type="text"
                className="form-control"
                value={data.numero}
                onChange={(e) => setData("numero", e.target.value)}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Ville</label>
              <input
                type="text"
                className="form-control"
                value={data.ville}
                onChange={(e) => setData("ville", e.target.value)}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Code postal</label>
              <input
                type="text"
                className="form-control"
                value={data.code_postal}
                onChange={(e) => setData("code_postal", e.target.value)}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Pays</label>
              <input
                type="text"
                className="form-control"
                value={data.pays}
                onChange={(e) => setData("pays", e.target.value)}
              />
            </div>

            <div className="col-md-6">
              <label className="form-label">Téléphone</label>
              <input
                type="text"
                className="form-control"
                value={data.phone}
                onChange={(e) => setData("phone", e.target.value)}
              />
            </div>

            <div className="col-md-12">
              <label className="form-label">Email</label>
              <input
                type="email"
                className="form-control"
                value={data.email}
                onChange={(e) => setData("email", e.target.value)}
              />
            </div>
          </div>

          <div className="mt-4 text-end">
            <button type="submit" className="btn btn-primary" disabled={processing}>
              Sauvegarder
            </button>
          </div>
        </form>
      </div>
    </Back>
  );
}
