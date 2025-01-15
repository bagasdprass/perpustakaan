<?php
require_once "../../config/session.php";
require_once "../../config/config.php";
require_once "../../config/functions.php";
checkLogin();

// Inisialisasi variabel
$members = [];
$keyword = $_GET['keyword'] ?? '';

// Jika ada keyword pencarian
if (!empty($keyword)) {
    $members = searchMember($keyword);
} else {
    $members = queryReadData("SELECT * FROM member");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Member terdaftar</title>
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
            padding-bottom: 100px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color)) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 10;
        }

        .navbar .btn-tertiary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .navbar .btn-tertiary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            margin-top: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
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

        .search-form {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .search-form .input-group {
            max-width: 500px;
            margin: 0 auto;
        }

        .search-form input {
            border-radius: 25px 0 0 25px;
            border: 1px solid rgba(147, 51, 234, 0.2);
            padding: 12px 20px;
            background: white;
            color: #2E1065;
        }

        .search-form input:focus {
            box-shadow: 0 0 0 2px rgba(147, 51, 234, 0.2);
            border-color: var(--primary-color);
        }

        .search-form button {
            border-radius: 0 25px 25px 0;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 12px 25px;
            transition: all 0.3s ease;
        }

        .search-form button:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.3);
            color: white;
        }

        caption {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: left;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            background: rgba(255, 255, 255, 0.95) !important;
            border-top: 1px solid rgba(147, 51, 234, 0.2);
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 10;
        }

        footer p {
            color: #2E1065;
            margin: 0;
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

            .search-form {
                padding: 15px;
            }

            .btn-danger {
                padding: 6px 15px;
                font-size: 0.9rem;
            }

            caption {
                font-size: 1.2rem;
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
      <div class="search-form">
        <form action="" method="GET" class="mt-3">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="keyword" 
                       value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" 
                       placeholder="Cari member...">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>
      </div>

      <?php
      // Debug: Tampilkan keyword dan jumlah hasil
      if (!empty($keyword)) {
          echo "<div class='alert alert-info'>";
          echo "Mencari: " . htmlspecialchars($keyword) . "<br>";
          echo "Jumlah hasil: " . count($members);
          echo "</div>";
      }
      ?>

      <div class="table-container">
        <caption>Daftar Member Perpustakaan</caption>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Jurusan</th>
                <th>No Telepon</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach ($members as $item) : ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td><?= htmlspecialchars($item["nisn"]); ?></td>
                <td><?= htmlspecialchars($item["nama"]); ?></td>
                <td><?= htmlspecialchars($item["jenis_kelamin"]); ?></td>
                <td><?= htmlspecialchars($item["jurusan"]); ?></td>
                <td><?= htmlspecialchars($item["no_tlp"]); ?></td>
                <td class="text-center">
                  <a href="deleteMember.php?id=<?= $item["nisn"]; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data member?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  
    <footer class="fixed-bottom shadow-lg bg-subtle p-3">
      <div class="container-fluid d-flex justify-content-between">
      <p class="mt-2">BelajarBuku <span class="text-primary"> </span> © 2025</p>
      <p class="mt-2"></p>
      </div>
    </footer>
    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>