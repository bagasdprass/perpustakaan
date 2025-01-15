<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>perpusbelajar.com</title>
    <link rel="icon" href="assets/book.png" type="image/png">
    <style>
        /* Base styles */
        body {
            background: linear-gradient(135deg, 
                #2D1657, 
                #4C1D95, 
                #7C3AED, 
                #D946EF,
                #EC4899,
                rgba(255, 255, 255, 0.95)
            );
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: white;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(124, 58, 237, 0.2);
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .navbar .nav-link {
            color: #6D28D9 !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: #D946EF !important;
            transform: translateY(-2px);
        }

        .navbar .navbar-toggler {
            border-color: #6D28D9;
        }

        .navbar-toggler-icon {
            background-color: #6D28D9;
        }

        /* Hero Section */
        #homeSection {
            background: linear-gradient(135deg,
                rgba(45, 22, 87, 0.2),
                rgba(124, 58, 237, 0.15)
            );
            backdrop-filter: blur(12px);
            min-height: 100vh;
            display: flex;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        #homeSection::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(
                circle at center,
                rgba(217, 70, 239, 0.1),
                transparent 70%
            );
        }

        .hero-text {
            padding: 2rem;
        }

        .custom-purple {
            color: #D946EF;
            text-shadow: 0 0 20px rgba(217, 70, 239, 0.5);
        }

        .custom-blue {
            color: #7C3AED;
            text-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        }

        /* Get Started Button */
        .btn-primary {
            background: rgba(255, 255, 255, 0.95) !important;
            border: none !important;
            color: #6D28D9 !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #7C3AED, #D946EF);
            border-radius: 50px;
            z-index: -1;
            filter: blur(8px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .btn-primary:hover {
            background: white !important;
            color: #D946EF !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
        }

        /* About Section */
        #aboutSection {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px);
            padding: 80px 0;
            border-top: 1px solid rgba(124, 58, 237, 0.2);
            border-bottom: 1px solid rgba(124, 58, 237, 0.2);
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        #aboutSection::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(
                circle at right top,
                rgba(124, 58, 237, 0.05),
                transparent 60%
            );
        }

        #aboutSection h2 {
            color: #6D28D9;
            text-shadow: none;
            font-weight: 700;
        }

        #aboutSection p {
            color: #4B5563;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, 
                rgba(45, 22, 87, 0.2),
                rgba(217, 70, 239, 0.15)
            ) !important;
            backdrop-filter: blur(12px);
            position: relative;
            padding: 2rem 0;
            color: white;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(
                circle at left bottom,
                rgba(124, 58, 237, 0.1),
                transparent 70%
            );
        }

        .footer-logo {
            max-width: 200px;
            margin-bottom: 1.5rem;
            filter: brightness(1.2);
        }

        .footer-content h3 {
            color: white;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 600;
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.3);
        }

        .social-links a {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin: 0 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.2);
            margin: 1.5rem 0;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            font-size: 0.9rem;
        }

        /* Animation */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-text {
                text-align: center;
                padding: 1rem;
            }

            .hero-image {
                margin-top: 2rem;
            }

            .btn-primary {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }

            .social-links a {
                width: 35px;
                height: 35px;
                margin: 0 5px;
            }
        }

        /* Add shimmer effect */
        .hero-text h2 {
            position: relative;
            overflow: hidden;
        }

        .hero-text h2::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Additional Glow Effects */
        .hero-text h2 {
            position: relative;
            z-index: 1;
        }

        .hero-text h2 span {
            display: inline-block;
        }

        .custom-blue {
            color: #7C3AED;
            text-shadow: 0 0 20px rgba(124, 58, 237, 0.5);
        }

        .custom-purple {
            color: #D946EF;
            text-shadow: 0 0 20px rgba(217, 70, 239, 0.5);
        }

        /* Enhanced Button Glow */
        .btn-primary {
            position: relative;
            z-index: 1;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #7C3AED, #D946EF);
            border-radius: 50px;
            z-index: -1;
            filter: blur(8px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        /* Add subtle hover effects for about section */
        #aboutSection:hover::before {
            background: radial-gradient(
                circle at right top,
                rgba(217, 70, 239, 0.05),
                transparent 60%
            );
            transition: background 0.3s ease;
        }
    </style>
  </head>
  <body>
    
   <nav class="navbar fixed-top navbar-expand-lg shadow-sm justify-space-between">
  <div class="container-fluid">
    <img src="assets/logoNav.png" alt="logo" width="120px">
    <a href="sign/link_login.html" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#homeSection">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#aboutSection">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#footer">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <section id="homeSection" class="p-5">
      <div class="d-flex flex-wrap justify-content-center align-items-center">
        <div class="col mt-5 hero-text">
         <h2 class="fw-bold mb-4"><span class="custom-blue">Belajar</span><span class="custom-purple">Perpus</span></h2>
          <p class="mb-4 lead">"Temukan Dunia Pengetahuan di Ujung Jari Anda: <br> Perpustakaan Online <span class="fw-bold">BelajarPerpus</span> Membawa Anda ke Dunia Buku Digital."</p>
          <a class="btn btn-primary" href="sign/link_login.html">
              <span>Get Started <i class="fas fa-arrow-right ms-2"></i></span>
          </a>
        </div>
        <div class="col mt-3 hero-image">
          <img src="assets/logoDashboard-transformed.png" class="img-fluid" alt="Dashboard Image" width="450px">
        </div>
      </div>
    </section>
    
    <section class="bg-body-secondary p-5" id="aboutSection">
        <div class="row">
            <div class="d-flex">
                <h2 class="text-primary mb-4">Tentang BelajarPerpus</h2>
            </div>
            <p>BelajarPerpus adalah perpustakaan digital modern yang dirancang untuk memudahkan akses ke dunia literasi dan pembelajaran. Platform ini menyediakan berbagai koleksi buku berkualitas dari berbagai kategori, termasuk Informatika, Bisnis, Filsafat, Novel, dan Sains. Dengan akses 24/7, sistem peminjaman yang efisien, katalog yang selalu diperbarui, dan interface yang user-friendly, BelajarPerpus berkomitmen untuk mendukung pembelajaran seumur hidup. Bergabunglah dengan komunitas pembaca kami dan mulai petualangan literasi Anda hari ini.</p>
        </div>
    </section>
    
    <footer id="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start">
                    <img src="assets/logoFooter.png" class="footer-logo" alt="Logo Footer">
                </div>
                <div class="col-md-4">
                    <div class="footer-content">
                        <h3>Alamat</h3>
                        <p>Jl. Ahmad Yani, Pabelan, Kartasura</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-content">
                        <h3>Sosial Media</h3>
                        <div class="social-links">
                            <a href="https://www.instagram.com/bagasdwip_/" target="_blank" title="Instagram">
                                <i class="fa-brands fa-instagram fs-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="copyright">
                <p>© 2025 BelajarPerpus. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        // Intersection Observer untuk animasi scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        // Observe about section
        document.querySelectorAll('.about-content').forEach((el) => observer.observe(el));

        // Smooth scroll untuk navigasi
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
  </body>
</html>