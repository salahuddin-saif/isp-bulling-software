<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, callable|array $handler): void
    {
        $this->routes['GET'][] = $this->compile($path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes['POST'][] = $this->compile($path, $handler);
    }

    public function dispatch(string $method, string $path): void
    {
        $method = strtoupper($method);
        $path = $this->normalize($path);
        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['regex'], $path, $matches)) {
                $params = [];
                foreach ($route['params'] as $index => $name) {
                    $params[] = $this->cast($matches[$index + 1] ?? null);
                }
                $handler = $route['handler'];
                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    $controller->$action(...$params);
                    return;
                }
                $handler(...$params);
                return;
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }

    private function compile(string $path, callable|array $handler): array
    {
        $path = $this->normalize($path);
        $paramNames = [];
        $regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', function ($m) use (&$paramNames) {
            $paramNames[] = $m[1];
            return '([\\w-]+)';
        }, $path);
        $regex = '#^' . $regex . '$#';
        return [
            'regex' => $regex,
            'params' => $paramNames,
            'handler' => $handler,
        ];
    }

    private function normalize(string $path): string
    {
        if ($path === '') {
            return '/';
        }
        return rtrim($path, '/') ?: '/';
    }

    private function cast($value)
    {
        if (is_string($value) && ctype_digit($value)) {
            return (int)$value;
        }
        return $value;
    }
}


