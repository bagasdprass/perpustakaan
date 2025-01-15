<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/member/sign_in.php");
  exit;
}
require "../../config/config.php"; 
$nisnSiswa = $_SESSION["member"]["nisn"];
$dataDenda = queryReadData("SELECT pengembalian.id_pengembalian, pengembalian.id_peminjaman, pengembalian.id_buku, buku.judul, pengembalian.nisn, member.nama, admin.nama_admin, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id_buku
INNER JOIN member ON pengembalian.nisn = member.nisn
INNER JOIN admin ON pengembalian.id_admin = admin.id
WHERE pengembalian.nisn = $nisnSiswa && pengembalian.denda > 0");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Transaksi Denda Buku || Member</title>
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

    /* Table Container */
    .table-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem auto;
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
    }

    /* Alert Styles */
    .alert {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }

    .alert-primary {
        background: rgba(124, 58, 237, 0.2);
        border-color: rgba(124, 58, 237, 0.3);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.3);
    }

    /* Table Styles */
    .table {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .table thead th {
        background: rgba(124, 58, 237, 0.2);
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: none;
        padding: 1rem;
    }

    .table td {
        color: white;
        border-color: rgba(255, 255, 255, 0.1);
        padding: 1rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    /* Navbar */
    .navbar {
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0.1),
            rgba(124, 58, 237, 0.3)
        ) !important;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar .btn-primary {
        background: rgba(255, 255, 255, 0.95) !important;
        border: none !important;
        color: #6D28D9 !important;
        font-weight: 700;
        text-shadow: none;
        letter-spacing: 0.5px;
        padding: 0.7rem 2rem;
        border-radius: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .navbar .btn-primary:hover {
        background: white !important;
        color: #D946EF !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    /* Action Buttons */
    .btn-action {
        background: rgba(255, 255, 255, 0.95);
        color: #6D28D9;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        text-decoration: none;
    }

    .btn-action:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    .btn-danger {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        background: rgba(239, 68, 68, 0.3);
        color: white;
    }

    .btn-warning {
        background: rgba(245, 158, 11, 0.2);
        color: #F59E0B;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        background: rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* Denda Amount */
    .denda-amount {
        font-size: 1.1rem;
        font-weight: 600;
        color: #EF4444;
        text-shadow: 0 0 10px rgba(239, 68, 68, 0.3);
    }

    /* Footer */
    footer {
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0.1),
            rgba(124, 58, 237, 0.2)
        ) !important;
        backdrop-filter: blur(12px);
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1.5rem 0;
        margin-top: 3rem;
        color: white;
    }

    /* Animation */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-container {
            margin: 1rem;
            padding: 1rem;
        }

        .table td, .table th {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
</head>
  <body>
    <nav class="navbar fixed-top bg-body-tertiary shadow-sm">
      <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
        
        <a class="btn btn-primary text-white" href="../dashboardMember.php" style="background-color: #007bff; border: none; transition: transform 0.3s ease, background-color 0.3s ease;">Dashboard</a>
      </div>
    </nav>
  <div class="p-4 mt-5">
    <div class="mt-5 alert alert-primary" role="alert">Riwayat transaksi Denda Anda - <span class="fw-bold text-capitalize"><?php echo htmlentities($_SESSION["member"]["nama"]); ?></span></div>

  <div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
      <thead class="text-center">
      <tr>
        <th class="bg-primary text-light">id buku</th>
        <th class="bg-primary text-light">Judul buku</th>
        <th class="bg-primary text-light">Nisn</th>
        <th class="bg-primary text-light">Nama siswa</th>
        <th class="bg-primary text-light">Nama admin</th>
        <th class="bg-primary text-light">Hari pengembalian</th>
        <th class="bg-primary text-light">Keterlambatan</th>
        <th class="bg-primary text-light">Denda</th>
        <th class="bg-primary text-light">Action</th>
      </tr>
      <thead class="text-center">
        <?php foreach ($dataDenda as $item) : ?>
      <tr>
        <td><?= $item["id_buku"]; ?></td>
        <td><?= $item["judul"]; ?></td>
        <td><?= $item["nisn"]; ?></td>
        <td><?= $item["nama"]; ?></td>
        <td><?= $item["nama_admin"]; ?></td>
        <td><?= $item["buku_kembali"]; ?></td>
        <td><?= $item["keterlambatan"]; ?></td>
        <td><?= $item["denda"]; ?></td>
        <td>
          <a class="btn btn-success" href="formBayarDenda.php?id=<?= $item["id_pengembalian"]; ?>">Bayar</a>
        </td>
      </tr>
        <?php endforeach; ?>
    </table>
    </div>
  </div>
  
  <footer class="fixed-bottom shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku<span class="text-primary"></span> © 2025</p>
      </div>
  </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"></script>
  </body>
</html>
