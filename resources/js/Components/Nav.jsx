import { Link, usePage } from "@inertiajs/react";
import "../../css/app.css";

export default function Nav() {
  const { auth } = usePage().props;
  const isCrudUser = [1,3,4,5].includes(auth?.user?.role_id); 
  // 👉 ici role_id = 1 (admin), 2 (webmaster) par ex
  // adapte selon tes rôles CRUD

  return (
    <nav
      className="navbar navbar-expand-lg"
      style={{
        backgroundColor: isCrudUser
          ? "rgb(253, 212, 215)" // admin / crud users
          : "rgb(236, 253, 255)", // public
      }}
    >
      <div className="container">
        <div
          className="collapse navbar-collapse justify-content-center"
          id="navbarNavDropdown"
        >
          <ul className="navbar-nav align-items-center">
            {/* Logo */}
            <li className="nav-item mx-3">
              <a className="navbar-brand fw-bold" href="/">
                Aranoz.
              </a>
            </li>

            {isCrudUser ? (
              // 🔹 Navigation Admin (pas de dropdown)
              <>
                  <li className="nav-item dropdown">
                  <a
                    className="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Admin
                  </a>
                  <ul className="dropdown-menu">
                    <li>
                      <a className="dropdown-item" href={route('admin.category')}>
                        Category
                      </a>
                    </li>
                    <li>
                      <Link href={route('admin.contact.edit')} className="dropdown-item">
                        Contact
                      </Link>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" href={route("admin.users.index")}>
                    Users
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" href={route("admin.orders.index")}>
                    Orders
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" href={route("admin.blogs.index")}>
                    Blogs
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" href={route("admin.products.index")}>
                    Products
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" href={route("admin.mailbox.index")}>
                    Mailbox
                  </Link>
                </li>
              </>
            ) : (
              // 🔹 Navigation publique (dropdowns conservés)
              <>
                <li className="nav-item">
                  <a
                    className="nav-link active"
                    aria-current="page"
                    href="/"
                  >
                    Home
                  </a>
                </li>
                <li className="nav-item dropdown">
                  <a
                    className="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Shop
                  </a>
                  <ul className="dropdown-menu">
                    <li>
                      <a className="dropdown-item" href="/shop">
                        Shop Category
                      </a>
                    </li>
                    <li>
                      <a className="dropdown-item" href="#">
                        Track Your Order
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item dropdown">
                  <a
                    className="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Blog
                  </a>
                  <ul className="dropdown-menu">
                    <li>
                      <a className="dropdown-item" href="/blogs">
                        Blog Table
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <a className="nav-link" href="/Contact">
                    Contact
                  </a>
                </li>
              </>
            )}

            {/* Icon user / Déconnexion */}
            <div className="d-flex align-items-center">
              {auth?.user ? (
                <Link
                  href={route("logout")}
                  method="post"
                  as="button"
                  className="btn btn-sm btn-danger ms-3"
                >
                  Déconnexion
                </Link>
              ) : (
                <Link href={route("login")}>
                  <img
                    className="utilisateur-icon ms-3"
                    src="/storage/profil_pic/utilisateur.png"
                    alt="Utilisateur"
                    style={{
                      width: "28px",
                      height: "28px",
                      cursor: "pointer",
                    }}
                  />
                </Link>
              )}
            </div>
          </ul>
        </div>
      </div>
    </nav>
  );
}
