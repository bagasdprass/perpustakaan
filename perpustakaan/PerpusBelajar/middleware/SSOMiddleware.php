<?php
class SSOMiddleware {
    private $ssoService;
    
    public function __construct(SSOService $ssoService) {
        $this->ssoService = $ssoService;
    }
    
    public function handle() {
        $token = $_COOKIE[SSO_COOKIE_NAME] ?? null;
        
        if (!$token) {
            return $this->redirectToLogin();
        }
        
        $session = $this->ssoService->validateToken($token);
        
        if (!$session) {
            $this->clearSSOCookie();
            return $this->redirectToLogin();
        }
        
        $this->ssoService->updateActivity($token);
        return $session;
    }
    
    private function clearSSOCookie() {
        setcookie(SSO_COOKIE_NAME, '', time() - 3600, SSO_COOKIE_PATH, 
                 SSO_COOKIE_DOMAIN, SSO_COOKIE_SECURE, SSO_COOKIE_HTTPONLY);
    }
    
    private function redirectToLogin() {
        header('Location: /perpustakaan/PerpusBelajar/sign/admin/sign_in.php');
        exit;
    }
}