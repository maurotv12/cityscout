<?php

namespace Lib;

class Route
{
    private static $routes = [];

    public static function get($uri, $callback)
    {
        return self::addRoute('GET', $uri, $callback);
    }

    public static function post($uri, $callback)
    {
        return self::addRoute('POST', $uri, $callback);
    }

    public static function delete($uri, $callback)
    {
        return self::addRoute('DELETE', $uri, $callback);
    }

    private static function addRoute($method, $uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$routes[$method][$uri] = [
            'callback' => $callback,
            'middleware' => []
        ];

        return new RouteHandler($method, $uri);
    }

    public static function addMiddleware($method, $uri, array $middlewareList)
    {
        self::$routes[$method][$uri]['middleware'] = $middlewareList;
    }

    public static function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes[$method] as $route => $config) {
            $pattern = preg_replace("#:[a-zA-Z_]+#", "([a-zA-Z0-9_]+)", $route);

            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);
                $callback = $config['callback'];

                foreach ($config['middleware'] as $middleware) {
                    (new $middleware)->handle();
                }

                if (is_callable($callback)) {
                    $response = $callback(...$matches);
                } elseif (is_array($callback)) {
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$matches);
                }

                if (is_array($response) || is_object($response)) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    echo $response;
                }

                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
