<?php
require_once "../../config/session.php";
checkLogin();
//Halaman pengelolaan pengembalian Buku Perustakaaan
require "../../config/config.php";
$dataPeminjam = queryReadData("SELECT pengembalian.id_pengembalian, pengembalian.id_buku, buku.judul, buku.kategori, pengembalian.nisn, member.nama, member.kelas, member.jurusan, admin.nama_admin, pengembalian.buku_kembali, pengembalian.keterlambatan, pengembalian.denda
FROM pengembalian
INNER JOIN buku ON pengembalian.id_buku = buku.id_buku
INNER JOIN member ON pengembalian.nisn = member.nisn
INNER JOIN admin ON pengembalian.id_admin = admin.id")
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Kelola pengembalian buku || admin</title>
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

        .btn-danger {
            background: linear-gradient(135deg, #FB7185, #E11D48);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            color: #FFFFFF;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #F43F5E, #BE123C);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 113, 133, 0.4);
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

            .btn-danger {
                padding: 6px 15px;
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
        
        <a class="btn btn-tertiary" href="../dashboardAdmin.php">Dashboard</a>
      </div>
    </nav>
    
    <div class="p-4 mt-5">
      <div class="mt-5">
    <caption>List of pengembalian</caption>
      <div class="table-responsive mt-3">
    <table class="table table-striped table-hover">
     <thead class="text-center">
      <tr>
        <th class="bg-primary text-light">Id Pengembalian</th>
        <th class="bg-primary text-light">Id Buku</th>
        <th class="bg-primary text-light">Judul Buku</th>
        <th class="bg-primary text-light">Kategori</th>
        <th class="bg-primary text-light">Nisn</th>
        <th class="bg-primary text-light">Nama Siswa</th>
        <th class="bg-primary text-light">Kelas</th>
        <th class="bg-primary text-light">Jurusan</th>
        <th class="bg-primary text-light">Nama Admin</th>
        <th class="bg-primary text-light">Tanggal Pengembalian</th>
        <th class="bg-primary text-light">Keterlambatan</th>
        <th class="bg-primary text-light">Denda</th>
        <th class="bg-primary text-light">Delete</th>
      </tr>
    </thead>
        <?php foreach ($dataPeminjam as $item) : ?>
      <tr>
        <td><?= $item["id_pengembalian"]; ?></td>
        <td><?= $item["id_buku"]; ?></td>
        <td><?= $item["judul"]; ?></td>
        <td><?= $item["kategori"]; ?></td>
        <td><?= $item["nisn"]; ?></td>
        <td><?= $item["nama"]; ?></td>
        <td><?= $item["kelas"]; ?></td>
        <td><?= $item["jurusan"]; ?></td>
        <td><?= $item["nama_admin"]; ?></td>
        <td><?= $item["buku_kembali"]; ?></td>
        <td><?= $item["keterlambatan"]; ?></td>
        <td><?= $item["denda"]; ?></td>
        <td>
          <div class="action">
           <a href="deletePengembalian.php?id=<?= $item["id_pengembalian"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ?');"><i class="fa-solid fa-trash"></i></a>
           </div>
          </td>
      </tr>
        <?php endforeach; ?>
    </table>
  </div>
 </div>
</div>
    
  <footer class="fixed-bottom shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku<span class="text-primary"></span> © 2025</p>
      </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>