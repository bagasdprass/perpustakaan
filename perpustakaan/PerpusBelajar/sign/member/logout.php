<?php
session_start();
require "../../config/config.php";

// Clear SSO session
if (isset($_COOKIE['sso_token'])) {
    $token = $_COOKIE['sso_token'];
    
    // Nonaktifkan token
    $query = "UPDATE sso_sessions SET is_active = 0 WHERE token = '$token'";
    mysqli_query($connection, $query);
    
    // Hapus cookie
    setcookie('sso_token', '', time() - 3600, '/');
}

// Clear session PerpusBelajar
session_destroy();
header("Location: ../link_login.html");
exit;
?>