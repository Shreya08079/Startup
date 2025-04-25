<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->render('home', [
            'title' => 'Welcome to Startup Connect'
        ]);
    }
} 