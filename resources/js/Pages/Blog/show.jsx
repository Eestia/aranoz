import React from "react";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";

export default function Show({ blog }) {
  return (
    <Front>
      <Breadcrumb title={blog.titre} subtitle={blog.categorie?.nom || "Blog"} />

      <div className="container my-5" style={{ maxWidth: "900px" }}>
        <div className="card shadow-sm">
          <img
            src={`/storage/${blog.image_path}`}
            className="card-img-top"
            alt={blog.titre}
          />
          <div className="card-body">
            <h1 className="fw-bold">{blog.titre}</h1>
            <p className="text-muted">
              {blog.categorie?.nom} • {new Date(blog.created_at).toLocaleDateString()}
            </p>
            <p>{blog.description}</p>

            {blog.tags && blog.tags.length > 0 && (
              <div className="mt-3">
                <strong>Tags : </strong>
                {blog.tags.map((tag) => (
                  <span key={tag.id} className="badge bg-secondary me-1">
                    {tag.nom}
                  </span>
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </Front>
  );
}
