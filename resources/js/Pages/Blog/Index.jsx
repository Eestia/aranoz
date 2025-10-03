import React from "react";
import BlogCard from "@/Components/BlogCard";
import BlogSidebar from "@/Components/BlogSidebar";
import Front from "@/Layouts/Front";
import Breadcrumb from "@/Components/Breadcrumb";
import { router } from "@inertiajs/react";

export default function BlogIndex({ blogs = [], categories = [], tags = [], recentBlogs = [], filters = {} }) {
  
  const applyFilter = (type, value) => {
    router.get("/blogs", {
      ...filters,
      [type]: value,
    }, { preserveScroll: true, preserveState: true });
  };

  return (
    <Front>
      <Breadcrumb title="Discover Our Blogs" subtitle="Blog - Blogs table" />

      <div className="container my-5" style={{ maxWidth: "1000px" }}>
        <div className="row g-3">
          {/* Colonne gauche = Blogs */}
          <div className="col-md-8">
            <div className="d-flex justify-content-between align-items-center mb-3">
              <h2 className="fw-bold">Nos Blogs</h2>
              {/* Bouton burger filtre en mobile */}
              <button
                className="btn btn-outline-dark d-md-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasFiltres"
              >
                <i className="bi bi-funnel"></i> Filtres
              </button>
            </div>

            <div className="row g-3">
              {blogs.length > 0 ? (
                blogs.map((blog) => (
                  <div key={blog.id} className="col-12">
                    <BlogCard blog={blog} />
                  </div>
                ))
              ) : (
                <p>Aucun blog trouvé...</p>
              )}
            </div>
          </div>

          {/* Colonne droite = Sidebar (desktop) */}
          <div className="col-md-4 d-none d-md-block">
            <BlogSidebar
              categories={categories}
              tags={tags}
              recentPosts={recentBlogs}
              filters={filters}
              onSearch={(q) => applyFilter("search", q)}
              onFilterCategory={(c) => applyFilter("category", c)}
              onFilterTag={(t) => applyFilter("tag", t)}
            />
          </div>
        </div>

        {/* Offcanvas (mobile) */}
        <div className="offcanvas offcanvas-end" tabIndex="-1" id="offcanvasFiltres">
          <div className="offcanvas-header">
            <h5 className="offcanvas-title">Filtres</h5>
            <button type="button" className="btn-close" data-bs-dismiss="offcanvas"></button>
          </div>
          <div className="offcanvas-body">
            <BlogSidebar
              categories={categories}
              tags={tags}
              recentPosts={recentBlogs}
              filters={filters}
              onSearch={(q) => applyFilter("search", q)}
              onFilterCategory={(c) => applyFilter("category", c)}
              onFilterTag={(t) => applyFilter("tag", t)}
            />
          </div>
        </div>
      </div>
    </Front>
  );
}
