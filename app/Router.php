<?php

namespace App;

// External dependencies
use Exception;

class Router
{
    private static array $routes = [];
    private static array $currentMiddleware = [];

    public static function get(string $url, string $controller)
    {
        self::$routes['GET'][$url] = [
            'controller' => $controller,
            'middleware' => self::$currentMiddleware
        ];
    }

    public static function post(string $url, string $controller)
    {
        self::$routes['POST'][$url] = [
            'controller' => $controller,
            'middleware' => self::$currentMiddleware
        ];
    }

    public static function group(array $options, callable $callback)
    {
        $previousMiddleware = self::$currentMiddleware;

        if (isset($options['middleware'])) {
            self::$currentMiddleware = is_array($options['middleware'])
                ? $options['middleware']
                : [$options['middleware']];
        }

        $callback();

        self::$currentMiddleware = $previousMiddleware;
    }

    public static function run(string $url)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $urlParts = explode("/", $url);
        $action = $urlParts[0] ?: 'index';
        $id = $urlParts[1] ?? '';

        $route = self::$routes[$method][$action] ?? null;

        if (!$route) {
            $controller = new \App\Http\Modules\Home\Controller();
            $controller->index();
            return;
        }

        // Middleware execution
        foreach ($route['middleware'] as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                throw new Exception("Middleware not found: $middlewareClass");
            }

            $middleware = new $middlewareClass();
            $middleware->handle();
        }

        $controllerClass = $route['controller'];
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller not found: $controllerClass");
        }

        $controller = new $controllerClass();
        $controller->$action($id);
    }
}
