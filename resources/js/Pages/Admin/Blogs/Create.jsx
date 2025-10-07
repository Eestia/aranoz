import React from "react";
import { useForm } from "@inertiajs/react";
import Back from "../../../Layouts/Back"
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";

export default function Create({ categories, tags }) {
  const { data, setData, post, processing, errors } = useForm({
    titre: "",
    description: "",
    categorie_id: "",
    image: null,
    tags: [],
  });

  function handleSubmit(e) {
    e.preventDefault();

    post(route("admin.blogs.store"), {
      forceFormData: true,
      onSuccess: () => {
        console.log("✅ Blog created successfully!");
      },
      onError: (err) => {
        console.error("❌ Error:", err);
      },
    });
  }

  return (
    <Back>
      <BreadcrumbAdmin title="Add a New Blog" subtitle="Blog Management" />

      <div className="container my-5" style={{ maxWidth: "800px" }}>
        <div className="card shadow-sm p-4">
          <h3 className="fw-bold mb-3">Create a New Blog</h3>

          <form onSubmit={handleSubmit} encType="multipart/form-data">
            {/* Titre */}
            <div className="mb-3">
              <label className="form-label">Title</label>
              <input
                type="text"
                className="form-control"
                value={data.titre}
                onChange={(e) => setData("titre", e.target.value)}
              />
              {errors.titre && <div className="text-danger">{errors.titre}</div>}
            </div>

            {/* Description */}
            <div className="mb-3">
              <label className="form-label">Description</label>
              <textarea
                className="form-control"
                rows="4"
                value={data.description}
                onChange={(e) => setData("description", e.target.value)}
              />
              {errors.description && (
                <div className="text-danger">{errors.description}</div>
              )}
            </div>

            {/* Catégorie */}
            <div className="mb-3">
              <label className="form-label">Category</label>
              <select
                className="form-select"
                value={data.categorie_id}
                onChange={(e) => setData("categorie_id", e.target.value)}
              >
                <option value="">-- Select a category --</option>
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

            {/* Tags */}
            <div className="mb-3">
              <label className="form-label">Tags</label>
              <div className="d-flex flex-wrap">
                {tags.map((tag) => (
                  <div key={tag.id} className="form-check me-3">
                    <input
                      type="checkbox"
                      id={`tag-${tag.id}`}
                      className="form-check-input"
                      value={tag.id}
                      checked={data.tags.includes(tag.id)}
                      onChange={(e) => {
                        const newTags = e.target.checked
                          ? [...data.tags, tag.id]
                          : data.tags.filter((t) => t !== tag.id);
                        setData("tags", newTags);
                      }}
                    />
                    <label htmlFor={`tag-${tag.id}`} className="form-check-label">
                      {tag.nom}
                    </label>
                  </div>
                ))}
              </div>
            </div>

            {/* Image */}
            <div className="mb-3">
              <label className="form-label">Image</label>
              <input
                type="file"
                className="form-control"
                onChange={(e) => setData("image", e.target.files[0])}
              />
              {errors.image && <div className="text-danger">{errors.image}</div>}
            </div>

            {/* Bouton */}
            <button
              type="submit"
              className="btn btn-primary"
              disabled={processing}
            >
              {processing ? "Saving..." : "Save Blog"}
            </button>
          </form>
        </div>
      </div>
    </Back>
  );
}
