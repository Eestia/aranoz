import Front from "@/Layouts/Front";
import Shop from "@/Components/Shop"; 
import Breadcrumb from "@/Components/Breadcrumb";
import BestSellersCarousel from "@/Components/BestSeller";
import { usePage } from '@inertiajs/react';

export default function Index({ produits, categories, couleurs }) {
    const { produit } = usePage().props;
    return (
        <Front>
            <Breadcrumb title="Shop Category" subtitle="Home - Shop Category" />
            <Shop produits={produits} categories={categories} couleurs={couleurs} />
            <BestSellersCarousel produits={produits}/>
        </Front>
    );
}