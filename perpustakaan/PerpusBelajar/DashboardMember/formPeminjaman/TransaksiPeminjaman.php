<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/member/sign_in.php");
  exit;
}
require "../../config/config.php";
$akunMember = $_SESSION["member"]["nisn"];
$dataPinjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, admin.nama_admin, peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian
FROM peminjaman
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN admin ON peminjaman.id_admin = admin.id
WHERE peminjaman.nisn = $akunMember");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Transaksi peminjaman Buku || Member</title>
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

    /* Table Styles */
    .table {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        overflow: hidden;
    }

    .table thead {
        background: rgba(255, 255, 255, 0.1);
    }

    .table th {
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

    /* Status Badge */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .badge-pending {
        background: rgba(236, 72, 153, 0.2);
        color: #EC4899;
        border: 1px solid rgba(236, 72, 153, 0.3);
    }

    .badge-success {
        background: rgba(52, 211, 153, 0.2);
        color: #34D399;
        border: 1px solid rgba(52, 211, 153, 0.3);
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
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .btn-action:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
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

    /* Search Box */
    .search-box {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .search-box:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.3);
        outline: none;
    }

    .search-box::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
</style>
</head>
  <body>
     <nav class="navbar fixed-top bg-body-tertiary shadow-sm">
      <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
        
        <a class="btn btn-primary text-white" href="../dashboardMember.php" style="background-color: #007bff; border: none; transition: all 0.3s ease;">Dashboard</a>
      </div>
    </nav>
    
  <div class="p-4 mt-5">
    <div class="mt-5 alert alert-primary" role="alert">Riwayat transaksi Peminjaman Buku Anda - <span class="fw-bold text-capitalize"><?php echo htmlentities($_SESSION["member"]["nama"]); ?></span></div>
    
  <div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
     <thead class="text-center">
      <tr>
        <th class="bg-primary text-light">Id Peminjaman</th>
        <th class="bg-primary text-light">Id Buku</th>
        <th class="bg-primary text-light">Judul Buku</th>
        <th class="bg-primary text-light">Nisn</th>
        <th class="bg-primary text-light">Nama</th>
        <th class="bg-primary text-light">Nama Admin</th>
        <th class="bg-primary text-light">Tanggal Peminjaman</th>
        <th class="bg-primary text-light">Tanggal Pengembalian</th>
        <th class="bg-primary text-light">Aksi</th>
      </tr>
      </thead>
      
      <tr>
      <?php foreach ($dataPinjam as $item) : ?>
        <td><?= $item["id_peminjaman"]; ?></td>
        <td><?= $item["id_buku"]; ?></td>
        <td><?= $item["judul"]; ?></td>
        <td><?= $item["nisn"]; ?></td>
        <td><?= $item["nama"]; ?></td>
        <td><?= $item["nama_admin"]; ?></td>
        <td><?= $item["tgl_peminjaman"]; ?></td>
        <td><?= $item["tgl_pengembalian"]; ?></td>
        <td>
          <a class="btn btn-success" href="pengembalianBuku.php?id=<?= $item["id_peminjaman"]; ?>"> Kembalikan</a>
        </td>
      <?php endforeach; ?>
      </tr>
    </table>
    </div>
  </div>
  
  <footer class="fixed-bottom shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku<span class="text-primary"></span> © 2025</p>
      </div>
  </footer>
  </body>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>
