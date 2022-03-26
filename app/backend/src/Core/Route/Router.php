<?php

namespace Nathan\Kabum\Core\Route;

use Nathan\Kabum\Core\Application;

class Router
{
    private array $middlewares = [];

    private array $routes = [];

    public function __construct(private Application $app)
    {
    }

    public function registerMiddleware(string $name, callable|string $callback): void
    {
        $this->middlewares[$name] = $callback;
    }

    public function get(string $pattern, callable|string $callback, $middlewares = []): void
    {
        $this->method('get', $pattern, $callback, $middlewares);
    }

    public function post(string $pattern, callable|string $callback, $middlewares = []): void
    {
        $this->method('post', $pattern, $callback, $middlewares);
    }

    public function delete(string $pattern, callable|string $callback, $middlewares = []): void
    {
        $this->method('delete', $pattern, $callback, $middlewares);
    }

    private function method($method, $pattern, callable|string $callback, $middlewares = []): void
    {
        $this->routes[$method][$pattern] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    private function handle($path, $routes): void
    {
        foreach ($routes as $pattern => $data) {

            // Ref: https://github.com/bramus/router/blob/55657b76da8a0a509250fb55b9dd24e1aa237eba/src/Bramus/Router/Router.php#L389
            $p = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
            $matched = boolval(preg_match_all('#^' . $p . '$#', $path, $matches, PREG_OFFSET_CAPTURE));

            if ($matched) {

                $matches = array_slice($matches, 1);

                foreach ($matches as $el) {
                    if (str_contains($el[0][0], '/')) {
                        continue 2;
                    }
                }

                $params = array_map(function ($match, $index) use ($matches) {
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        if ($matches[$index + 1][0][1] > -1) {
                            return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                        }
                    }

                    return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                $params = [$this->app, ...$params];

                [
                    'callback' => $callback,
                    'middlewares' => $middlewares
                ] = $data;

                foreach ($middlewares as $middleware) {
                    $middleware = $this->middlewares[$middleware];

                    $this->executeCallback($middleware, [$this->app]);
                }

                $this->executeCallback($callback, $params);

                exit(0);
            }
        }

        $this->app->request->response([
            "error" => "not found",
            "code" => 404
        ], 404);
    }

    private function executeCallback(callable|string $callback, array $params = [])
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } else {
            list($class, $method) = explode('::', $callback);
            $classPath = 'Nathan\\Kabum\\' . $class;

            call_user_func_array([new $classPath(), $method], $params);
        }
    }

    public function start(): void
    {
        $path = $this->app->request->getPath();
        $method = $this->app->request->getMethod();

        $this->handle($path, $this->routes[$method]);
    }
}
