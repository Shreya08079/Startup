<?php
namespace App\Core;

use App\Models\User;
use App\Core\ApiClient;

class Auth
{
    private static $instance = null;
    private $user;
    private $apiClient;

    private function __construct()
    {
        $this->apiClient = new ApiClient();
        if (isset($_SESSION['user_id'])) {
            $this->user = $_SESSION['user'];
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function login($email, $password)
    {
        try {
            $response = $this->apiClient->post('/auth/login', [
                'email' => $email,
                'password' => $password
            ]);

            if ($response['success']) {
                $this->user = $response['data']['user'];
                $this->apiClient->setToken($response['data']['token']);
                $_SESSION['user_id'] = $this->user['id'];
                $_SESSION['user'] = $this->user;
                return true;
            }
        } catch (\Exception $e) {
            error_log('Login error: ' . $e->getMessage());
        }
        return false;
    }

    public function register($data)
    {
        try {
            $response = $this->apiClient->post('/auth/register', $data);

            if ($response['success']) {
                $this->user = $response['data']['user'];
                $this->apiClient->setToken($response['data']['token']);
                $_SESSION['user_id'] = $this->user['id'];
                $_SESSION['user'] = $this->user;
                return true;
            }
        } catch (\Exception $e) {
            error_log('Registration error: ' . $e->getMessage());
        }
        return false;
    }

    public function logout()
    {
        try {
            $this->apiClient->post('/auth/logout');
        } catch (\Exception $e) {
            error_log('Logout error: ' . $e->getMessage());
        }

        unset($_SESSION['user_id']);
        unset($_SESSION['user']);
        $this->user = null;
        $this->apiClient->setToken(null);
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser()
    {
        return $this->user;
    }

    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $this->setFlashMessage('error', 'Please login to access this page');
            header('Location: /login');
            exit;
        }
    }

    public function requireGuest()
    {
        if ($this->isLoggedIn()) {
            header('Location: /dashboard');
            exit;
        }
    }

    public function generateCsrfToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public function regenerateSession()
    {
        session_regenerate_id(true);
    }

    public function setFlashMessage($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public function getFlashMessage()
    {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserId()
    {
        return $this->user['id'] ?? null;
    }
} 