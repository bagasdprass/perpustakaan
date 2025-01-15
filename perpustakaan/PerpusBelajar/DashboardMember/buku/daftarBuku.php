<?php
session_start();

if(!isset($_SESSION["signIn"]) ) {
  header("Location: ../../sign/member/sign_in.php");
  exit;
}

require "../../config/config.php";
// query read semua buku
$buku = queryReadData("SELECT * FROM buku");
//search buku
if(isset($_POST["search"]) ) {
  $buku = search($_POST["keyword"]);
}
//read buku informatika
if(isset($_POST["informatika"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'informatika'");
}
//read buku bisnis
if(isset($_POST["bisnis"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'bisnis'");
}
//read buku filsafat
if(isset($_POST["filsafat"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'filsafat'");
}
//read buku novel
if(isset($_POST["novel"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'novel'");
}
//read buku sains
if(isset($_POST["sains"]) ) {
$buku = queryReadData("SELECT * FROM buku WHERE kategori = 'sains'");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Daftar Buku || Member</title>
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

    /* Container utama */
    .main-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 6rem 1rem 2rem;
    }

    /* Filter dan Search Section */
    .filter-search-section {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    /* Filter Buttons */
    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
        padding: 0.5rem;
    }

    .btn-filter {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        color: #6D28D9;
        font-weight: 700;
        text-shadow: none;
        letter-spacing: 0.5px;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        min-width: 130px;
        transition: all 0.4s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .btn-filter:hover,
    .btn-filter.active {
        background: white;
        color: #D946EF;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    /* Search Box */
    .search-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .search-box {
        background: rgba(255, 255, 255, 0.15);
        border: 3px solid rgba(124, 58, 237, 0.3);
        border-radius: 30px;
        overflow: hidden;
        display: flex;
        padding: 0.5rem;
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.2);
        transition: all 0.3s ease;
    }

    .search-input {
        border: none;
        padding: 1rem 1.8rem;
        flex: 1;
        background: transparent;
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
        font-size: 1rem;
    }

    .search-button {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 25px;
        color: #6D28D9;
        font-weight: 700;
        font-size: 1.1rem;
        text-shadow: none;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.4s ease;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }

    .search-button:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    .search-box:focus-within {
        border-color: rgba(124, 58, 237, 0.6);
        box-shadow: 0 8px 30px rgba(124, 58, 237, 0.4);
        transform: translateY(-2px);
    }

    /* Books Grid */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .book-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 20px rgba(255, 255, 255, 0.15);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .book-cover {
        height: 280px;
        position: relative;
        overflow: hidden;
    }

    .book-cover::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(76, 29, 149, 0.5), transparent);
    }

    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .book-info {
        padding: 1.2rem;
        background: linear-gradient(180deg, 
            rgba(255, 255, 255, 0.15),
            rgba(124, 58, 237, 0.3),
            rgba(236, 72, 153, 0.3)
        );
        backdrop-filter: blur(8px);
        border-top: 1px solid rgba(167, 139, 250, 0.3);
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .book-title {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-style: italic;
    }

    .book-category {
        display: inline-block;
        background: rgba(255, 255, 255, 0.95);
        color: #6D28D9;
        padding: 0.4rem 1.2rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .book-category:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.4);
    }

    .btn-detail {
        background: rgba(255, 255, 255, 0.95);
        color: #6D28D9;
        text-decoration: none;
        padding: 0.8rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 700;
        text-shadow: none;
        letter-spacing: 0.5px;
        text-align: center;
        transition: all 0.3s ease;
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-detail i {
        font-size: 1rem;
    }

    /* Hover Effects */
    .book-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 30px rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .book-card:hover .book-cover img {
        transform: scale(1.1);
    }

    .btn-detail:hover {
        background: white;
        color: #D946EF;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .book-cover {
            height: 220px;
        }

        .book-info {
            padding: 1rem;
            gap: 0.6rem;
        }

        .book-title {
            font-size: 0.9rem;
        }

        .book-author {
            font-size: 0.8rem;
        }

        .btn-detail {
            padding: 0.5rem;
            font-size: 0.85rem;
        }
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
    }

    footer p {
        margin: 0;
        color: rgba(255, 255, 255, 0.9);
    }

    footer .text-primary {
        color: #EC4899 !important;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .main-wrapper {
            padding: 5rem 0.5rem 1rem;
        }

        .filter-search-section {
            padding: 1rem;
            margin: 0 0.5rem 1rem;
        }

        .books-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            padding: 0.5rem;
        }

        .book-cover {
            height: 200px;
        }

        .book-info {
            padding: 0.8rem;
        }

        .btn-filter {
            min-width: 90px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }
    }

    /* Add glow effects */
    .book-title {
        text-shadow: 0 0 10px rgba(167, 139, 250, 0.5);
    }

    .filter-search-section {
        position: relative;
    }

    .filter-search-section::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, 
            rgba(124, 58, 237, 0.8),
            rgba(217, 70, 239, 0.8),
            rgba(236, 72, 153, 0.8)
        );
        border-radius: 22px;
        z-index: -1;
        filter: blur(10px);
        opacity: 0.5;
    }

    /* Add animation for hover effects */
    @keyframes glowPulse {
        0% {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
        50% {
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3);
        }
        100% {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
    }

    .book-card:hover {
        animation: glowPulse 2s infinite;
    }

    /* Update navbar style */
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

    /* Add gradient animation */
    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Add white shimmer effect */
    .book-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        transition: 0.5s;
    }

    .book-card:hover::before {
        left: 100%;
    }

    /* Update icon colors */
    .btn-detail i,
    .search-button i {
        color: inherit;
    }
  </style>
  <body>
    <nav class="navbar fixed-top shadow-sm">
      <div class="container-fluid p-3">
        <a class="navbar-brand" href="#">
          <img src="../../assets/logoNav.png" alt="logo" width="120px">
        </a>
        <a class="btn btn-primary" href="../dashboardMember.php">Dashboard</a>
      </div>
    </nav>
    
     <div class="main-wrapper">
       <div class="filter-search-section">
         <!-- Filter buttons -->
         <div class="filter-buttons">
           <form action="" method="post" class="d-flex gap-2 flex-wrap justify-content-center">
               <button class="btn-filter active" type="submit">Semua</button>
               <button type="submit" name="informatika" class="btn-filter">Informatika</button>
               <button type="submit" name="bisnis" class="btn-filter">Bisnis</button>
               <button type="submit" name="filsafat" class="btn-filter">Filsafat</button>
               <button type="submit" name="novel" class="btn-filter">Novel</button>
               <button type="submit" name="sains" class="btn-filter">Sains</button>
           </form>
         </div>

         <!-- Search box -->
         <div class="search-container">
           <form action="" method="post">
               <div class="search-box">
                   <input type="text" 
                          name="keyword" 
                          class="search-input" 
                          placeholder="Cari judul buku atau kategori..."
                          autocomplete="off">
                   <button type="submit" name="search" class="search-button">
                       <i class="fa-solid fa-magnifying-glass"></i>
                       <span>Cari</span>
                   </button>
               </div>
           </form>
         </div>
       </div>

       <!-- Books grid -->
       <div class="books-grid">
           <?php foreach ($buku as $item) : ?>
           <div class="book-card">
               <div class="book-cover">
                   <img src="../../imgDB/<?= $item["cover"]; ?>" alt="<?= $item["judul"]; ?>">
               </div>
               <div class="book-info">
                   <h5 class="book-title"><?= $item["judul"]; ?></h5>
                   <p class="book-author">By <?= $item["pengarang"]; ?></p>
                   <span class="book-category"><?= $item["kategori"]; ?></span>
                   <a class="btn-detail" href="detailBuku.php?id=<?= $item["id_buku"]; ?>">
                       <i class="fas fa-info-circle"></i>
                       <span>Lihat Detail</span>
                   </a>
               </div>
           </div>
           <?php endforeach; ?>
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
