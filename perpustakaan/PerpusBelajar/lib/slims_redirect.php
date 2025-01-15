<?php
session_start();

// Buat fungsi logging
function writeLog($message) {
    $logFile = __DIR__ . '/sso_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

try {
    // Generate token
    $token = bin2hex(random_bytes(32));
    writeLog("Generated token: " . $token);
    
    // Koneksi ke database
    require_once __DIR__ . '/../config/config.php';
    
    // Simpan token ke database
    $stmt = mysqli_prepare($connection, "INSERT INTO sso_sessions 
        (user_id, token, ip_address, user_agent, is_active, created_at, expires_at, last_activity) 
        VALUES (?, ?, ?, ?, 1, NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY), NOW())");
        
    mysqli_stmt_bind_param($stmt, "isss", 
        $_SESSION['admin']['id'],
        $token,
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    $result = mysqli_stmt_execute($stmt);
    writeLog("Token saved to database: " . ($result ? "success" : "failed"));

    // Simpan token di cookie (1 hari)
    setcookie('sso_token', $token, time() + (86400), '/', '', false, true);
    writeLog("Token saved to cookie: " . $token);

    // Redirect ke SLIMS dengan token
    header("Location: http://localhost/slims9/lib/sso_handler.php?token=" . $token);
    exit;
    
} catch (Exception $e) {
    writeLog("Error: " . $e->getMessage());
    error_log("SSO Error: " . $e->getMessage());
    header("Location: ../DashboardAdmin/dashboardAdmin.php?error=sso_failed");
    exit;
}
?>
