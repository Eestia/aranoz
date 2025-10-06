import { useForm, usePage, Link } from "@inertiajs/react";

export default function Tag() {
  const { tags, flash } = usePage().props;
  const { data, setData, post, delete: destroy, reset, wasSuccessful } = useForm({
    nom: "",
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route("admin.tags.store"), { onSuccess: () => reset() });
  };

  return (
    <div className="container py-5">
      <h2 className="fw-bold mb-4">Tags de Blog</h2>
        {flash?.success && (
            <p>{flash?.success}</p>
        )}
      {/* Formulaire */}
      <form onSubmit={handleSubmit} className="d-flex gap-2 mb-4">
        <input
          type="text"
          value={data.nom}
          onChange={(e) => setData("nom", e.target.value)}
          className="form-control"
          placeholder="Nouveau tag"
        />
        <button type="submit" className="btn btn-success">
          Ajouter
        </button>
      </form>

      {/* Liste */}
      <ul className="list-group">
        {tags.map((tag) => (
          <li
            key={tag.id}
            className="list-group-item d-flex justify-content-between align-items-center"
          >
            {tag.nom}
            <Link
              href={route("admin.tags.destroy", tag.id)}
              method="delete"
              as="button"
              className="btn btn-sm btn-danger"
            >
              Supprimer
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
}
