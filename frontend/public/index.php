<?php
require_once __DIR__ . '/../src/bootstrap.php';

// Initialize the application
$app = new \App\Core\Application();

// Handle the request
$app->run(); 