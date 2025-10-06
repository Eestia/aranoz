import BlogCategory from '@/Components/BlogCategory';
import BreadcrumbAdmin from '@/Components/BreadcrumbAdmin';
import ProduitCategory from '@/Components/ProduitCategory.jsx';
import Tag from '@/Components/Tag';
import Back from '@/Layouts/Back';
import { usePage } from '@inertiajs/react';
export default function dashboard() {

    const { tags, blogCategories, productCategories, flash } = usePage().props;

    return (
        <Back>
            <BreadcrumbAdmin title="Dashboard" subtitle="Aranoz - Shop system" />
            {/* Flash message */}
                    {flash?.success && (
                        <div className="alert alert-success">{flash.success}</div>
                    )}
            <div className="container py-4">
            <ProduitCategory productCategories={usePage().props.productCategories} />
            </div>
            <BlogCategory blogCategories={blogCategories} />
            <Tag/>
        </Back>
    );
}
