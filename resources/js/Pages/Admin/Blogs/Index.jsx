import { Link, router } from "@inertiajs/react";
import AdminLayout from "@/Layouts/AdminLayout";
import Back from "../../../Layouts/Back";
import Swal from "sweetalert2"; 
import BreadcrumbAdmin from '../../../Components/BreadcrumbAdmin';

function handleDelete(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "This blog will be permanently deleted!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route("admin.blogs.destroy", id), {
        onSuccess: () => {
          Swal.fire("Deleted!", "The blog has been removed.", "success");
        },
        onError: () => {
          Swal.fire("Error", "Something went wrong!", "error");
        },
      });
    }
  });
}

export default function BlogIndex({ blogs }) {
  const handleDelete = (id) => {
    if (confirm("Supprimer ce blog ?")) {
      router.delete(route("admin.blogs.destroy", id));
    }
  };

  return (
    <Back>
      <BreadcrumbAdmin title="Dashboard" subtitle="Aranoz - Blog section" />
      <div className="container py-5">
        <div className="d-flex justify-content-between align-items-center mb-4">
          <h2 className="fw-bold">All Blogs</h2>
          <Link href={route("admin.blogs.create")} className="btn btn-info text-white">
            + Add a New Blog
          </Link>
        </div>

        <table className="table table-striped align-middle">
          <thead>
            <tr>
              <th>Picture</th>
              <th>Blog</th>
              <th>Category</th>
              <th>Details</th>
              <th>Modification</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            {blogs.map((blog) => (
              <tr key={blog.id}>
                <td>
                  <img
                    src={`/storage/${blog.image_path}`}
                    alt={blog.titre}
                    width="60"
                    height="60"
                    className="rounded"
                  />
                </td>
                <td>{blog.titre}</td>
                <td>{blog.categorie ? blog.categorie.nom : "—"}</td>
                <td>
                  <Link
                    href={route("admin.blogs.show", blog.id)}
                    className="btn btn-light btn-sm"
                  >
                    Show
                  </Link>
                </td>
                <td>
                  <Link
                    href={route("admin.blogs.edit", blog.id)}
                    className="btn btn-primary btn-sm"
                  >
                    Edit
                  </Link>
                </td>
                <td>
                  <button
                  onClick={() => handleDelete(blog.id)}
                  className="btn btn-danger btn-sm"
                >
                  Delete
                </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </Back>
  );
}
