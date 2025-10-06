import BreadcrumbAdmin from '@/Components/BreadcrumbAdmin';
import Tag from '@/Components/Tag';
import Back from '@/Layouts/Back';
import { usePage } from '@inertiajs/react';
export default function dashboard() {

    const { produits } = usePage().props;

    return (
        <Back>
            <BreadcrumbAdmin title="Dashboard" subtitle="Aranoz - Shop system" />
            <Tag/>
        </Back>
    );
}
