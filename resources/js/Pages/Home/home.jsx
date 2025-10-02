import Front from '@/Layouts/Front';
import Carousel from '@/Components/Carousel';
import { usePage } from '@inertiajs/react';
import Category from '@/Components/Category';
import Awesome from '@/Components/Awesome';
import Sale from '@/Components/Sale';
import BestSellersCarousel from '@/Components/BestSeller';
import NewsletterSection from '@/Components/Newsletter';
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
            <div>
                <Awesome produits={produits}/>
            </div>
            <div>
                <Sale/>
            </div>
            <div>
                <BestSellersCarousel produits={produits}/>
            </div>
            <div>
                <NewsletterSection/>
            </div>
        </Front>
    );
}
