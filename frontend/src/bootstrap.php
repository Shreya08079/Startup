<?php
// Define the application root directory
define('ROOT_DIR', dirname(__DIR__));

// Load configuration
require_once ROOT_DIR . '/config/config.php';

// Autoload classes
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $file = ROOT_DIR . '/src/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    } else {
        error_log("Class file not found: " . $file);
    }
});

// Start session
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Disable display_errors in production

// Set timezone
date_default_timezone_set('UTC');

// Register error handlers
set_error_handler([App\Core\ErrorHandler::class, 'handleError']);
set_exception_handler([App\Core\ErrorHandler::class, 'handleException']);

// Create logs directory if it doesn't exist
if (!file_exists(ROOT_DIR . '/logs')) {
    mkdir(ROOT_DIR . '/logs', 0777, true);
} 