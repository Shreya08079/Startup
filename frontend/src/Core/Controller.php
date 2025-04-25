<?php
namespace App\Core;

class Controller
{
    protected function render($template, $data = [])
    {
        extract($data);
        
        ob_start();
        require_once ROOT_DIR . "/src/Views/{$template}.php";
        $content = ob_get_clean();
        
        if (strpos($template, 'layouts/') === 0) {
            echo $content;
        } else {
            require_once ROOT_DIR . '/src/Views/layouts/main.php';
        }
    }

    protected function renderPartial($template, $data = [])
    {
        extract($data);
        
        ob_start();
        require_once ROOT_DIR . "/src/Views/{$template}.php";
        return ob_get_clean();
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function getPost($key = null)
    {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? null;
    }

    protected function getQuery($key = null)
    {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }
} 