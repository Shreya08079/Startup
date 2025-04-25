<?php
// API Configuration
define('API_URL', 'http://localhost:8000/api'); // Change this to your actual API URL
define('APP_URL', 'http://localhost:3000'); // Change this to your frontend URL

// CORS Configuration
header('Access-Control-Allow-Origin: ' . APP_URL);
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// JWT Configuration
define('JWT_SECRET', 'your-secret-key'); // Change this to a secure secret key
define('JWT_EXPIRATION', 3600); // Token expiration time in seconds 