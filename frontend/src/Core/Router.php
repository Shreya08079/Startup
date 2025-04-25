<?php
namespace App\Core;

class Router
{
    private $routes = [];

    public function add($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get($path, $controller, $action)
    {
        $this->add('GET', $path, $controller, $action);
    }

    public function post($path, $controller, $action)
    {
        $this->add('POST', $path, $controller, $action);
    }

    public function match($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                return $route;
            }
        }
        return null;
    }

    private function matchPath($routePath, $requestPath)
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        $params = [];
        foreach ($routeParts as $index => $routePart) {
            if (strpos($routePart, ':') === 0) {
                $paramName = substr($routePart, 1);
                $params[$paramName] = $requestParts[$index];
                continue;
            }
            if ($routePart !== $requestParts[$index]) {
                return false;
            }
        }

        if (!empty($params)) {
            $this->routes[count($this->routes) - 1]['params'] = $params;
        }

        return true;
    }
} 