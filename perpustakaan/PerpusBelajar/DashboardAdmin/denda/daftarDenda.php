<?php
require_once "../../config/session.php";
checkLogin();

require "../../config/config.php"; 
$dataDenda = queryReadData("SELECT pengembalian.id_pengembalian, pengembalian.id_buku, buku.judul, pengembalian.nisn, member.nama, member.jurusan, admin.nama_admin, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id_buku
INNER JOIN member ON pengembalian.nisn = member.nisn
INNER JOIN admin ON pengembalian.id_admin = admin.id
WHERE pengembalian.denda > 0");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Kelola denda buku || admin</title>
    <style>
        :root {
            --primary-color: #9333EA;    
            --accent-color: #C026D3;     
            --third-color: #7C3AED;      
            --light-purple: #E9D5FF;     
            --white-glow: rgba(255, 255, 255, 0.1);
            --neon-glow: 0 0 15px rgba(147, 51, 234, 0.5);
        }

        body {
            background: linear-gradient(135deg, #2E1065, #7E22CE, #C026D3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 100px; /* Untuk footer fixed */
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color)) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar .btn-tertiary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar .btn-tertiary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 15px;
            font-weight: 500;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(147, 51, 234, 0.1);
        }

        .table tbody tr:hover {
            background: rgba(147, 51, 234, 0.05);
            transform: translateY(-2px);
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            color: #2E1065;
        }

        caption {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: left;
        }

        footer {
            background: white !important;
            border-top: 1px solid rgba(147, 51, 234, 0.2);
            padding: 1rem;
        }

        footer p {
            margin: 0;
            color: #2E1065;
        }

        footer .text-primary {
            color: var(--primary-color) !important;
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .table td, .table th {
                white-space: nowrap;
                min-width: 120px;
            }

            .table td:first-child {
                position: sticky;
                left: 0;
                background: white;
                z-index: 1;
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
        
        <a class="btn btn-tertiary" href="../dashboardAdmin.php">Dashboard</a>
      </div>
    </nav>
    
    <div class="p-4 mt-5">
        <div class="table-container">
            <caption>Daftar Denda Perpustakaan</caption>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Admin</th>
                            <th>Tanggal Kembali</th>
                            <th>Keterlambatan</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataDenda as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item["id_buku"]); ?></td>
                            <td><?= htmlspecialchars($item["judul"]); ?></td>
                            <td><?= htmlspecialchars($item["nisn"]); ?></td>
                            <td><?= htmlspecialchars($item["nama"]); ?></td>
                            <td><?= htmlspecialchars($item["jurusan"]); ?></td>
                            <td><?= htmlspecialchars($item["nama_admin"]); ?></td>
                            <td><?= htmlspecialchars($item["buku_kembali"]); ?></td>
                            <td><?= htmlspecialchars($item["keterlambatan"]); ?> hari</td>
                            <td>Rp <?= number_format($item["denda"], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
  <footer class="fixed-bottom shadow-lg">
      <div class="container-fluid d-flex justify-content-between align-items-center">
          <p class="mb-0">BelajarBuku <span class="text-primary"></span> © 2025</p>
      </div>
  </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>