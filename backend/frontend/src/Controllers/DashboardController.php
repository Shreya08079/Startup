<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Require login for all dashboard pages
        Auth::getInstance()->requireLogin();
    }

    public function index()
    {
        $user = Auth::getInstance()->getCurrentUser();
        
        $this->render('dashboard', [
            'title' => 'Dashboard - Startup Connect',
            'user' => $user
        ]);
    }

    public function profile()
    {
        $user = Auth::getInstance()->getCurrentUser();
        
        $this->render('dashboard/profile', [
            'title' => 'My Profile - Startup Connect',
            'user' => $user
        ]);
    }

    public function settings()
    {
        $user = Auth::getInstance()->getCurrentUser();
        
        $this->render('dashboard/settings', [
            'title' => 'Settings - Startup Connect',
            'user' => $user
        ]);
    }
} 