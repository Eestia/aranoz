import { Link } from '@inertiajs/react';
import "../../css/app.css";

export default function Nav() {
  return (
    <nav className="navbar navbar-expand-lg" style={{ backgroundColor: 'rgb(236, 253, 255)'}}>
      <div className="container">
        <div className="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
          <ul className="navbar-nav align-items-center">
            {/* Logo */}
            <li className="nav-item mx-3">
              <a className="navbar-brand fw-bold" href="/">Aranoz.</a>
            </li>

            {/* Liens */}
            <li className="nav-item">
              <a className="nav-link active" aria-current="page" href="/">Home</a>
            </li>
            <li className="nav-item dropdown">
              <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Shop
              </a>
              <ul className="dropdown-menu">
                <li><a className="dropdown-item" href="/shop">Shop Category</a></li>
                <li><a className="dropdown-item" href="#">Track Your Order</a></li>
              </ul>
            </li>
            <li className="nav-item dropdown">
              <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Blog
              </a>
              <ul className="dropdown-menu">
                <li><a className="dropdown-item" href="/blogs">Blog Table</a></li>
              </ul>
            </li>
            <li className="nav-item">
              <a className="nav-link" href="/Contact">Contact</a>
            </li>

            {/* Icon user */}
            <div className="d-flex align-items-center">
              <Link href={route('login')}>
                <img
                  className="utilisateur-icon ms-3"
                  src="/storage/profil_pic/utilisateur.png"
                  alt="Utilisateur"
                  style={{ width: "28px", height: "28px", cursor: "pointer" }}
                />
              </Link>
            </div>
          </ul>
        </div>
      </div>
    </nav>

  );
}
