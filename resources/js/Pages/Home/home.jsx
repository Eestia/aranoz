// //------ page Home exemple: 

// import { usePage } from '@inertiajs/react';

// export default function Home() {
//     const { produits } = usePage().props;

//     return (
//         <div>
//             <h2>Produits épinglés</h2>
//             <div className="carousel">
//                 {produits.map((produit) => (
//                     <div key={produit.id} className="carousel-item">
//                         <img src={`/storage/${produit.image_path}`} alt={produit.titre} />
//                         <h3>{produit.titre}</h3>
//                         <p>{produit.prix} €</p>
//                     </div>
//                 ))}
//             </div>
//         </div>
//     );
// }
