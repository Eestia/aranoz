import React, { useState } from "react";
import { useForm, Link , router } from "@inertiajs/react";
import BreadcrumbAdmin from '@/Components/BreadcrumbAdmin';
import Back from "../../../Layouts/Back"

export default function Edit({ user, roles }) {
  const { data, setData, post, errors } = useForm({
    name: user.name || "",
    email: user.email || "",
    phone: user.phone || "",
    role_id: user.role_id || "",
    photo: null,
    _method: "PUT",
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route("admin.users.update", user.id));
  };

  return (
    <Back>
    <BreadcrumbAdmin title="Users" subtitle="Aranoz - Users" />
    <div className="container mt-4">
      <h2>Modifier l’utilisateur</h2>
      <form onSubmit={handleSubmit} encType="multipart/form-data">
        <div className="mb-3">
          <label>Nom</label>
          <input
            type="text"
            value={data.name}
            onChange={(e) => setData("name", e.target.value)}
            className="form-control"
          />
          {errors.name && <div className="text-danger">{errors.name}</div>}
        </div>

        <div className="mb-3">
          <label>Email</label>
          <input
            type="email"
            value={data.email}
            onChange={(e) => setData("email", e.target.value)}
            className="form-control"
          />
          {errors.email && <div className="text-danger">{errors.email}</div>}
        </div>

        <div className="mb-3">
          <label>Téléphone</label>
          <input
            type="text"
            value={data.phone}
            onChange={(e) => setData("phone", e.target.value)}
            className="form-control"
          />
        </div>

        <div className="mb-3">
          <label>Rôle</label>
          <select
            value={data.role_id}
            onChange={(e) => setData("role_id", e.target.value)}
            className="form-select"
          >
            {roles.map((role) => (
              <option key={role.id} value={role.id}>
                {role.name}
              </option>
            ))}
          </select>
        </div>

        <div className="mb-3">
          <label>Photo de profil</label>
          <input
            type="file"
            className="form-control"
            onChange={(e) => setData("photo", e.target.files[0])}
          />
        </div>

        <button type="submit" className="btn btn-primary">
          Enregistrer
        </button>
        <Link href={route("admin.users.index")} className="btn btn-secondary ms-2">
          Annuler
        </Link>
      </form>
    </div>
    </Back>
  );
}
