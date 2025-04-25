<?php
// Application configuration
define('APP_DEBUG', true);
define('APP_ENV', 'local');
define('APP_URL', 'http://localhost:8000');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'startup_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// API configuration
define('API_URL', 'http://localhost:8000/api');

// Session configuration
define('SESSION_LIFETIME', 7200); // 2 hours
define('SESSION_SECURE', false);
define('SESSION_HTTP_ONLY', true);
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
ini_set('session.cookie_lifetime', SESSION_LIFETIME);

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('UTC');

// Security
define('CSRF_TOKEN_SECRET', 'your-secret-key-here');
define('PASSWORD_HASH_COST', 12);

// File upload configuration
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'pdf']);
define('UPLOAD_DIR', ROOT_DIR . '/public/uploads');

// Cache configuration
define('CACHE_ENABLED', true);
define('CACHE_DIR', ROOT_DIR . '/cache');
define('CACHE_LIFETIME', 3600); // 1 hour 