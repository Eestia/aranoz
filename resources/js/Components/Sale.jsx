import { useEffect, useState } from "react";

export default function WeeklySale() {
  // 📌 Date cible (à modifier selon ton besoin)
  const targetDate = new Date("2025-12-31T23:59:59").getTime();

  const [timeLeft, setTimeLeft] = useState({
    days: 0,
    hours: 0,
    minutes: 0,
    seconds: 0,
  });

  useEffect(() => {
    const timer = setInterval(() => {
      const now = new Date().getTime();
      const distance = targetDate - now;

      if (distance > 0) {
        setTimeLeft({
          days: Math.floor(distance / (1000 * 60 * 60 * 24)),
          hours: Math.floor((distance / (1000 * 60 * 60)) % 24),
          minutes: Math.floor((distance / (1000 * 60)) % 60),
          seconds: Math.floor((distance / 1000) % 60),
        });
      } else {
        // ⏰ Temps écoulé
        clearInterval(timer);
        setTimeLeft({ days: 0, hours: 0, minutes: 0, seconds: 0 });
      }
    }, 1000);

    return () => clearInterval(timer);
  }, [targetDate]);

  return (
    <section className="py-5" style={{ backgroundColor: "#e6f9fc" }}>
      <div className="container">
        <div className="row align-items-center justify-content-center">
          <div className="col-lg-8 text-center">
            {/* Titre */}
            <h2 className="fw-bold mb-3">
              Weekly Sale on <span className="text-danger">60% Off</span> All Products
            </h2>

            {/* Compte à rebours dynamique */}
            <div className="d-flex justify-content-center gap-4 mb-4">
              <div>
                <h3 className="fw-bold mb-0">{timeLeft.days}</h3>
                <small className="text-muted">DAYS</small>
              </div>
              <div>
                <h3 className="fw-bold mb-0">{timeLeft.hours}</h3>
                <small className="text-muted">HOURS</small>
              </div>
              <div>
                <h3 className="fw-bold mb-0">{timeLeft.minutes}</h3>
                <small className="text-muted">MINUTES</small>
              </div>
              <div>
                <h3 className="fw-bold mb-0">{timeLeft.seconds}</h3>
                <small className="text-muted">SECONDS</small>
              </div>
            </div>

            {/* Formulaire email */}
            <form className="d-flex justify-content-center">
              <input
                type="email"
                className="form-control w-50 me-2"
                placeholder="Enter Email Address"
                required
              />
              <button className="btn btn-danger px-4 fw-bold">
                BOOK NOW
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
}
