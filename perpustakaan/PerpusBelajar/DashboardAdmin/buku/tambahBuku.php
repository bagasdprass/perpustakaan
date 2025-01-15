<?php 
require "../../config/config.php";
//$informatika = "informatika";
$kategori = queryReadData("SELECT * FROM kategori_buku");
if(isset($_POST["tambah"]) ) {
  
  if(tambahBuku($_POST) > 0) {
    echo "<script>
    alert('Data buku berhasil ditambahkan');
    </script>";
  }else {
    echo "<script>
    alert('Data buku gagal ditambahkan!');
    </script>";
  }

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Tambah buku || Admin</title>
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
        color: white;
    }

    .navbar {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color)) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar-nav .nav-link {
        color: white !important;
    }

    .container {
        margin-top: 80px;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        border: none;
        padding: 1rem;
    }

    .form-label {
        color: var(--primary-color);
        font-weight: 500;
    }

    .form-control {
        border: 1px solid rgba(147, 51, 234, 0.2);
        border-radius: 8px;
        padding: 8px 12px;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: var(--neon-glow);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border: none;
        border-radius: 25px;
        padding: 8px 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(147, 51, 234, 0.3);
    }

    footer {
        background: white !important;
        border-top: 1px solid rgba(147, 51, 234, 0.2);
        margin-top: 2rem;
        color: #2E1065;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    @media (max-width: 768px) {
        .container {
            margin-top: 60px;
            padding: 15px;
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
          <a class="nav-link text-success" href="daftarBuku.php">Browse</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container p-3 mt-5">
      <div class="card p-2 mt-5">
      <h1 class="text-center fw-bold p-3">Form Tambah buku</h1>
      <form action="" method="post" enctype="multipart/form-data" class="mt-3 p-2">

        <div class="custom-css-form">
        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Cover Buku</label>
          <input class="form-control" type="file" name="cover" id="formFileMultiple" required>
          </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Id Buku</label>
          <input type="text" class="form-control" name="id_buku" id="exampleFormControlInput1" placeholder="example inf01" required>
        </div>
      </div>
    
      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Kategori</label>
        <select class="form-select" id="inputGroupSelect01" name="kategori">
          <option selected>Choose</option>
          <?php foreach ($kategori as $item) : ?>
          <option><?= $item["kategori"]; ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
          <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Buku" aria-label="Username" aria-describedby="basic-addon1" required>
          </div>
        
        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Pengarang</label>
          <input type="text" class="form-control" name="pengarang" id="exampleFormControlInput1" placeholder="nama pengarang"  required>
        </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Penerbit</label>
          <input type="text" class="form-control" name="penerbit" id="exampleFormControlInput1" placeholder="nama penerbit"  required>
        </div>
        
        <label for="validationCustom01" class="form-label">Tahun Terbit</label>
        <div class="input-group mt-0">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
          <input type="date" class="form-control" name="tahun_terbit" id="validationCustom01" required>
          </div>
          
        <label for="validationCustom01" class="form-label">Jumlah Halaman</label>
        <div class="input-group mt-0">
          <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book-open"></i></span>
          <input type="number" class="form-control" name="jumlah_halaman" id="validationCustom01" required>
          </div>
        
        <div class="form-floating mt-3 mb-3">
          <textarea class="form-control" placeholder="sinopsis tentang buku ini" name="buku_deskripsi" id="floatingTextarea2" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Sinopsis</label>
          </div>
          
      <button class="btn btn-success" type="submit" name="tambah">Tambah</button>
      <input type="reset" class="btn btn-warning text-light" value="Reset">
      </form>
    </div>
  </div>
    
  <footer class="mt-5 shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2"><span class="text-primary">BelajarBuku</span> © 2025</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>