export default function Breadcrumb({ title = "Shop", subtitle = "Home - Shop" }) {
    return (
        <div className="position-relative text-center bg-info-subtle">
            {/* Image */}
            <img
                src="/storage/breadcrumb.png"
                alt="breadcrumb"
                className="img-fluid w-100"
                style={{ maxHeight: "370px", objectFit: "cover" }}
            />

            {/* Texte superposé */}
            <div
                className="position-absolute top-50 start-50 translate-middle text-dark"
                style={{ maxWidth: "90%" }}
            >
                <h2 className="fw-bold fs-2 fs-md-1">{title}</h2>
                <p className="fs-6 fs-md-5">{subtitle}</p>
            </div>
        </div>
    );
}
