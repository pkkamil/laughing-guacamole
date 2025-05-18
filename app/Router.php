<?php

namespace App;

// External dependencies
use Exception;

class Router
{
    private static array $routes = [];
    private static array $currentMiddleware = [];

    public static function get(string $urlPattern, array|string $controller)
    {
        self::$routes['GET'][] = [
            'pattern' => $urlPattern,
            'controller' => $controller,
            'middleware' => self::$currentMiddleware
        ];
    }

    public static function post(string $urlPattern, array|string $controller)
    {
        self::$routes['POST'][] = [
            'pattern' => $urlPattern,
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
        $path = '/' . trim($url, '/');

        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $route) {
            $pattern = self::convertPatternToRegex($route['pattern'], $paramNames);

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove the full match from the array

                // Middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    if (!class_exists($middlewareClass)) {
                        throw new Exception("Middleware not found: $middlewareClass");
                    }
                    (new $middlewareClass())->handle();
                }

                // Controller and method
                [$controllerClass, $methodName] = is_array($route['controller'])
                    ? $route['controller']
                    : [$route['controller'], self::defaultMethodFromPath($path)];

                if (!class_exists($controllerClass)) {
                    throw new Exception("Controller not found: $controllerClass");
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $methodName)) {
                    throw new Exception("Method '$methodName' not found in $controllerClass");
                }

                return $controller->$methodName(...$matches);
            }
        }

        // Fallback
        $fallback = new \App\Http\Modules\Home\Controller();
        $fallback->index();
    }

    private static function convertPatternToRegex(string $pattern, &$paramNames = []): string
    {
        $regex = preg_replace_callback('/{(\w+)}/', function ($matches) use (&$paramNames) {
            $paramNames[] = $matches[1];
            return '([^\/]+)';
        }, $pattern);

        return '#^' . $regex . '$#';
    }

    private static function defaultMethodFromPath(string $path): string
    {
        $segments = explode('/', trim($path, '/'));
        return end($segments) ?: 'index';
    }
}
