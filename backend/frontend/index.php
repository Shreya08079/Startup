<?php
session_start();

// Define base path for includes
define('BASE_PATH', __DIR__);

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($base_path, '', $request_uri);
$path = strtok($path, '?'); // Remove query parameters

// Basic routing
switch ($path) {
    case '/':
        $page = 'home';
        break;
    case '/about':
    case '/about.php':
        $page = 'about';
        break;
    case '/register':
    case '/register.php':
        $page = 'register';
        break;
    case '/login':
    case '/login.php':
        $page = 'login';
        break;
    case '/contact':
    case '/contact.php':
        $page = 'contact';
        break;
    case '/forgot-password':
    case '/forgot-password.php':
        $page = 'forgot-password';
        break;
    default:
        $page = '404';
        break;
}

// Include header
require_once BASE_PATH . '/includes/header.php';

// Include the requested page
$page_path = BASE_PATH . '/src/Views/' . $page . '.php';
if (file_exists($page_path)) {
    require_once $page_path;
} else {
    // 404 page
    require_once BASE_PATH . '/src/Views/404.php';
}

// Include footer
require_once BASE_PATH . '/includes/footer.php'; 