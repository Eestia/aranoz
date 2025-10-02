import Front from '@/Layouts/Front';
import { usePage } from '@inertiajs/react';
import Breadcrumb from '@/Components/Breadcrumb';
import BlogCard from '@/Components/BlogCard';

export default function Index() {
    const { blogs = [] } = usePage().props;

    return (
        <Front>
            <Breadcrumb title="Discover Our Blogs" subtitle="Blog - Blogs table" />

            <div className="container mx-auto grid grid-cols-1 gap-8 py-10">
                {blogs.map((blog) => (
                    <BlogCard key={blog.id} blog={blog} />
                ))}
            </div>
        </Front>
    );
}
