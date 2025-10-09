import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";
import { useForm, usePage } from "@inertiajs/react";
import { router } from "@inertiajs/react";

export default function Checkout() {
  const { panier = {}, total = 0 } = usePage().props;

  // 🧾 useForm gère les données du formulaire
  const { data, setData, post, processing, errors } = useForm({
    billing: {
      firstname: "",
      lastname: "",
      email: "",
      address: "",
    },
    mode_paiement: "check",
  });

  // ✅ Envoi du formulaire
  const handleSubmit = (e) => {
    e.preventDefault();

    post(route("commandes.store"), {
    onSuccess: (response) => {
    const commandeId = response.props?.flash?.commande_id || response?.props?.commande?.id;
    if (commandeId) {
        router.get(route("commandes.track", commandeId)); // ✅ redirection Inertia, côté Laravel
    } else {
        alert("Commande enregistrée avec succès !");
    }
},
});
  };

  return (
    <Front>
      <Breadcrumb title="Paiement" subtitle="Accueil - Paiement" />

      <div className="container py-5">
        <div className="row g-5">
          {/* FORMULAIRE DE FACTURATION */}
          <div className="col-lg-7">
            <h4 className="fw-bold mb-4">Billing Details</h4>

            <form className="row g-3" onSubmit={handleSubmit}>
              <div className="col-md-6">
                <input
                  type="text"
                  className="form-control"
                  placeholder="Firstname"
                  value={data.billing.firstname}
                  onChange={(e) =>
                    setData("billing", {
                      ...data.billing,
                      firstname: e.target.value,
                    })
                  }
                  required
                />
                {errors["billing.firstname"] && (
                  <div className="text-danger small">
                    {errors["billing.firstname"]}
                  </div>
                )}
              </div>

              <div className="col-md-6">
                <input
                  type="text"
                  className="form-control"
                  placeholder="Lastname"
                  value={data.billing.lastname}
                  onChange={(e) =>
                    setData("billing", {
                      ...data.billing,
                      lastname: e.target.value,
                    })
                  }
                  required
                />
                {errors["billing.lastname"] && (
                  <div className="text-danger small">
                    {errors["billing.lastname"]}
                  </div>
                )}
              </div>

              <div className="col-md-6">
                <input
                  type="email"
                  className="form-control"
                  placeholder="Email"
                  value={data.billing.email}
                  onChange={(e) =>
                    setData("billing", {
                      ...data.billing,
                      email: e.target.value,
                    })
                  }
                  required
                />
                {errors["billing.email"] && (
                  <div className="text-danger small">
                    {errors["billing.email"]}
                  </div>
                )}
              </div>

              <div className="col-md-6">
                <input
                  type="text"
                  className="form-control"
                  placeholder="Address"
                  value={data.billing.address}
                  onChange={(e) =>
                    setData("billing", {
                      ...data.billing,
                      address: e.target.value,
                    })
                  }
                  required
                />
                {errors["billing.address"] && (
                  <div className="text-danger small">
                    {errors["billing.address"]}
                  </div>
                )}
              </div>

              {/* MÉTHODES DE PAIEMENT */}
              <div className="col-12 mt-4">
                <div className="form-check mb-3">
                  <input
                    className="form-check-input"
                    type="radio"
                    name="payment"
                    id="check"
                    checked={data.mode_paiement === "check"}
                    onChange={() => setData("mode_paiement", "check")}
                  />
                  <label className="form-check-label" htmlFor="check">
                    Check payments
                  </label>
                </div>

                <div className="form-check mb-3">
                  <input
                    className="form-check-input"
                    type="radio"
                    name="payment"
                    id="paypal"
                    checked={data.mode_paiement === "paypal"}
                    onChange={() => setData("mode_paiement", "paypal")}
                  />
                  <label className="form-check-label" htmlFor="paypal">
                    PayPal
                  </label>
                </div>
              </div>

              <div className="col-12">
                <button
                  type="submit"
                  className="btn btn-danger w-100 py-3 rounded-pill fw-bold"
                  disabled={processing}
                >
                  {processing ? "Processing..." : "CHECK AND PAY"}
                </button>
              </div>
            </form>
          </div>

          {/* PANIER RÉCAPITULATIF */}
          <div className="col-lg-5">
            <div className="p-4 rounded-4" style={{ backgroundColor: "#e8f8f8" }}>
              <h5 className="fw-bold mb-4">Your Order</h5>

              <table className="table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  {Object.values(panier).map((item) => (
                    <tr key={item.id}>
                      <td>
                        {item.nom} × {item.quantite}
                      </td>
                      <td>{(item.prix * item.quantite).toFixed(2)} €</td>
                    </tr>
                  ))}
                </tbody>
              </table>

              <div className="border-top pt-3 mt-3">
                <p className="d-flex justify-content-between mb-2">
                  <span>Subtotal</span> <span>{total.toFixed(2)} €</span>
                </p>
                <p className="d-flex justify-content-between mb-2">
                  <span>Shipping</span>{" "}
                  <span className="text-success fw-semibold">
                    Free shipping worldwide!
                  </span>
                </p>
                <p className="d-flex justify-content-between fw-bold fs-5">
                  <span>Total</span> <span>{total.toFixed(2)} €</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Front>
  );
}
