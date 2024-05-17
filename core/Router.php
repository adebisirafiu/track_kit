<?php
namespace App;

class Router {
    private $routes = [];

    public function add($route, $method, $callback) {
        $this->routes[] = ['route' => $route, 'method' => $method, 'callback' => $callback];
    }

    public function dispatch($request) {
        foreach ($this->routes as $route) {
            if ($route['route'] === $request->getPath() && $route['method'] === $request->getMethod()) {
                call_user_func($route['callback'], $request);
                return;
            }
        }
        http_response_code(404);
        echo "Not Found";
    }
}
