<?php 
require "../../config/config.php";
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Detail Buku || Member</title>
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
        }

        /* Card styles */
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(124, 58, 237, 0.3);
        }

        .card-title {
            color: white;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .list-group-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(12px);
        }

        /* Buttons */
        .btn-danger {
            background: linear-gradient(45deg, #EF4444, #F87171) !important;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.5);
        }

        .btn-success {
            background: linear-gradient(45deg, #7C3AED, #D946EF) !important;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5);
        }

        .btn-tertiary {
            background: rgba(255, 255, 255, 0.95);
            color: #6D28D9;
            border: none;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .btn-tertiary:hover {
            background: white;
            color: #D946EF;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
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
        }

        footer p {
            color: white !important;
            text-shadow: 0 0 10px rgba(124, 58, 237, 0.5);
        }

        /* Animations */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes gradientNav {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Page Title */
        h2 {
            color: white;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
        }
    </style>
  </head>
  <body>
    <nav class="navbar fixed-top bg-body-tertiary shadow-sm">
      <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
        
        <a class="btn btn-tertiary" href="../dashboardMember.php">Dashboard</a>
      </div>
    </nav>
    
  <div class="p-4 mt-5">
    <h2 class="mt-5">Detail Buku</h2>
    <div class="d-flex justify-content-center">
    <div class="card" style="width: 18rem;">
      <?php foreach ($query as $item) : ?>
  <img src="../../imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
  <div class="card-body">
    <h5 class="card-title"><?= $item["judul"]; ?></h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Id Buku : <?= $item["id_buku"]; ?></li>
    <li class="list-group-item">Kategori : <?= $item["kategori"]; ?></li>
    <li class="list-group-item">Pengarang : <?= $item["pengarang"]; ?></li>
    <li class="list-group-item">Penerbit : <?= $item["penerbit"]; ?></li>
    <li class="list-group-item">Tahun terbit : <?= $item["tahun_terbit"]; ?></li>
    <li class="list-group-item">Jumlah halaman : <?= $item["jumlah_halaman"]; ?></li>
    <li class="list-group-item">Deskripsi buku : <?= $item["buku_deskripsi"]; ?></li>
  </ul>
  <?php endforeach; ?>
  <div class="card-body">
    <a href="daftarBuku.php" class="btn btn-danger">Batal</a>
     <a href="../formPeminjaman/pinjamBuku.php?id=<?= $item["id_buku"]; ?>" class="btn btn-success">Pinjam</a>
     </div>
    </div>
   </div>
  </div>
  
  <footer class="shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku<span class="text-primary"></span> © 2025</p>
      </div>
  </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>