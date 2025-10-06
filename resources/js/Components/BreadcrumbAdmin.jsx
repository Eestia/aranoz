export default function AdminBreadcrumb({
  title = "Admin Dashboard",
  subtitle = "Aranoz - Shop System",
}) {
  return (
    <div
      className="d-flex justify-content-center align-items-center text-center"
      style={{
        backgroundColor: "rgb(253, 212, 215)", // rose clair
        minHeight: "250px",
      }}
    >
      <div className="d-flex align-items-center gap-5">
        {/* Texte */}
        <div>
          <h2 className="fw-bold fs-2">{title}</h2>
          <p className="fs-6">{subtitle}</p>
        </div>

        {/* Pouf */}
        <img
          src="/storage/produits/offer_img.png" // 👉 mets ton image pouf ici
          alt="pouf"
          style={{
            maxHeight: "200px",
            objectFit: "contain",
          }}
        />
      </div>
    </div>
  );
}
