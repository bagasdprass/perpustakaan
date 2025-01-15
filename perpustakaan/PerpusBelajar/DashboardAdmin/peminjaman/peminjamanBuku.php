<?php
require_once "../../config/session.php";
checkLogin();
// Halaman pengelolaan peminjaman buku perpustakaan
require "../../config/config.php";
$dataPeminjam = queryReadData("SELECT peminjaman.id_peminjaman, peminjaman.id_buku, buku.judul, peminjaman.nisn, member.nama, member.kelas, member.jurusan, peminjaman.id_admin,  peminjaman.tgl_peminjaman, peminjaman.tgl_pengembalian 
FROM peminjaman 
INNER JOIN member ON peminjaman.nisn = member.nisn
INNER JOIN buku ON peminjaman.id_buku = buku.id_buku");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Kelola peminjaman buku || admin</title>
    <style>
        :root {
            --primary-color: #A855F7;    /* Brighter Purple */
            --accent-color: #EC4899;     /* Vibrant Pink */
            --third-color: #A78BFA;      /* Soft Purple */
            --light-purple: #E9D5FF;     /* Very Light Purple */
            --dark-bg: #4C2975;          /* Lighter Background */
            --white-glow: rgba(255, 255, 255, 0.12);
            --neon-glow: 0 0 15px rgba(233, 213, 255, 0.6);
        }

        body {
            background: linear-gradient(135deg, var(--dark-bg), #6D28D9, #7E22CE);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 100px;
            position: relative;
            color: #FFFFFF;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(233, 213, 255, 0.25) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(249, 168, 212, 0.25) 0%, transparent 50%);
            pointer-events: none;
        }

        .navbar {
            background: linear-gradient(90deg, #4C2975, #6D28D9) !important;
            border-bottom: 1px solid rgba(233, 213, 255, 0.4);
            backdrop-filter: blur(10px);
        }

        .navbar .btn-tertiary {
            background: rgba(233, 213, 255, 0.2);
            color: #FFFFFF;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(233, 213, 255, 0.5);
        }

        .navbar .btn-tertiary:hover {
            background: rgba(233, 213, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 213, 255, 0.4);
        }

        .table-container {
            background: rgba(76, 41, 117, 0.85);
            border-radius: 15px;
            padding: 20px;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(233, 213, 255, 0.4);
        }

        .table {
            background: rgba(109, 40, 217, 0.85);
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }

        .table thead th {
            background: linear-gradient(90deg, #A855F7, #EC4899);
            color: #FFFFFF;
            border: none;
            padding: 15px;
            font-weight: 500;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(233, 213, 255, 0.3);
        }

        .table tbody tr:hover {
            background: rgba(233, 213, 255, 0.25);
            transform: translateY(-2px);
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            color: #FFFFFF;
        }

        caption {
            color: #FFFFFF;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: left;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        footer {
            background: rgba(76, 41, 117, 0.85) !important;
            border-top: 1px solid rgba(233, 213, 255, 0.4);
            backdrop-filter: blur(10px);
        }

        footer p {
            color: #FFFFFF;
            margin: 0;
        }

        .text-primary {
            color: var(--light-purple) !important;
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

            caption {
                font-size: 1.2rem;
            }
        }
    </style>
  </head>
  <body>
    <nav class="navbar fixed-top shadow-sm">
      <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
        <a class="btn btn-tertiary" href="../dashboardAdmin.php">Dashboard</a>
      </div>
    </nav>

    <div class="p-4 mt-5">
      <div class="table-container mt-5">
        <caption>Daftar Peminjaman Buku</caption>
        <div class="table-responsive">
          <table class="table">
            <thead class="text-center">
              <tr>
                <th>Id Peminjaman</th>
                <th>Id Buku</th>
                <th>Judul Buku</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Id Admin</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataPeminjam as $item) : ?>
              <tr>
                <td><?= htmlspecialchars($item["id_peminjaman"]); ?></td>
                <td><?= htmlspecialchars($item["id_buku"]); ?></td>
                <td><?= htmlspecialchars($item["judul"]); ?></td>
                <td><?= htmlspecialchars($item["nisn"]); ?></td>
                <td><?= htmlspecialchars($item["nama"]); ?></td>
                <td><?= htmlspecialchars($item["kelas"]); ?></td>
                <td><?= htmlspecialchars($item["jurusan"]); ?></td>
                <td><?= htmlspecialchars($item["id_admin"]); ?></td>
                <td><?= htmlspecialchars($item["tgl_peminjaman"]); ?></td>
                <td><?= htmlspecialchars($item["tgl_pengembalian"]); ?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  
    <footer class="fixed-bottom shadow-lg p-3">
      <div class="container-fluid d-flex justify-content-between">
        <p class="mt-2">BelajarBuku <span class="text-primary"></span> © 2025</p>
      </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>