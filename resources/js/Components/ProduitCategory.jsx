import React, { useState } from "react";
import { useForm, usePage, router } from "@inertiajs/react";

export default function ProduitCategory() {
    const { productCategories, flash } = usePage().props;

    // Formulaire d’ajout
    const { data, setData, post, reset, errors } = useForm({
        nom: "",
    });

    // Pour l'édition
    const [editingId, setEditingId] = useState(null);
    const [editNom, setEditNom] = useState("");

    // Ajouter
    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("admin.categories.store"), {
            onSuccess: () => reset(),
        });
    };

    // Supprimer
    const handleDelete = (id) => {
        if (confirm("Supprimer cette catégorie ?")) {
            router.delete(route("admin.categories.destroy", id));
        }
    };

    // Activer le mode édition
    const handleEdit = (cat) => {
        setEditingId(cat.id);
        setEditNom(cat.nom);
    };

    // Sauvegarder édition
    const handleUpdate = (id) => {
        router.put(
            route("admin.categories.update", id),
            { nom: editNom },
            {
                onSuccess: () => {
                    setEditingId(null);
                    setEditNom("");
                },
            }
        );
    };

    return (
        <div className="container mt-4">
            <div className="card shadow">
                <div className="card-header bg-white text-black">
                    <h4 className="mb-0">Catégories de Meubles</h4>
                </div>
                <div className="card-body">
                    {/* Formulaire d'ajout */}
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

                    {/* Tableau */}
                    <div className="table-responsive">
                        <table className="table table-bordered table-striped align-middle">
                            <thead className="table-dark">
                                <tr>
                                    <th style={{ width: "10%" }}>#</th>
                                    <th>Nom</th>
                                    <th style={{ width: "25%" }} className="text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {productCategories.length > 0 ? (
                                    productCategories.map((cat, index) => (
                                        <tr key={cat.id}>
                                            <td>{index + 1}</td>
                                            <td>
                                                {editingId === cat.id ? (
                                                    <input
                                                        type="text"
                                                        value={editNom}
                                                        onChange={(e) =>
                                                            setEditNom(e.target.value)
                                                        }
                                                        className="form-control"
                                                    />
                                                ) : (
                                                    cat.nom
                                                )}
                                            </td>
                                            <td className="text-center">
                                                {editingId === cat.id ? (
                                                    <>
                                                        <button
                                                            onClick={() => handleUpdate(cat.id)}
                                                            className="btn btn-sm btn-success me-2"
                                                        >
                                                            Enregistrer
                                                        </button>
                                                        <button
                                                            onClick={() => setEditingId(null)}
                                                            className="btn btn-sm btn-secondary"
                                                        >
                                                            Annuler
                                                        </button>
                                                    </>
                                                ) : (
                                                    <>
                                                        <button
                                                            onClick={() => handleEdit(cat)}
                                                            className="btn btn-sm btn-warning me-2"
                                                        >
                                                            Modifier
                                                        </button>
                                                        <button
                                                            onClick={() => handleDelete(cat.id)}
                                                            className="btn btn-sm btn-danger"
                                                        >
                                                            Supprimer
                                                        </button>
                                                    </>
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="3" className="text-center text-muted">
                                            Aucune catégorie
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
