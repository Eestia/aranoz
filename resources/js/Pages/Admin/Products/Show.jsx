import BreadcrumbAdmin from '../../../Components/BreadcrumbAdmin';
import Back from "../../../Layouts/Back"
import { usePage } from '@inertiajs/react';

export default function Show({ produits, categories, couleurs }) {
    const { produit } = usePage().props;

    const images = [
        produit.image_path,
        produit.image2_path,
        produit.image3_path,
    ];

    return (
        <Back>
            <BreadcrumbAdmin title="Shop" subtitle="Home - Shop Single" />
            <div className="container py-5">
                <div className="row">
                    
                    {/* Carousel Produit */}
                    <div className="col-md-6">
                        <div id="productCarousel" className="carousel slide" data-bs-ride="carousel">
                            <div className="carousel-inner">
                                {images.map((img, index) => (
                                    <div
                                        key={index}
                                        className={`carousel-item ${index === 0 ? 'active' : ''}`}
                                    >
                                        <img
                                        src={`/storage/${img}`}
                                        className="d-block mx-auto img-fluid p-3"
                                        style={{ objectFit: "contain", maxHeight: "280" }}
                                        alt={produit.titre}
                                        />
                                    </div>
                                ))}
                            </div>

                            {/* Controls */}
                            <button className="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span className="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span className="visually-hidden">Précédent</span>
                            </button>
                            <button className="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span className="carousel-control-next-icon" aria-hidden="true"></span>
                                <span className="visually-hidden">Suivant</span>
                            </button>

                            {/* Indicators */}
                            <div className="carousel-indicators">
                                {images.map((_, index) => (
                                    <button
                                        key={index}
                                        type="button"
                                        data-bs-target="#productCarousel"
                                        data-bs-slide-to={index}
                                        className={index === 0 ? 'active' : ''}
                                        aria-current={index === 0 ? 'true' : 'false'}
                                        aria-label={`Slide ${index + 1}`}
                                    ></button>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Infos Produit */}
                    <div className="col-md-6 d-flex flex-column justify-content-center">
                        <h1 className="h3 fw-bold mb-3">{produit.titre}</h1>

                        {produit.en_reduction ? (
                            <div className="mb-3">
                                <span className="text-muted text-decoration-line-through me-2">
                                    {produit.prix} €
                                </span>
                                <span className="fw-bold text-danger fs-4">
                                    {produit.prix - (produit.prix * produit.reduction_pct) / 100} €
                                </span>
                                <span className="badge bg-danger ms-2">-{produit.reduction_pct}%</span>
                            </div>
                        ) : (
                            <p className="fw-bold fs-4">{produit.prix} €</p>
                        )}

                        <p className="mb-2">
                            <span className="fw-semibold">Disponibilité :</span>{" "}
                            {produit.stock > 0 ? (
                                <span className="text-success">En stock ({produit.stock})</span>
                            ) : (
                                <span className="text-danger">Rupture</span>
                            )}
                        </p>

                        <hr />

                        <p className="text-muted">{produit.description}</p>

                        {/* <button className="btn btn-primary btn-lg mt-3 align-self-start">
                            Ajouter au panier
                        </button> */}
                    </div>
                </div>
            </div>
        </Back>
    );
}
