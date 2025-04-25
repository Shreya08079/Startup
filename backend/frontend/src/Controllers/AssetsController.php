<?php
namespace App\Controllers;

use App\Core\Controller;

class AssetsController extends Controller
{
    private $allowedExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico'];
    private $contentTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon'
    ];

    public function serve($path)
    {
        $filePath = ROOT_DIR . '/public/assets/' . $path;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // Check if file exists and extension is allowed
        if (!file_exists($filePath) || !in_array($extension, $this->allowedExtensions)) {
            http_response_code(404);
            return;
        }

        // Set content type
        if (isset($this->contentTypes[$extension])) {
            header('Content-Type: ' . $this->contentTypes[$extension]);
        }

        // Serve file
        readfile($filePath);
    }
} 