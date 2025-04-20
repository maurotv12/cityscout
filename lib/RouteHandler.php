<?php

namespace Lib;

class RouteHandler
{
    private $method;
    private $uri;

    public function __construct($method, $uri)
    {
        $this->method = $method;
        $this->uri = trim($uri, '/');
    }

    public function middleware(array $middlewareList)
    {
        Route::addMiddleware($this->method, $this->uri, $middlewareList);
        return $this; // permite encadenamiento
    }
}
