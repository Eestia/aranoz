import React from "react";
import Back from "@/Layouts/Back";
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";

export default function Show({ blog }) {
  return (
    <Back>
      <BreadcrumbAdmin title="Dashboard" subtitle={`Blog - ${blog.titre}`} />

      <div className="container my-5" style={{ maxWidth: "900px" }}>
        <div className="card shadow border-0">
          {/* Image principale */}
          {blog.image_path && (
            <img
              src={`/storage/${blog.image_path}`}
              className="card-img-top rounded-top"
              alt={blog.titre}
              style={{ objectFit: "cover", maxHeight: "400px" }}
            />
          )}

          <div className="card-body">
            {/* Titre et métadonnées */}
            <h2 className="fw-bold mb-3">{blog.titre}</h2>
            <p className="text-muted mb-3">
              {blog.categorie?.nom ? (
                <span className="badge bg-info text-dark me-2">
                  {blog.categorie.nom}
                </span>
              ) : (
                <span className="badge bg-secondary me-2">Sans catégorie</span>
              )}
              <span>
                Publié le{" "}
                {new Date(blog.created_at).toLocaleDateString("fr-FR", {
                  day: "numeric",
                  month: "long",
                  year: "numeric",
                })}
              </span>
            </p>

            {/* Description */}
            <p className="fs-5 text-secondary">{blog.description}</p>

            {/* Tags */}
            {blog.tags && blog.tags.length > 0 && (
              <div className="mt-4">
                <strong>Tags :</strong>{" "}
                {blog.tags.map((tag) => (
                  <span
                    key={tag.id}
                    className="badge bg-secondary me-2"
                    style={{ fontSize: "0.9rem" }}
                  >
                    {tag.nom}
                  </span>
                ))}
              </div>
            )}
          </div>
        </div>

        <div className="text-center mt-4">
          <a
            href={route("admin.blogs.index")}
            className="btn btn-outline-primary px-4"
          >
            ← Retour à la liste
          </a>
        </div>
      </div>
    </Back>
  );
}
