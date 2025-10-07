import React, { useState } from "react";
import { useForm, Link } from "@inertiajs/react";
import Back from "../../../Layouts/Back";
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";

export default function Create({ categories = [], couleurs = [] }) {
  const { data, setData, post, processing, errors } = useForm({
    titre: "",
    description: "",
    prix: "",
    stock: "",
    image: null,
    image2: null,
    image3: null,
    en_reduction: false,
    reduction_pct: "",
    is_pinned: false,
    categorie_id: "",
    couleur_id: "",
  });

  const [preview, setPreview] = useState({
    image: null,
    image2: null,
    image3: null,
  });

  const handleFileChange = (e, key) => {
    const file = e.target.files[0];
    setData(key, file);
    if (file) setPreview((prev) => ({ ...prev, [key]: URL.createObjectURL(file) }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route("admin.products.store"));
  };

  return (
    <Back>
      <BreadcrumbAdmin title="Add Product" subtitle="Aranoz - Products" />

      <div className="container my-5">
        <div className="card shadow-sm">
          <div className="card-header bg-white text-black">
            <h5 className="mb-0">Create a New Product</h5>
          </div>
          <div className="card-body">
            <form onSubmit={handleSubmit} encType="multipart/form-data">
              <div className="row g-3">
                <div className="col-md-6">
                  <label className="form-label fw-bold">Title</label>
                  <input
                    type="text"
                    className="form-control"
                    value={data.titre}
                    onChange={(e) => setData("titre", e.target.value)}
                    placeholder="Enter product title"
                  />
                  {errors.titre && <div className="text-danger">{errors.titre}</div>}
                </div>

                <div className="col-md-6">
                  <label className="form-label fw-bold">Price (€)</label>
                  <input
                    type="number"
                    className="form-control"
                    value={data.prix}
                    onChange={(e) => setData("prix", e.target.value)}
                    placeholder="Enter price"
                  />
                  {errors.prix && <div className="text-danger">{errors.prix}</div>}
                </div>

                <div className="col-md-12">
                  <label className="form-label fw-bold">Description</label>
                  <textarea
                    className="form-control"
                    rows="3"
                    value={data.description}
                    onChange={(e) => setData("description", e.target.value)}
                    placeholder="Enter description"
                  ></textarea>
                  {errors.description && (
                    <div className="text-danger">{errors.description}</div>
                  )}
                </div>

                <div className="col-md-6">
                  <label className="form-label fw-bold">Category</label>
                  <select
                    className="form-select"
                    value={data.categorie_id}
                    onChange={(e) => setData("categorie_id", e.target.value)}
                  >
                    <option value="">-- Choose a category --</option>
                    {categories.map((cat) => (
                      <option key={cat.id} value={cat.id}>
                        {cat.nom}
                      </option>
                    ))}
                  </select>
                  {errors.categorie_id && (
                    <div className="text-danger">{errors.categorie_id}</div>
                  )}
                </div>

                <div className="col-md-6">
                  <label className="form-label fw-bold">Color</label>
                  <select
                    className="form-select"
                    value={data.couleur_id}
                    onChange={(e) => setData("couleur_id", e.target.value)}
                  >
                    <option value="">-- Choose a color --</option>
                    {couleurs.map((clr) => (
                      <option key={clr.id} value={clr.id}>
                        {clr.nom}
                      </option>
                    ))}
                  </select>
                  {errors.couleur_id && (
                    <div className="text-danger">{errors.couleur_id}</div>
                  )}
                </div>

                <div className="col-md-4">
                  <label className="form-label fw-bold">Stock</label>
                  <input
                    type="number"
                    className="form-control"
                    value={data.stock}
                    onChange={(e) => setData("stock", e.target.value)}
                    placeholder="Enter stock quantity"
                  />
                  {errors.stock && <div className="text-danger">{errors.stock}</div>}
                </div>

                <div className="col-md-4">
                  <label className="form-label fw-bold">On Sale?</label>
                  <div className="form-check form-switch">
                    <input
                      className="form-check-input"
                      type="checkbox"
                      checked={data.en_reduction}
                      onChange={(e) => setData("en_reduction", e.target.checked)}
                    />
                  </div>
                </div>

                <div className="col-md-4">
                  <label className="form-label fw-bold">Reduction (%)</label>
                  <input
                    type="number"
                    className="form-control"
                    value={data.reduction_pct}
                    onChange={(e) => setData("reduction_pct", e.target.value)}
                    disabled={!data.en_reduction}
                  />
                  {errors.reduction_pct && (
                    <div className="text-danger">{errors.reduction_pct}</div>
                  )}
                </div>

                <div className="col-md-4">
                  <label className="form-label fw-bold">Pin this product?</label>
                  <div className="form-check form-switch">
                    <input
                      className="form-check-input"
                      type="checkbox"
                      checked={data.is_pinned}
                      onChange={(e) => setData("is_pinned", e.target.checked)}
                    />
                  </div>
                </div>

                {/* Images Upload */}
                {["image", "image2", "image3"].map((key, index) => (
                  <div className="col-md-4" key={key}>
                    <label className="form-label fw-bold">Image {index + 1}</label>
                    <input
                      type="file"
                      accept="image/*"
                      className="form-control"
                      onChange={(e) => handleFileChange(e, key)}
                    />
                    {preview[key] && (
                      <img
                        src={preview[key]}
                        alt={`preview-${key}`}
                        className="img-thumbnail mt-2"
                        width="150"
                      />
                    )}
                    {errors[key] && <div className="text-danger">{errors[key]}</div>}
                  </div>
                ))}
              </div>

              <div className="mt-4 d-flex justify-content-between">
                <Link href={route("admin.products.index")} className="btn btn-secondary">
                  Cancel
                </Link>
                <button
                  type="submit"
                  className="btn btn-success"
                  disabled={processing}
                >
                  {processing ? "Saving..." : "Save Product"}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Back>
  );
}
