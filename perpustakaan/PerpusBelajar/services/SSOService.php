<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/sso_config.php';

class SSOService {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
    }
    
    public function generateToken($admin_id) {
        // Generate random token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', time() + SSO_TOKEN_LIFETIME);
        
        // Clean up expired tokens first
        $this->cleanupExpiredTokens();
        
        // Escape values for security
        $admin_id = mysqli_real_escape_string($this->connection, $admin_id);
        $token = mysqli_real_escape_string($this->connection, $token);
        $ip = mysqli_real_escape_string($this->connection, $_SERVER['REMOTE_ADDR']);
        $ua = mysqli_real_escape_string($this->connection, $_SERVER['HTTP_USER_AGENT']);
        
        // Insert new token
        $query = "INSERT INTO sso_sessions (user_id, token, expires_at, ip_address, user_agent) 
                  VALUES ('$admin_id', '$token', '$expires_at', '$ip', '$ua')";
                  
        if (!mysqli_query($this->connection, $query)) {
            throw new Exception("Failed to generate SSO token: " . mysqli_error($this->connection));
        }
        
        return $token;
    }
    
    private function cleanupExpiredTokens() {
        $query = "DELETE FROM sso_sessions WHERE expires_at < NOW()";
        mysqli_query($this->connection, $query);
    }
    
    public function validateToken($token) {
        $token = mysqli_real_escape_string($this->connection, $token);
        $query = "SELECT * FROM sso_sessions 
                  WHERE token = '$token' 
                  AND expires_at > NOW()";
                  
        $result = mysqli_query($this->connection, $query);
        return mysqli_num_rows($result) > 0;
    }
}