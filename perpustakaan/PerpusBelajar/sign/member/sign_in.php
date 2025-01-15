<?php 
session_start();

//Jika member sudah login, tidak boleh kembali ke halaman login ,kecuali logout
if(isset($_SESSION["signIn"]) ) {
  header("Location: ../../DashboardMember/dashboardMember.php");
  exit;
}

require "../../loginSystem/connect.php";

if(isset($_POST["signIn"]) ) {
  
  $nama = strtolower($_POST["nama"]);
  $nisn = $_POST["nisn"];
  $password = $_POST["password"];
  
  
  $result = mysqli_query($connect, "SELECT * FROM member WHERE nama = '$nama' AND nisn = $nisn");
  
  if(mysqli_num_rows($result) === 1) {
    //cek pw 
    $pw = mysqli_fetch_assoc($result);
    if(password_verify($password, $pw["password"]) ) {
      // SET SESSION 
      $_SESSION["signIn"] = true;
      $_SESSION["member"]["nama"] = $nama;
      $_SESSION["member"]["nisn"] = $nisn;
      header("Location: ../../DashboardMember/dashboardMember.php");
      exit;
    }
  }
  $error = true;
  
}
?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/de8de52639.js" crossorigin="anonymous"></script>
     <title>Sign In || Member</title>
    <style>
        :root {
            --primary-color: #A855F7;    /* Bright Purple */
            --accent-color: #EC4899;     /* Vibrant Pink */
            --third-color: #8B5CF6;      /* Deep Purple */
            --fourth-color: #D946EF;     /* Bright Pink */
            --light-purple: #E9D5FF;     /* Light Purple */
            --pink-light: #FCE7F3;       /* Light Pink */
            --white: #FFFFFF;
        }

        body {
            background: linear-gradient(
                135deg, 
                var(--third-color) 0%,
                var(--primary-color) 25%,
                var(--white) 50%,
                var(--fourth-color) 75%,
                var(--accent-color) 100%
            );
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(139, 92, 246, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(217, 70, 239, 0.4) 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.4) 0%, transparent 40%);
            pointer-events: none;
            z-index: -1;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 24px;
            padding: 2rem !important;
            box-shadow: 
                0 8px 32px rgba(168, 85, 247, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: none;
            max-width: 450px;
            width: 100%;
            margin: 0 auto;
        }

        .card img {
            filter: drop-shadow(0 4px 8px rgba(168, 85, 247, 0.3));
            transition: transform 0.3s ease;
        }

        .card img:hover {
            transform: scale(1.05);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(168, 85, 247, 0.2);
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s ease;
            color: #4B5563;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.15);
            background: white;
        }

        .input-group-text {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            color: white;
            border-radius: 12px 0 0 12px !important;
        }

        .form-label {
            color: var(--third-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--fourth-color), var(--accent-color));
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 
                0 8px 20px rgba(168, 85, 247, 0.3),
                0 0 0 2px rgba(168, 85, 247, 0.2);
            background: linear-gradient(135deg, var(--third-color), var(--primary-color), var(--fourth-color));
        }

        h1 {
            background: linear-gradient(135deg, var(--third-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700 !important;
            margin-bottom: 1rem;
        }

        hr {
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
            height: 2px;
            border: none;
            opacity: 0.2;
        }

        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            color: #EF4444;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .card {
                padding: 1.5rem !important;
            }

            .form-control, .btn-primary {
                padding: 10px;
            }

            h1 {
                font-size: 1.75rem;
            }
        }
    </style>
    </head>
  <body>
  <div class="container">
    <div class="card p-2 mt-5">
      <div class="position-absolute top-0 start-50 translate-middle">
        <img src="../../assets/memberLogo (2).png" alt="adminLogo" width="85px">
      </div>
      <h1 class="pt-5 text-center fw-bold">Sign In</h1>
      <hr>
    <form action="" method="post" class="row g-3 p-4 needs-validation" novalidate>
    <label for="validationCustom01" class="form-label">Nama Lengkap</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
    <input type="text" class="form-control" name="nama" id="validationCustom01" required>
    <div class="invalid-feedback">
        Masukkan nama anda!
    </div>
  </div>
    <label for="validationCustom01" class="form-label">Nisn</label>
  <div class="input-group mt-0">
    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-hashtag"></i></span>
    <input type="number" class="form-control" name="nisn" id="validationCustom01" required>
    <div class="invalid-feedback">
        Masukkan Nisn anda!
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
  <p>Don't have an account yet? <a href="sign_up.php" class="text-decoration-none text-primary">Sign Up</a></p>
</form>
</div>
<?php if(isset($error)) : ?>
      <div class="alert alert-danger mt-2" role="alert">Nama / Nisn / Password tidak sesuai !
      </div>
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