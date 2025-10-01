
import Front from '@/Layouts/Front';
import Carousel from '@/Components/Carousel';
import { usePage } from '@inertiajs/react';
import Category from '@/Components/Category';

export default function Home() {
    const { produits } = usePage().props;

    return (
        <Front>
            <div>
                <Carousel produits={produits} />
            </div>
            <div>
                <Category produits={produits}/>
            </div>
        </Front>
    );
}
