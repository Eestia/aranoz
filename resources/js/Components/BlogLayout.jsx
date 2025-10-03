import BlogSidebar from "@/Components/BlogSidebar";

export default function BlogLayout({ children, categories = [], tags = [], recentPosts = [] }) {
    return (
        <div className="container py-5">
            <div className="row justify-content-center">
                {/* Colonne principale */}
                <div className="col-md-8">
                    {children}
                </div>

                {/* Sidebar */}
                <div className="col-md-4">
                    <BlogSidebar
                        categories={categories || []}
                        tags={tags || []}
                        recentPosts={recentPosts || []}
                        onSearch={(q) => console.log("search:", q)}
                        onFilterCategory={(c) => console.log("cat:", c)}
                        onFilterTag={(t) => console.log("tag:", t)}
                    />
                </div>
            </div>
        </div>
    );
}
