import React from "react";
import { Link, router } from "@inertiajs/react";
import BreadcrumbAdmin from "@/Components/BreadcrumbAdmin";
import Back from "../../../Layouts/Back";

export default function Index({ users }) {
  return (
    <Back>
      <BreadcrumbAdmin title="Users" subtitle="Aranoz - Users" />
      <div className="container py-5">
        <h2 className="fw-bold mb-4">Liste des utilisateurs</h2>

        <table className="table table-striped align-middle text-center shadow-sm rounded">
          <thead className="table-dark">
            <tr>
              <th>Avatar</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Rôle</th>
              <th>Adresse</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {users.map((user) => (
              <tr key={user.id}>
                <td>
                  <img
                    src={
                      user.photo
                        ? `/storage/${user.photo}`
                        : "https://via.placeholder.com/40"
                    }
                    alt={user.name}
                    className="rounded-circle shadow-sm"
                    width="40"
                    height="40"
                  />
                </td>
                <td>{user.name}</td>
                <td>{user.email}</td>
                <td>
                  <span
                    className={`badge ${
                      user.role?.name === "admin"
                        ? "bg-danger"
                        : user.role?.name === "webmaster"
                        ? "bg-info"
                        : user.role?.name === "rédacteur"
                        ? "bg-success"
                        : "bg-secondary"
                    }`}
                  >
                    {user.role?.name || "user"}
                  </span>
                </td>
                <td>
                  {user.adresse
                    ? `${user.adresse.ville} (${user.adresse.code_postal})`
                    : "-"}
                </td>
                <td>
                  <div className="d-flex justify-content-center gap-2">
                    <Link
                      href={route("admin.users.edit", user.id)}
                      className="btn btn-sm btn-primary"
                    >
                      Edit
                    </Link>

                    <button
                      onClick={() => {
                        if (
                          confirm(
                            "Voulez-vous vraiment supprimer cet utilisateur ?"
                          )
                        ) {
                          router.delete(route("admin.users.destroy", user.id));
                        }
                      }}
                      className="btn btn-sm btn-danger"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </Back>
  );
}
