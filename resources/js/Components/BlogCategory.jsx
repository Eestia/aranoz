import React from "react";
import { useForm, usePage, router } from "@inertiajs/react";

export default function BlogCategory({ blogCategories }) {
    const { auth } = usePage().props;

    // Formulaire d'ajout
    const { data, setData, post, reset, errors } = useForm({
        nom: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("admin.blog-categories.store"), {
            onSuccess: () => reset(),
        });
    };

    // Suppression
    const handleDelete = (id) => {
        if (confirm("Supprimer cette catégorie de blog ?")) {
            router.delete(route("admin.blog-categories.destroy", id));
        }
    };

    return (
        <div className="container mt-4">
            <div className="card shadow">
                <div className="card-header bg-white text-black">
                    <h4 className="mb-0">Catégories de Blog</h4>
                </div>
                <div className="card-body">
                    
                    {/* Formulaire création */}
                    <form onSubmit={handleSubmit} className="row g-2 mb-3">
                        <div className="col-md-8">
                            <input
                                type="text"
                                value={data.nom}
                                onChange={(e) => setData("nom", e.target.value)}
                                placeholder="Nom de la catégorie"
                                className="form-control"
                            />
                            {errors.nom && (
                                <div className="text-danger small mt-1">
                                    {errors.nom}
                                </div>
                            )}
                        </div>
                        <div className="col-md-4 d-grid">
                            <button type="submit" className="btn btn-success">
                                Ajouter
                            </button>
                        </div>
                    </form>

                    {/* Tableau Bootstrap */}
                    <div className="table-responsive">
                        <table className="table table-bordered table-striped align-middle">
                            <thead className="table-dark">
                                <tr>
                                    <th style={{ width: "10%" }}>#</th>
                                    <th>Nom</th>
                                    <th style={{ width: "20%" }} className="text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {blogCategories.length > 0 ? (
                                    blogCategories.map((cat, index) => (
                                        <tr key={cat.id}>
                                            <td>{index + 1}</td>
                                            <td>{cat.nom}</td>
                                            <td className="text-center">
                                                <button
                                                    onClick={() => handleDelete(cat.id)}
                                                    className="btn btn-sm btn-danger"
                                                >
                                                    Supprimer
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="3" className="text-center text-muted">
                                            Aucune catégorie disponible
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    );
}
