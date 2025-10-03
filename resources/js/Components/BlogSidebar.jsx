import { useState } from "react";

export default function BlogSidebar({ categories, tags, recentPosts, onSearch, onFilterCategory, onFilterTag }) {
    const [search, setSearch] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        onSearch(search);
    };

    return (
        <aside>
            {/* Recherche */}
            <div className="card mb-4">
                <div className="card-body">
                    <form onSubmit={handleSubmit} className="d-flex">
                        <input
                            type="text"
                            placeholder="Search Keyword"
                            value={search}
                            onChange={(e) => setSearch(e.target.value)}
                            className="form-control me-2"
                        />
                        <button type="submit" className="btn btn-primary">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            {/* Categories */}
            <div className="card mb-4">
                <div className="card-header fw-bold">Categories</div>
                <div className="card-body d-flex flex-wrap gap-2">
                    {categories.map((cat) => (
                        <button
                            key={cat.id}
                            type="button"
                            className="btn btn-outline-primary btn-sm"
                            onClick={() => onFilterCategory(cat.nom)}
                        >
                            {cat.nom} <span className="badge bg-secondary ms-1">{cat.blogs_count}</span>
                        </button>
                    ))}
                </div>
            </div>

            {/* Recent Posts */}
            <div className="card mb-4">
                <div className="card-header fw-bold">Recent Posts</div>
                <ul className="list-group list-group-flush">
                    {recentPosts.map((post) => (
                        <li key={post.id} className="list-group-item">
                            <div className="fw-medium">{post.titre}</div>
                            <small className="text-muted">
                                {new Date(post.created_at).toLocaleDateString()}
                            </small>
                        </li>
                    ))}
                </ul>
            </div>

            {/* Tags */}
            <div className="card mb-4">
                <div className="card-header fw-bold">Tag Clouds</div>
                <div className="card-body">
                    {tags.map((tag) => (
                        <button
                            key={tag.id}
                            type="button"
                            className="btn btn-outline-primary btn-sm me-2 mb-2"
                            onClick={() => onFilterTag(tag.nom)}
                        >
                            {tag.nom}
                        </button>
                    ))}
                </div>
            </div>

            {/* Newsletter */}
            <div className="card mb-4">
                <div className="card-header fw-bold">Newsletter</div>
                <div className="card-body">
                    <form>
                        <div className="mb-3">
                            <input
                                type="email"
                                placeholder="Enter email"
                                className="form-control"
                            />
                        </div>
                        <button type="submit" className="btn btn-danger w-100">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    );
}
