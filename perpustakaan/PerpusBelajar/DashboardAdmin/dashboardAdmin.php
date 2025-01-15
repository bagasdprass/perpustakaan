<?php
// Pastikan SSO config sudah di-load
require_once __DIR__ . '/../config/sso_config.php';

// Gunakan session.php untuk mengelola session
require_once __DIR__ . '/../config/session.php';
checkLogin();

// Inisialisasi default values untuk session admin
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = [
        'id' => 0,
        'nama' => 'Guest',
        'username' => '',
        'email' => '',
        'level' => '',
        'created_at' => ''
    ];
}

// Pastikan semua key yang diperlukan tersedia
$adminData = array_merge([
    'id' => 0,
    'nama' => 'Guest',
    'username' => '',
    'email' => '',
    'level' => '',
    'created_at' => ''
], $_SESSION['admin'] ?? []);

// Update session dengan data lengkap
$_SESSION['admin'] = $adminData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>
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
            background: linear-gradient(90deg,
                rgba(45, 22, 87, 0.95),
                rgba(76, 29, 149, 0.95),
                rgba(124, 58, 237, 0.95),
                rgba(217, 70, 239, 0.95)
            ) !important;
            background-size: 300% 300%;
            animation: gradientNav 15s ease infinite;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(124, 58, 237, 0.4);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(124, 58, 237, 0.3);
            position: relative;
        }

        .navbar-brand, .nav-link {
            color: white !important;
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
        }

        .navbar .btn-primary {
            border: 2px solid rgba(124, 58, 237, 0.5) !important;
        }

        /* Date Display */
        .date-display {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            color: #6D28D9;
        }

        /* Stat Cards */
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .stat-card h3 {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .stat-card h2 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .dashboard-card h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Button Styles */
        .btn-modern {
            background: linear-gradient(45deg, #7C3AED, #D946EF) !important;
            color: white !important;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .btn-modern:hover {
            background: linear-gradient(45deg, #D946EF, #7C3AED) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5),
                       0 0 20px rgba(255, 255, 255, 0.4);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        /* SLIMS Button */
        .btn-slims {
            background: linear-gradient(45deg, #EC4899, #D946EF) !important;
            color: white !important;
            border: none !important;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-slims:hover {
            background: linear-gradient(45deg, #D946EF, #EC4899) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.5),
                       0 0 20px rgba(255, 255, 255, 0.4);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        /* Sign Out Button */
        .btn-signout {
            background: linear-gradient(45deg, #EF4444, #F87171) !important;
            color: white !important;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-signout:hover {
            background: linear-gradient(45deg, #F87171, #EF4444) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5),
                       0 0 20px rgba(255, 255, 255, 0.4);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        /* Icon colors for buttons */
        .btn-modern i, 
        .btn-slims i,
        .btn-signout i {
            color: white;
            margin-right: 0.5rem;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));
        }

        /* Button Shine Effect */
        .btn-modern::after,
        .btn-slims::after,
        .btn-signout::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .dropdown-item:hover {
            background: rgba(124, 58, 237, 0.1);
            color: #6D28D9;
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg,
                rgba(45, 22, 87, 0.95),
                rgba(76, 29, 149, 0.95),
                rgba(124, 58, 237, 0.95),
                rgba(217, 70, 239, 0.95)
            ) !important;
            background-size: 300% 300%;
            animation: gradientNav 15s ease infinite;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(124, 58, 237, 0.4);
            padding: 1.5rem 0;
            color: white !important;
            box-shadow: 0 -4px 20px rgba(124, 58, 237, 0.3);
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
            position: relative;
        }

        footer p {
            color: white !important;
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
        }

        /* Animation for Navbar and Footer gradient */
        @keyframes gradientNav {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Enhanced Neon Border Effect */
        .navbar::after,
        footer::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg,
                transparent,
                #7C3AED,
                #D946EF,
                #7C3AED,
                transparent
            );
            background-size: 200% auto;
            animation: neonFlow 3s linear infinite;
        }

        .navbar::after {
            bottom: 0;
        }

        footer::after {
            top: 0;
        }

        @keyframes neonFlow {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* Enhanced Glow Effect */
        .navbar-brand, .nav-link, footer p {
            color: white !important;
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5),
                        0 0 20px rgba(217, 70, 239, 0.3),
                        0 0 30px rgba(236, 72, 153, 0.2);
            animation: textPulse 2s ease-in-out infinite;
        }

        @keyframes textPulse {
            0% { text-shadow: 0 0 10px rgba(124, 58, 237, 0.5); }
            50% { text-shadow: 0 0 20px rgba(217, 70, 239, 0.8),
                              0 0 30px rgba(236, 72, 153, 0.5); }
            100% { text-shadow: 0 0 10px rgba(124, 58, 237, 0.5); }
        }

        /* Animation */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Icons */
        .fa-solid, .fas {
            color: #6D28D9;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-card, .dashboard-card {
                margin-bottom: 1rem;
            }

            .btn-modern {
                padding: 0.8rem;
                font-size: 0.9rem;
            }

            .stat-card h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top shadow-sm">
        <div class="container-fluid p-3">
            <a class="navbar-brand text-light" href="#">
                <img src="../assets/logoNav.png" alt="logo" width="120px">
            </a>
            
            <div class="d-flex align-items-center gap-3">
            <a class="btn btn-primary text-white ms-auto me-4" 
               href="../lib/slims_redirect.php" 
               target="_blank"
               style="background-color: #007bff; border: none; transition: 0.3s;">
               SLIMS 9
            </a>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <img src="../assets/adminLogo (2).png" alt="adminLogo" width="40px">
                    </button>
                    <ul class="dropdown-menu position-absolute mt-2 p-2" style="right: 0; transform: translateX(-45%);">
                        <li>
                            <a class="dropdown-item text-center py-2" href="#">
                                <img src="../assets/adminLogo (2).png" alt="adminLogo" width="30" height="30" class="rounded-circle">
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-item text-center">
                                <span class="text-capitalize fw-bold"><?php echo htmlspecialchars($adminData['nama']); ?></span>
                                <br>
                                <small class="text-muted">
                                    <?php echo htmlspecialchars($adminData['level'] ?: 'Administrator'); ?>
                                </small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-center p-2 bg-danger text-light rounded mx-2" href="signOut.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="date-display mb-4">
            <h1 class="fw-bold">Dashboard <span class="fs-4 text-secondary">
                <?php echo date('l, d F Y'); ?>
            </span></h1>
        </div>

        <div class="row g-4">
            <!-- Statistics Cards -->
            <div class="col-md-3">
                <div class="stat-card p-4">
                    <h3>Total Books</h3>
                    <h2 class="mb-0">2,450</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-4">
                    <h3>Active Members</h3>
                    <h2 class="mb-0">873</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-4">
                    <h3>Borrowed</h3>
                    <h2 class="mb-0">156</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card p-4">
                    <h3>Overdue</h3>
                    <h2 class="mb-0">12</h2>
                </div>
            </div>

            <!-- Updated Menu Cards - Now 5 cards -->
            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>Member Management</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/member/member.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-users me-2"></i> Manage Members
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>Book Management</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/buku/daftarBuku.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-book me-2"></i> Manage Books
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>Borrowing</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/peminjaman/peminjamanBuku.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-hand-holding-heart me-2"></i> Book Borrowing
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>Returns</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/pengembalian/pengembalianBuku.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-undo-alt me-2"></i> Book Returns
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>Fines Management</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/denda/daftarDenda.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-money-bill-wave me-2"></i> Manage Fines
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card p-4">
                    <h4>SLIMS Integration</h4>
                    <a href="<?php echo getBaseUrl(); ?>/DashboardAdmin/buku/sync_slims.php" class="btn btn-modern w-100 mt-3">
                        <i class="fas fa-sync me-2"></i> Sync with SLIMS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="shadow-lg bg-white p-3 mt-5">
        <div class="container-fluid d-flex justify-content-between">
            <p class="mt-2">BelajarBuku<span class="text-primary">.</span> © 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

