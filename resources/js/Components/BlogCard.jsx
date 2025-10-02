export default function BlogCard({ blog }) {
    return (
        <div className="bg-white shadow rounded-lg overflow-hidden relative">
            {/* Image */}
            <div className="relative">
                <img
                    src={`/storage/${blog.image_path}`}
                    alt={blog.titre}
                    className="w-full h-64 object-cover"
                />

                {/* Date badge */}
                <div className="absolute top-4 left-4 bg-pink-600 text-white px-3 py-2 rounded">
                    <p className="text-lg font-bold leading-none">
                        {new Date(blog.created_at).getDate()}
                    </p>
                    <p className="text-sm leading-none">
                        {new Date(blog.created_at).toLocaleString('default', { month: 'short' })}
                    </p>
                </div>
            </div>

            {/* Content */}
            <div className="p-6">
                <h2 className="text-xl font-bold mb-2">{blog.titre}</h2>
                <p className="text-gray-600 mb-4">
                    {blog.description.substring(0, 150)}...
                </p>

                {/* Footer infos */}
                <div className="flex items-center text-sm text-gray-500 gap-4">
                    <span>👤 {blog.categorie?.nom || "Categorie"}</span>
                    <span>💬 2 Comments</span>
                </div>
            </div>
        </div>
    );
}
