<?php
namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $content = $this->renderPartial('about', [
            'title' => 'About Us - Startup Connect'
        ]);

        $this->render('layouts/main', [
            'title' => 'About Us - Startup Connect',
            'content' => $content
        ]);
    }
} 