<?php
// SSO Configuration
define('SSO_ENABLED', true);
define('SSO_TOKEN_LIFETIME', 3600); // 1 jam dalam detik
define('SSO_COOKIE_NAME', 'sso_token');
define('SSO_COOKIE_PATH', '/');
define('SSO_COOKIE_DOMAIN', '');  // kosong untuk localhost
define('SSO_COOKIE_SECURE', false);  // true jika HTTPS
define('SSO_COOKIE_HTTPONLY', true);

// URL Configuration
define('SLIMS_URL', 'http://localhost/slims9');
define('PERPUS_URL', 'http://localhost/perpustakaan/PerpusBelajar');

// Database Configuration
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'perpustakaan');

// SSO Table
define('SSO_TABLE', 'sso_sessions');
?>