import { User, MessageCircle } from "lucide-react";
import { Link } from "@inertiajs/react";

export default function BlogCard({ blog }) {
  return (
    <div className="card shadow-sm border-0 h-100">
      {/* Image cliquable */}
      <Link href={`/blogs/${blog.id}`}>
        <img
          src={`/storage/${blog.image_path}`}
          className="card-img-top"
          alt={blog.titre}
          style={{ height: "200px", objectFit: "cover" }}
        />
      </Link>

      {/* Body */}
      <div className="card-body d-flex flex-column">
        <h5 className="card-title fw-bold">
          <Link
            href={`/blogs/${blog.id}`}
            className="text-decoration-none text-dark"
          >
            {blog.titre}
          </Link>
        </h5>

        <p className="card-text text-muted">
          {blog.description.length > 120
            ? blog.description.substring(0, 120) + "..."
            : blog.description}
        </p>

        {/* Footer infos */}
        <div className="d-flex justify-content-between text-muted small mt-auto">
          <span className="d-flex align-items-center">
            <User size={16} className="me-1" />
            {blog.categorie?.nom || "Categorie"}
          </span>
          <span className="d-flex align-items-center">
            <MessageCircle size={16} className="me-1" />
            5 Comments
          </span>
        </div>

        {/* Bouton "Lire plus" */}
        <div className="mt-3">
          <Link href={`/blogs/${blog.id}`} className="btn btn-outline-dark btn-sm">
            Lire plus →
          </Link>
        </div>
      </div>
    </div>
  );
}
