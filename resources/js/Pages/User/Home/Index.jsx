import BreadCrumb from '@/Components/Breadcrumb';
import Front from '@/Layouts/Front';
import { usePage } from '@inertiajs/react';

export default function UserHome() {
  const { produits } = usePage().props;

  return (
    <Front>
      <BreadCrumb title="Home" subtitle="Aranoz – Shop user page" />
    </Front>
  );
}
