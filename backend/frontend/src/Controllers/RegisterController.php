<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        $this->render('register', [
            'title' => 'Register - Startup Connect'
        ]);
    }

    public function process()
    {
        if (!$this->isPost()) {
            $this->redirect('/register');
            return;
        }

        $data = [
            'name' => $this->getPost('name'),
            'email' => $this->getPost('email'),
            'password' => $this->getPost('password'),
            'password_confirmation' => $this->getPost('password_confirmation'),
            'user_type' => $this->getPost('user_type')
        ];

        if (Auth::getInstance()->register($data)) {
            $this->redirect('/dashboard');
        } else {
            Auth::getInstance()->setFlashMessage('error', 'Registration failed. Please try again.');
            $this->redirect('/register');
        }
    }
} 