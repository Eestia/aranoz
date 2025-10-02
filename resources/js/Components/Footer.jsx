export default function Footer() {
  return (
    <div className="container" style={{ backgroundColor: 'rgba(255, 255, 255, 1)'}}>
      <footer className="py-5">
        <div className="row">
          {/* Première colonne */}
          <div className="col-6 col-md-2 mb-3">
            <h5>Top Products</h5>
            <ul className="nav flex-column">
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Managed Website</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Manage Reputation</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Power Tools</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Marketing Service</a></li>
            </ul>
          </div>

          {/* Deuxième colonne */}
          <div className="col-6 col-md-2 mb-3">
            <h5>Quick Links</h5>
            <ul className="nav flex-column">
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Jobs</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Brand Assets</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Investor Relations</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Terms of Service</a></li>
            </ul>
          </div>

          {/* Troisième colonne */}
          <div className="col-6 col-md-2 mb-3">
            <h5>Features</h5>
            <ul className="nav flex-column">
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Jobs</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Brand Assets</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Investor Relations</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Terms of Service</a></li>
            </ul>
          </div>

          {/* Quatrième colonne */}
          <div className="col-6 col-md-2 mb-3">
            <h5>Resources</h5>
            <ul className="nav flex-column">
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Guides</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Research</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Experts</a></li>
              <li className="nav-item mb-2"><a href="#" className="nav-link p-0 text-body-secondary">Agencies</a></li>
            </ul>
          </div>

          {/* Formulaire newsletter */}
          <div className="col-12 col-md-4 mb-3">
            <form>
              <h5>Newsletter</h5>
              <p>Heaven fruitful doesn't over lesser in days. Appear creeping</p>
              <div className="d-flex flex-column flex-sm-row w-100 gap-2">
                <label htmlFor="newsletter1" className="visually-hidden">Email address</label>
                <input
                  id="newsletter1"
                  type="email"
                  className="form-control"
                  placeholder="Email address"
                />
                <button className="btn btn-primary" type="button">Subscribe</button>
              </div>
            </form>
          </div>
        </div>

        {/* Bas du footer */}
        <div className="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
          <p>Copyright ©2025 All rights reserved | This template is made with love by Colorlib</p>
          <ul className="list-unstyled d-flex">
            <li className="ms-3"><a className="link-body-emphasis" href="#" aria-label="Instagram"><svg className="bi" width="24" height="24"><use xlinkHref="#instagram"></use></svg></a></li>
            <li className="ms-3"><a className="link-body-emphasis" href="#" aria-label="Facebook"><svg className="bi" width="24" height="24" aria-hidden="true"><use xlinkHref="#facebook"></use></svg></a></li>
          </ul>
        </div>
      </footer>
    </div>
  );
}
