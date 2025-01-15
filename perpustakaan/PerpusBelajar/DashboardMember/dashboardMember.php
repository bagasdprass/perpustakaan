<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../sign/member/sign_in.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Member Dashboard</title>
    <style>
        :root {
            --primary-color: #9333EA;    /* Primary Purple */
            --accent-color: #C026D3;     /* Pink Purple */
            --third-color: #7C3AED;      /* Deep Purple */
            --background: #2E1065;       /* Dark Purple Background */
            --card-bg: rgba(255, 255, 255, 0.15);
            --neon-glow: 0 0 15px rgba(147, 51, 234, 0.5);
        }

        body {
            background: linear-gradient(135deg, #2E1065, #7E22CE, #C026D3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(46, 16, 101, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .menu-card {
            background: linear-gradient(135deg, #fff, #FDF4FF);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(192, 38, 211, 0.1);
            box-shadow: 0 4px 15px rgba(192, 38, 211, 0.1);
        }

        .menu-card:hover {
            box-shadow: 0 8px 25px rgba(192, 38, 211, 0.2);
        }

        .menu-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px 20px;
            color: #2E1065;
            text-decoration: none;
            height: 100%;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #fff, #FDF4FF);
        }

        .menu-button:hover {
            background: linear-gradient(135deg, #C026D3, #9333EA);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(192, 38, 211, 0.3);
        }

        .menu-button h4 {
            color: #C026D3;
            font-weight: bold;
            margin: 15px 0 10px;
            transition: all 0.3s ease;
        }

        .menu-button p {
            color: #7E22CE;
            margin: 0;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .menu-button i {
            color: #C026D3;
            font-size: 2.5em;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .menu-button:hover h4,
        .menu-button:hover p,
        .menu-button:hover i {
            color: white;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 15px;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #2E1065, #7E22CE);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(192, 38, 211, 0.2);
        }

        .welcome-banner h2 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 5px;
        }

        .welcome-banner p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
        }

        .date-display {
            background: linear-gradient(135deg, #2E1065, #7E22CE);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 4px 15px rgba(192, 38, 211, 0.2);
        }

        .date-display h1 {
            color: white;
            font-size: 2rem;
        }

        .date-display .text-secondary {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transform: translateY(-2px);
        }

        .dropdown-menu {
            background: #fff;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: #2E1065;
        }

        .dropdown-item:hover {
            background: rgba(147, 51, 234, 0.1);
            color: var(--primary-color);
        }

        footer {
            background: linear-gradient(135deg, #2E1065, #7E22CE);
            color: white;
        }

        footer .text-primary {
            color: #FDF4FF !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-secondary {
            color: #666 !important;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
                padding: 10px;
            }
        }

        h3.mb-4 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .menu-button h4 {
            color: #2E1065;
            font-weight: bold;
            font-size: 1.3rem;
            margin: 15px 0 10px;
        }

        .menu-button p {
            color: #7E22CE;
            opacity: 0.9;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top shadow-sm">
        <div class="container-fluid p-3 d-flex align-items-center justify-content-between">
            <a class="navbar-brand text-light d-flex align-items-center" href="#">
                <img src="../assets/logoNav.png" alt="logo" width="120px" class="me-2">
            </a>
            
            <a href="#" class="btn btn-primary ms-auto me-3">
                <i class="fas fa-desktop me-2"></i>SLIMS 9
            </a>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                    <img src="../assets/memberLogo (2).png" alt="memberLogo" width="40px" class="profile-img">
                </button>
                <ul class="dropdown-menu position-absolute mt-2 p-2" style="right: 0; transform: translateX(-40%);">
                    <li>
                        <a class="dropdown-item text-center p-2" href="#">
                            <img src="../assets/memberLogo (2).png" alt="memberLogo" width="50px" class="profile-img mb-2">
                            <p class="mb-0 text-capitalize fw-bold"><?php echo $_SESSION['member']['nama']; ?></p>
                            <small class="text-muted">Siswa</small>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item p-2 text-danger d-flex align-items-center" href="signOut.php">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="date-display">
            <h1 class="fw-bold">Dashboard <span class="fs-4 text-secondary">
                <?php 
                $day = date('l');
                $dayOfMonth = date('d');
                $month = date('F');
                $year = date('Y');
                echo $day. " ". $dayOfMonth." ". " ". $month. " ". $year;
                ?>
            </span></h1>
        </div>

        <div class="welcome-banner">
            <h2>Welcome, <span class="text-capitalize fw-bold"><?php echo $_SESSION['member']['nama']; ?></span>!</h2>
            <p class="mb-0">to PerpusBelajar Library Services</p>
        </div>

        <h3 class="mb-4">Available Library Services</h3>
        
        <div class="services-grid">
            <div class="menu-card">
                <a href="buku/daftarBuku.php" class="menu-button">
                    <i class="fas fa-book fa-2x mb-3"></i>
                    <h4>Daftar Buku</h4>
                    <p>Jelajahi koleksi buku perpustakaan</p>
                </a>
            </div>

            <div class="menu-card">
                <a href="formPeminjaman/TransaksiPeminjaman.php" class="menu-button">
                    <i class="fas fa-hand-holding-heart fa-2x mb-3"></i>
                    <h4>Peminjaman</h4>
                    <p>Pinjam buku favoritmu</p>
                </a>
            </div>

            <div class="menu-card">
                <a href="formPeminjaman/TransaksiPengembalian.php" class="menu-button">
                    <i class="fas fa-undo-alt fa-2x mb-3"></i>
                    <h4>Pengembalian</h4>
                    <p>Kembalikan buku yang dipinjam</p>
                </a>
            </div>

            <div class="menu-card">
                <a href="formPeminjaman/TransaksiDenda.php" class="menu-button">
                    <i class="fas fa-receipt fa-2x mb-3"></i>
                    <h4>Denda</h4>
                    <p>Informasi denda keterlambatan</p>
                </a>
            </div>
        </div>
    </div>

    <footer class="shadow-lg bg-white p-3 mt-5">
        <div class="container-fluid d-flex justify-content-between">
            <p class="mt-2">BelajarBuku <span class="text-primary"></span> © 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
