<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;

class AuthController extends Controller
{
    private $auth;
    private $userModel;

    public function __construct()
    {
        $this->auth = Auth::getInstance();
        $this->userModel = new User();
    }

    public function login()
    {
        $this->auth->requireGuest();

        if ($this->isPost()) {
            $email = $this->getPost('email');
            $password = $this->getPost('password');
            $remember = $this->getPost('remember') === 'on';

            if (!$this->auth->validateCsrfToken($this->getPost('csrf_token'))) {
                $this->auth->setFlashMessage('danger', 'Invalid request.');
                $this->redirect('/login');
            }

            if ($this->auth->login($email, $password)) {
                if ($remember) {
                    // Set remember me cookie
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                    
                    // Store token in database
                    $this->userModel->update($this->auth->getUserId(), [
                        'remember_token' => $token
                    ]);
                }

                $this->auth->setFlashMessage('success', 'Welcome back!');
                $this->redirect('/dashboard');
            } else {
                $this->auth->setFlashMessage('danger', 'Invalid email or password.');
                $this->redirect('/login');
            }
        }

        $this->render('login');
    }

    public function register()
    {
        $this->auth->requireGuest();

        if ($this->isPost()) {
            $data = [
                'name' => $this->getPost('name'),
                'email' => $this->getPost('email'),
                'password' => $this->getPost('password'),
                'company_type' => $this->getPost('company_type'),
                'company_name' => $this->getPost('company_name')
            ];

            if (!$this->auth->validateCsrfToken($this->getPost('csrf_token'))) {
                $this->auth->setFlashMessage('danger', 'Invalid request.');
                $this->redirect('/register');
            }

            // Validate input
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                $this->auth->setFlashMessage('danger', 'All fields are required.');
                $this->redirect('/register');
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->auth->setFlashMessage('danger', 'Invalid email format.');
                $this->redirect('/register');
            }

            if (strlen($data['password']) < 8) {
                $this->auth->setFlashMessage('danger', 'Password must be at least 8 characters long.');
                $this->redirect('/register');
            }

            // Check if email already exists
            if ($this->userModel->findByEmail($data['email'])) {
                $this->auth->setFlashMessage('danger', 'Email already registered.');
                $this->redirect('/register');
            }

            // Create user
            $userId = $this->userModel->create($data);

            if ($userId) {
                $this->auth->setFlashMessage('success', 'Registration successful! Please login.');
                $this->redirect('/login');
            } else {
                $this->auth->setFlashMessage('danger', 'Registration failed. Please try again.');
                $this->redirect('/register');
            }
        }

        $this->render('register');
    }

    public function logout()
    {
        $this->auth->logout();
        $this->auth->setFlashMessage('success', 'You have been logged out.');
        $this->redirect('/login');
    }

    public function forgotPassword()
    {
        $this->auth->requireGuest();

        if ($this->isPost()) {
            $email = $this->getPost('email');

            if (!$this->auth->validateCsrfToken($this->getPost('csrf_token'))) {
                $this->auth->setFlashMessage('danger', 'Invalid request.');
                $this->redirect('/forgot-password');
            }

            $user = $this->userModel->findByEmail($email);

            if ($user) {
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $this->userModel->update($user['id'], [
                    'reset_token' => $token,
                    'reset_token_expires' => $expires
                ]);

                // Send reset email
                // TODO: Implement email sending

                $this->auth->setFlashMessage('success', 'Password reset instructions have been sent to your email.');
                $this->redirect('/login');
            } else {
                $this->auth->setFlashMessage('danger', 'Email not found.');
                $this->redirect('/forgot-password');
            }
        }

        $this->render('forgot-password');
    }

    public function resetPassword($token)
    {
        $this->auth->requireGuest();

        $user = $this->userModel->findByResetToken($token);

        if (!$user || strtotime($user['reset_token_expires']) < time()) {
            $this->auth->setFlashMessage('danger', 'Invalid or expired reset token.');
            $this->redirect('/login');
        }

        if ($this->isPost()) {
            $password = $this->getPost('password');
            $confirmPassword = $this->getPost('confirm_password');

            if (!$this->auth->validateCsrfToken($this->getPost('csrf_token'))) {
                $this->auth->setFlashMessage('danger', 'Invalid request.');
                $this->redirect('/reset-password/' . $token);
            }

            if ($password !== $confirmPassword) {
                $this->auth->setFlashMessage('danger', 'Passwords do not match.');
                $this->redirect('/reset-password/' . $token);
            }

            if (strlen($password) < 8) {
                $this->auth->setFlashMessage('danger', 'Password must be at least 8 characters long.');
                $this->redirect('/reset-password/' . $token);
            }

            $this->userModel->update($user['id'], [
                'password' => $password,
                'reset_token' => null,
                'reset_token_expires' => null
            ]);

            $this->auth->setFlashMessage('success', 'Password has been reset. Please login with your new password.');
            $this->redirect('/login');
        }

        $this->render('reset-password', ['token' => $token]);
    }
} 