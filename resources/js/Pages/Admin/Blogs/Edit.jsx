import { Link, router } from "@inertiajs/react";
import AdminLayout from "@/Layouts/AdminLayout";
import Back from "../../../Layouts/Back";
import React, { useState } from "react";
import BreadcrumbAdmin from '../../../Components/BreadcrumbAdmin';
import { useForm } from "@inertiajs/react";

export default function Edit({ blog, categories, tags }) {
  const { data, setData, processing, errors } = useForm({
    titre: blog.titre || "",
    description: blog.description || "",
    categorie_id: blog.categorie_id || "",
    image: null,
    tag_ids: blog.tags?.map(tag => tag.id) || [],
  });

  function handleFile(e) {
    setData("image", e.target.files[0]);
  }

  function submit(e) {
    e.preventDefault();

    router.post(route("admin.blogs.update", blog.id), {
      _method: "put",
      ...data,
    }, {
      forceFormData: true,
    });
  }

  return (
    <Back>
      <BreadcrumbAdmin title="Dashboard" subtitle="Aranoz - Blog Edit" />
      <div className="container py-5">
        <div className="card shadow-lg border-0 rounded-4">
          <div className="card-header bg-white text-black d-flex justify-content-between align-items-center rounded-top-4">
            <h4 className="mb-0">
              <i className="bi bi-pencil-square me-2"></i> Modifier un blog
            </h4>
            <Link href={route("admin.blogs.index")} className="btn btn-light btn-sm">
              <i className="bi bi-arrow-left"></i> Retour
            </Link>
          </div>

          <div className="card-body p-4">
            <form onSubmit={submit} className="row g-4">

              {/* Titre */}
              <div className="col-md-12">
                <div className="form-floating">
                  <input
                    type="text"
                    className={`form-control ${errors.titre ? "is-invalid" : ""}`}
                    id="titre"
                    placeholder="Titre du blog"
                    value={data.titre}
                    onChange={e => setData("titre", e.target.value)}
                  />
                  <label htmlFor="titre">Titre du blog</label>
                  {errors.titre && <div className="invalid-feedback">{errors.titre}</div>}
                </div>
              </div>

              {/* Catégorie */}
              <div className="col-md-6">
                <div className="form-floating">
                  <select
                    className={`form-select ${errors.categorie_id ? "is-invalid" : ""}`}
                    id="categorie"
                    value={data.categorie_id}
                    onChange={e => setData("categorie_id", e.target.value)}
                  >
                    <option value="">-- Sélectionner une catégorie --</option>
                    {categories.map(categorie => (
                      <option key={categorie.id} value={categorie.id}>
                        {categorie.nom}
                      </option>
                    ))}
                  </select>
                  <label htmlFor="categorie">Catégorie</label>
                  {errors.categorie_id && <div className="invalid-feedback">{errors.categorie_id}</div>}
                </div>
              </div>

              {/* Image */}
              <div className="col-md-6">
                <label className="form-label fw-semibold">Image du blog</label>
                <div className="input-group">
                  <input
                    type="file"
                    className={`form-control ${errors.image ? "is-invalid" : ""}`}
                    onChange={handleFile}
                  />
                  <label className="input-group-text">
                    <i className="bi bi-upload"></i>
                  </label>
                  {errors.image && <div className="invalid-feedback d-block">{errors.image}</div>}
                </div>

                {blog.image_path && (
                  <div className="mt-3 text-center">
                    <img
                      src={`/storage/${blog.image_path}`}
                      alt="Preview"
                      className="img-fluid rounded shadow-sm"
                      style={{ maxHeight: "200px" }}
                    />
                  </div>
                )}
              </div>

              {/* Tags */}
              <div className="col-md-12">
                <label className="form-label fw-semibold mb-2">Tags associés</label>
                <div className="d-flex flex-wrap gap-3">
                  {tags.map(tag => (
                    <div key={tag.id} className="form-check form-check-inline">
                      <input
                        type="checkbox"
                        className="form-check-input"
                        id={`tag-${tag.id}`}
                        checked={data.tag_ids.includes(tag.id)}
                        onChange={e => {
                          if (e.target.checked) {
                            setData("tag_ids", [...data.tag_ids, tag.id]);
                          } else {
                            setData("tag_ids", data.tag_ids.filter(id => id !== tag.id));
                          }
                        }}
                      />
                      <label className="form-check-label" htmlFor={`tag-${tag.id}`}>
                        {tag.nom}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              {/* Description */}
              <div className="col-md-12">
                <div className="form-floating">
                  <textarea
                    className={`form-control ${errors.description ? "is-invalid" : ""}`}
                    id="description"
                    style={{ height: "150px" }}
                    value={data.description}
                    onChange={e => setData("description", e.target.value)}
                    placeholder="Description"
                  />
                  <label htmlFor="description">Description</label>
                  {errors.description && <div className="invalid-feedback">{errors.description}</div>}
                </div>
              </div>

              {/* Submit */}
              <div className="col-12 text-end">
                <button
                  type="submit"
                  className="btn btn-success px-4 py-2"
                  disabled={processing}
                >
                  <i className="bi bi-check-circle me-2"></i>
                  {processing ? "Mise à jour..." : "Mettre à jour le blog"}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Back>
  );
}
