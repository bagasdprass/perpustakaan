<?php 
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/member/sign_in.php");
  exit;
}
require "../../config/config.php";
// Tangkap id buku dari URL (GET)
$idBuku = $_GET["id"];
$query = queryReadData("SELECT * FROM buku WHERE id_buku = '$idBuku'");
//Menampilkan data siswa yg sedang login
$nisnSiswa = $_SESSION["member"]["nisn"];
$dataSiswa = queryReadData("SELECT * FROM member WHERE nisn = $nisnSiswa");
$admin = queryReadData("SELECT * FROM admin");

// Peminjaman 
if(isset($_POST["pinjam"]) ) {
  
  if(pinjamBuku($_POST) > 0) {
    echo "<script>
    alert('Buku berhasil dipinjam');
    </script>";
  }else {
    echo "<script>
    alert('Buku gagal dipinjam!');
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
     <title>Form pinjam Buku || Member</title>
  </head>
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

    /* Form Container */
    .form-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem auto;
        max-width: 800px;
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
    }

    /* Form Elements */
    .form-label {
        color: white;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 500;
        padding: 0.8rem 1.2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.3);
        outline: none;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Buttons */
    .btn-submit {
        background: rgba(255, 255, 255, 0.95);
        color: #6D28D9;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .btn-submit:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        font-weight: 600;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-3px);
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
        .form-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .btn-submit, .btn-back {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }
    }
  </style>
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
    <h2 class="mt-5">Form peminjaman Buku</h2>
    <div class="card">
      <h5 class="card-header">Data Lengkap buku</h5>
      <div class="card-body d-flex flex-wrap gap-5 justify-content-center">
          <?php foreach ($query as $item) : ?>
        <p class="card-text"><img src="../../imgDB/<?= $item["cover"]; ?>" width="180px" height="185px" style="border-radius: 5px;"></p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Id Buku</span>
            <input type="text" class="form-control" placeholder="id buku" aria-label="Username" aria-describedby="basic-addon1" value="<?= $item["id_buku"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kategori</span>
            <input type="text" class="form-control" placeholder="kategori" aria-label="kategori" aria-describedby="basic-addon1" value="<?= $item["kategori"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Judul</span>
            <input type="text" class="form-control" placeholder="judul" aria-label="judul" aria-describedby="basic-addon1" value="<?= $item["judul"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Pengarang</span>
            <input type="text" class="form-control" placeholder="pengarang" aria-label="pengarang" aria-describedby="basic-addon1" value="<?= $item["pengarang"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Penerbit</span>
            <input type="text" class="form-control" placeholder="penerbit" aria-label="penerbit" aria-describedby="basic-addon1" value="<?= $item["penerbit"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tahun Terbit</span>
            <input type="date" class="form-control" placeholder="tahun_terbit" aria-label="tahun_terbit" aria-describedby="basic-addon1" value="<?= $item["tahun_terbit"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jumlah Halaman</span>
            <input type="number" class="form-control" placeholder="jumlah halaman" aria-label="jumlah halaman" aria-describedby="basic-addon1" value="<?= $item["jumlah_halaman"]; ?>" readonly>
            </div>
          <div class="form-floating">
            <textarea class="form-control" placeholder="deskripsi singkat buku" id="floatingTextarea2" style="height: 100px" readonly><?= $item["buku_deskripsi"]; ?></textarea>
            <label for="floatingTextarea2">Deskripsi Buku</label>
            </div>
        <?php endforeach; ?>
        </form>
       </div>
      </div>
      
    <div class="card mt-4">
      <h5 class="card-header">Data lengkap Siswa</h5>
      <div class="card-body d-flex flex-wrap gap-4 justify-content-center">
        <p><img src="../../assets/memberLogo.png" width="150px"></p>
        <form action="" method="post">
          <?php foreach ($dataSiswa as $item) : ?>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nisn</span>
            <input type="number" class="form-control" placeholder="nisn" aria-label="nisn" aria-describedby="basic-addon1" value="<?= $item["nisn"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kode Member</span>
            <input type="text" class="form-control" placeholder="kode member" aria-label="kode member" aria-describedby="basic-addon1" value="<?= $item["kode_member"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nama</span>
            <input type="text" class="form-control" placeholder="nama" aria-label="nama" aria-describedby="basic-addon1" value="<?= $item["nama"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jenis Kelamin</span>
            <input type="text" class="form-control" placeholder="jenis kelamin" aria-label="jenis kelamin" aria-describedby="basic-addon1" value="<?= $item["jenis_kelamin"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Kelas</span>
            <input type="text" class="form-control" placeholder="kelas" aria-label="kelas" aria-describedby="basic-addon1" value="<?= $item["kelas"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Jurusan</span>
            <input type="text" class="form-control" placeholder="jurusan" aria-label="jurusan" aria-describedby="basic-addon1" value="<?= $item["jurusan"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">No Tlp</span>
            <input type="no_tlp" class="form-control" placeholder="no tlp" aria-label="no tlp" aria-describedby="basic-addon1" value="<?= $item["no_tlp"]; ?>" readonly>
            </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tanggal Daftar</span>
            <input type="date" class="form-control" placeholder="tgl_pendaftaran" aria-label="tgl_pendaftaran" aria-describedby="basic-addon1" value="<?= $item["tgl_pendaftaran"]; ?>" readonly>
            </div>
        <?php endforeach; ?>
        </form>
       </div>
      </div>
    
    <div class="alert alert-danger mt-4" role="alert">Silahkan periksa kembali data diatas, pastikan sudah benar sebelum meminjam buku!. jika ada kesalahan data harap hubungi admin</div>
    
    <div class="card mt-4">
      <h5 class="card-header">Form Pinjam Buku</h5>
      <div class="card-body">
        <form action="" method="post">
          <!--Ambil data id buku-->
          <?php foreach ($query as $item) : ?>
           <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Id Buku</span>
            <input type="text" name="id_buku" class="form-control" placeholder="id buku" aria-label="id_buku" aria-describedby="basic-addon1" value="<?= $item["id_buku"]; ?>" readonly>
            </div>
          <?php endforeach; ?>
        <!-- Ambil data NISN user yang login-->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nisn</span>
            <input type="number" name="nisn" class="form-control" placeholder="nisn" aria-label="nisn" aria-describedby="basic-addon1" value="<?php echo htmlentities($_SESSION["member"]["nisn"]); ?>" readonly>
        </div>
    <!--Ambil data id admin-->
    <select name="id" class="form-select" aria-label="Default select example">
      <option selected>Pilih id admin</option>
      <?php foreach ($admin as $item) : ?>
      <option><?= $item["id"]; ?></option>
      <?php endforeach; ?>
    </select>
    <div class="input-group mb-3 mt-3">
            <span class="input-group-text" id="basic-addon1">Tanggal pinjam</span>
            <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control" placeholder="id buku" aria-label="tgl_peminjaman" aria-describedby="basic-addon1" onchange="setReturnDate()" required>
      </div>
    <div class="input-group mb-3 mt-3">
            <span class="input-group-text" id="basic-addon1">Tenggat Pengembalian</span>
            <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control" placeholder="tgl_pengembalian" aria-label="tgl_pengembalian" aria-describedby="basic-addon1" readonly>
      </div>
      
    <a class="btn btn-danger" href="../buku/daftarBuku.php"> Batal</a>
    <button type="submit" class="btn btn-success" name="pinjam">Pinjam</button>
    </form>
    </div>
    </div>
  
    <div class="alert alert-danger mt-4" role="alert"><span class="fw-bold">Catatan :</span> Setiap keterlambatan pada pengembalian buku akan dikenakan sanksi berupa denda.</div>
    
    </div>
    
    <footer class="shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku<span class="text-primary"></span> © 2025</p>
      </div>
  </footer>
    
    <!--JAVASCRIPT -->
    <script src="../../style/js/script.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
