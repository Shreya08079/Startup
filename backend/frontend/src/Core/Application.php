<?php
namespace App\Core;

class Application
{
    private $router;
    private $controller;
    private $action;
    private $params;

    public function __construct()
    {
        $this->router = new Router();
        $this->setupRoutes();
        $this->parseUrl();
    }

    private function setupRoutes()
    {
        // Home routes
        $this->router->get('', 'HomeController', 'index');
        $this->router->get('/', 'HomeController', 'index');

        // About routes
        $this->router->get('about', 'AboutController', 'index');
        $this->router->get('about/', 'AboutController', 'index');

        // Auth routes
        $this->router->get('register', 'RegisterController', 'index');
        $this->router->post('register', 'RegisterController', 'process');
        $this->router->get('login', 'LoginController', 'index');
        $this->router->post('login', 'LoginController', 'process');
        $this->router->get('logout', 'LoginController', 'logout');

        // Dashboard routes
        $this->router->get('dashboard', 'DashboardController', 'index');
        $this->router->get('dashboard/profile', 'DashboardController', 'profile');
        $this->router->get('dashboard/settings', 'DashboardController', 'settings');

        // Asset routes
        $this->router->get('assets/:path', 'AssetsController', 'serve');
    }

    private function parseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        $route = $this->router->match($method, $url);
        
        if ($route) {
            $this->controller = $route['controller'];
            $this->action = $route['action'];
            $this->params = $route['params'] ?? [];
        } else {
            $this->controller = 'HomeController';
            $this->action = 'index';
            $this->params = [];
        }
    }

    public function run()
    {
        try {
            $controllerClass = "App\\Controllers\\{$this->controller}";
            
            if (!class_exists($controllerClass)) {
                throw new \Exception("Page not found", 404);
            }

            $controller = new $controllerClass();
            
            if (!method_exists($controller, $this->action)) {
                throw new \Exception("Page not found", 404);
            }

            call_user_func_array([$controller, $this->action], $this->params);
        } catch (\Exception $e) {
            // Let the error handler handle the exception
            throw $e;
        }
    }
} 