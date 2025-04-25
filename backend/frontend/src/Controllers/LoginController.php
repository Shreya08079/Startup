<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $this->render('login', [
            'title' => 'Login - Startup Connect'
        ]);
    }

    public function process()
    {
        if (!$this->isPost()) {
            $this->redirect('/login');
            return;
        }

        $email = $this->getPost('email');
        $password = $this->getPost('password');

        if (Auth::getInstance()->login($email, $password)) {
            $this->redirect('/dashboard');
        } else {
            Auth::getInstance()->setFlashMessage('error', 'Invalid email or password');
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        Auth::getInstance()->logout();
        $this->redirect('/');
    }
} 