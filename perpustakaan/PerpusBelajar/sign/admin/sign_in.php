<?php
session_start();
require_once '../../config/config.php';
require_once '../../services/SSOService.php';

// Debug untuk melihat error
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SESSION["signIn"]) ) {
    header("Location: ../../DashboardAdmin/dashboardAdmin.php");
    exit;
}

if(isset($_POST["signIn"]) ) {
    $nama = trim(strtolower($_POST["nama"])); // Tambahkan trim() untuk membersihkan spasi
    $password = trim($_POST["password"]);
    
    // Debug
    error_log("Login attempt for user: " . $nama);
    
    // Tambahkan validasi input
    if(empty($nama) || empty($password)) {
        $error = "Nama dan password harus diisi!";
    } else {
        $result = mysqli_query($connection, "SELECT * FROM admin WHERE nama_admin = '" . mysqli_real_escape_string($connection, $nama) . "'");
        
        if(!$result) {
            error_log("MySQL Error: " . mysqli_error($connection));
            $error = "Terjadi kesalahan database";
        } else if(mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            if($password === $row["password"]) {
                // Set session
                $_SESSION["signIn"] = true;
                $_SESSION["admin"] = [
                    'id' => $row['id'],
                    'id_admin' => $row['id_admin'] ?? '',
                    'nama' => $row['nama_admin'],
                    'username' => $row['username'] ?? '',
                    'email' => $row['email'] ?? '',
                    'level' => $row['level'] ?? 'admin',
                    'created_at' => $row['created_at'] ?? date('Y-m-d H:i:s')
                ];
                
                try {
                    // Generate SSO token
                    $ssoService = new SSOService($connection);
                    $token = $ssoService->generateToken($row['id']);
                    
                    // Set SSO cookie
                    setcookie(
                        SSO_COOKIE_NAME,
                        $token,
                        time() + SSO_TOKEN_LIFETIME,
                        SSO_COOKIE_PATH,
                        SSO_COOKIE_DOMAIN,
                        SSO_COOKIE_SECURE,
                        SSO_COOKIE_HTTPONLY
                    );
                    
                    // Debug
                    error_log("Login successful for user: " . $nama);
                    
                    header("Location: ../../DashboardAdmin/dashboardAdmin.php");
                    exit;
                } catch (Exception $e) {
                    error_log("SSO Error: " . $e->getMessage());
                    $error = "Gagal membuat sesi login: " . $e->getMessage();
                }
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}

// Tambahkan ini di bagian HTML untuk menampilkan error lebih detail
if(isset($error)) {
    echo "<div class='alert alert-danger mt-2' role='alert'>Error: $error</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
    <title>Sign In || Admin</title>
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

        /* Card Container */
        .card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* Title Styles */
        .card h1 {
            color: #6D28D9;
            text-shadow: none;
            font-weight: 700;
        }

        /* Form Label */
        .form-label {
            color: #6D28D9;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Input Group */
        .input-group-text {
            background: rgba(124, 58, 237, 0.1);
            border: 2px solid rgba(124, 58, 237, 0.2);
            color: #6D28D9;
            border-radius: 12px 0 0 12px;
        }

        .form-control {
            background: rgba(124, 58, 237, 0.05);
            border: 2px solid rgba(124, 58, 237, 0.2);
            color: #6D28D9;
            font-weight: 500;
            border-radius: 0 12px 12px 0;
        }

        .form-control:focus {
            background: rgba(124, 58, 237, 0.1);
            border-color: rgba(124, 58, 237, 0.4);
            box-shadow: 0 0 20px rgba(124, 58, 237, 0.2);
            color: #6D28D9;
        }

        .form-control::placeholder {
            color: rgba(109, 40, 217, 0.6);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, #7C3AED, #D946EF) !important;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
            color: white !important;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.5);
        }

        .btn-success {
            background: linear-gradient(45deg, #D946EF, #EC4899) !important;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(217, 70, 239, 0.3);
            color: white !important;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(217, 70, 239, 0.5);
        }

        /* Alert */
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #EF4444;
            backdrop-filter: blur(12px);
        }

        /* Logo Animation */
        .position-absolute img {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Divider */
        hr {
            border-color: rgba(124, 58, 237, 0.2);
            margin: 1.5rem 0;
        }

        /* Invalid Feedback */
        .invalid-feedback {
            color: #EF4444;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        /* Hover Effects */
        .input-group:hover .input-group-text,
        .input-group:hover .form-control {
            border-color: rgba(124, 58, 237, 0.4);
        }

        /* Animation */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>
  <div class="container">
    <div class="card p-2 mt-5">
      <div class="position-absolute top-0 start-50 translate-middle">
        <img src="../../assets/adminLogo (2).png" class="" alt="adminLogo" width="85px">
      </div>
      <h1 class="pt-5 text-center fw-bold">Sign In</h1>
      <hr>
    <form action="" method="post" class="row g-3 p-4 needs-validation" novalidate>
    <label for="validationCustom01" class="form-label">Nama Lengkap</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
    <input type="text" class="form-control" name="nama" id="validationCustom01" required>
    <div class="invalid-feedback">
        Masukkan Nama anda!
    </div>
    </div>
  <label for="validationCustom02" class="form-label">Password</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
    <input type="password" class="form-control" id="validationCustom02" name="password" required>
    <div class="invalid-feedback">
        Masukkan Password anda!
    </div>
    </div>
  <div class="col-12">
    <button class="btn btn-primary" type="submit" name="signIn">Sign In</button>
    <a class="btn btn-success" href="../link_login.html">Batal</a>
  </div>
    </form>
</div>
<?php if(isset($error)) : ?>
    <div class="alert alert-danger mt-2" role="alert">Nama atau Password Salah!</div>
<?php endif; ?>
    </div>

  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>