<?php
require_once "../../config/session.php";
require_once "../../config/functions.php";
checkLogin();

// Inisialisasi variabel
$books = [];
$keyword = $_GET['keyword'] ?? '';

// Jika ada keyword pencarian
if (!empty($keyword)) {
    $books = searchBuku($keyword);
} else {
    $books = queryReadData("SELECT * FROM buku");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Kelola buku || Admin</title>
  </head>
  <style>
    :root {
        --primary-color: #9333EA;    /* Primary Purple */
        --accent-color: #C026D3;     /* Pink Purple */
        --third-color: #7C3AED;      /* Deep Purple */
        --light-purple: #E9D5FF;     /* Light Purple */
        --white-glow: rgba(255, 255, 255, 0.1);
        --neon-glow: 0 0 15px rgba(147, 51, 234, 0.5);
    }

    body {
        background: linear-gradient(135deg, #2E1065, #7E22CE, #C026D3);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .navbar {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color)) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-nav .nav-link {
        color: white !important;
    }

    .layout-card-custom {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        padding: 15px;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100% !important;
        max-width: 180px;
        margin: 0 auto;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(147, 51, 234, 0.3);
    }

    .card-img-top {
        height: 200px !important;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        padding: 0.8rem;
    }

    .card-title {
        color: var(--primary-color);
        font-weight: bold;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .list-group-item {
        padding: 0.5rem 0.8rem;
        font-size: 0.8rem;
        background: transparent;
        border-color: rgba(147, 51, 234, 0.2);
    }

    .btn {
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(135deg, #10B981, #059669);
        border: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .input-group {
        max-width: 500px;
        margin: 0 auto;
    }

    .input-group input {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(147, 51, 234, 0.2);
        padding: 10px 20px;
        border-radius: 25px 0 0 25px !important;
    }

    .input-group button {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 0 25px 25px 0 !important;
    }

    footer {
        background: white !important;
        border-top: 1px solid rgba(147, 51, 234, 0.2);
        margin-top: 2rem;
    }

    .card .btn {
        padding: 5px 15px;
        font-size: 0.8rem;
        flex: 1;
        min-width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card .card-body:last-child {
        padding: 0.8rem;
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-success, .btn-danger {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border: none;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #10B981, #059669);
        transform: translateY(-2px);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .layout-card-custom {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            padding: 10px;
        }
        
        .card {
            max-width: 150px;
        }
        
        .card-img-top {
            height: 180px !important;
        }

        .card .btn {
            padding: 4px 12px;
            font-size: 0.75rem;
        }
    }
  </style>
  <body>
  <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../dashboardAdmin.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-success" href="tambahBuku.php">Tambah Buku</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    
<div class="p-4 mt-4">
      <!--search engine --->
     <form action="" method="GET" class="mt-3">
       <div class="input-group mb-3">
         <input type="text" class="form-control" name="keyword" 
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" 
                placeholder="Cari buku...">
         <button class="btn btn-primary" type="submit">Cari</button>
       </div>
      </form>
       
       <!--Card buku-->
       <div class="layout-card-custom">
       <?php foreach ($books as $item) : ?>
       <div class="card" style="width: 15rem;">
         <img src="../../imgDB/<?= $item["cover"]; ?>" class="card-img-top" alt="coverBuku" height="250px">
         <div class="card-body">
           <h5 class="card-title"><?= $item["judul"]; ?></h5>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Kategori : <?= $item["kategori"]; ?></li>
            <li class="list-group-item">Id Buku : <?= $item["id_buku"]; ?></li>
          </ul>
        <div class="card-body">
          <a class="btn btn-success" href="updateBuku.php?idReview=<?= $item["id_buku"]; ?>" id="review">Edit</a>
          
          <a class="btn btn-danger" href="deleteBuku.php?id=<?= $item["id_buku"]; ?>" onclick="return confirm('Yakin ingin menghapus data buku ? ');">Delete</a>
          </div>
        </div>
       <?php endforeach; ?>
       </div>
      </div>
      
      <footer class="shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2"><span class="text-primary"> BelajarBuku</span> © 2025</p>
      </div>
      </footer>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>