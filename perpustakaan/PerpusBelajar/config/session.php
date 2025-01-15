<?php
// Cek apakah session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gunakan require_once untuk config
require_once __DIR__ . '/config.php';

// Fungsi logging
function writeLog($message) {
    $logFile = __DIR__ . '/session_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

function checkLogin() {
    global $connection;

    writeLog("Checking login...");
    writeLog("Session data: " . print_r($_SESSION, true));
    writeLog("Cookie data: " . print_r($_COOKIE, true));

    // Pastikan koneksi database ada
    if (!$connection) {
        writeLog("Database connection failed");
        die("Database connection failed");
    }

    // Cek apakah ada session login langsung
    if(isset($_SESSION["signIn"])) {
        writeLog("Direct session found");
        return true;
    }

    // Cek apakah ada token di cookie
    if(isset($_COOKIE['sso_token'])) {
        $token = $_COOKIE['sso_token'];
        writeLog("SSO Token found in cookie: " . $token);
        
        // Verifikasi token di database
        $query = "SELECT * FROM sso_sessions 
                 WHERE token = ? 
                 AND is_active = 1 
                 AND expires_at > NOW()";
        
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if($session = mysqli_fetch_assoc($result)) {
            writeLog("Valid token found in database");
            
            // Update last_activity
            mysqli_query($connection, 
                "UPDATE sso_sessions 
                 SET last_activity = NOW() 
                 WHERE token = '$token'");
            
            // Set session login
            $_SESSION["signIn"] = 1;
            
            // Get admin data
            $admin_query = "SELECT * FROM admin WHERE id = ?";
            $stmt = mysqli_prepare($connection, $admin_query);
            mysqli_stmt_bind_param($stmt, "i", $session['user_id']);
            mysqli_stmt_execute($stmt);
            $admin_result = mysqli_stmt_get_result($stmt);
            
            if($admin = mysqli_fetch_assoc($admin_result)) {
                $_SESSION['admin'] = [
                    'id' => $admin['id'],
                    'nama' => $admin['nama_admin'],
                    'level' => 'admin',
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            
            writeLog("Session restored from token");
            return true;
        } else {
            writeLog("Token not found or expired");
            // Hapus cookie jika token tidak valid
            setcookie('sso_token', '', time() - 3600, '/');
        }
    }

    writeLog("No valid session found, redirecting to login");
    header("Location: /perpustakaan/PerpusBelajar/sign/admin/sign_in.php");
    exit;
}

function getBaseUrl() {
    return 'http://' . $_SERVER['HTTP_HOST'] . '/perpustakaan/PerpusBelajar';
}
?>