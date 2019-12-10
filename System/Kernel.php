<?php


namespace System;


class Kernel
{
    static $currentRouteMatches;


    public function handle()
    {
        $this->handleConsoleIfCliRunning();

        foreach ($this->routes() as $pattern => $action) {
            if ($this->isMatch($pattern)) {
                return $this->runAction($action);
            };
        }

        return 'ERROR. No match route.';
    }

    private function routes()
    {
        return require dirname(__DIR__).'/routes.php';
    }

    private function runAction($action)
    {
        [$controller, $method] = explode('@', $action);
        $controller = 'Controllers\\'.$controller; // create new Controller

        return call_user_func_array([new $controller, $method], array_values($this->currentRouteParams())); // exec controller method
    }

    private function isMatch($pattern)
    {
        $currentPath = $_SERVER['PATH_INFO'] ?? '/';

        [$method, $rawPattern] = explode(' ', $pattern);

        if ($method !== $_SERVER['REQUEST_METHOD']) {
            return false;
        }

        $compiledPattern = preg_replace('#{([a-zA-Z0-9_\-]+)}#', '(?<$1>[a-zA-Z0-9_\-]*)', $rawPattern);

        return preg_match("#^{$compiledPattern}$#", $currentPath, static::$currentRouteMatches);
    }

    private function currentRouteParams()
    {
        $routeParams = [];
        foreach (static::$currentRouteMatches as $key => $value) {
            if (is_string($key))
                $routeParams[$key] = $value; // filter only string keys - this result preg_match(...)
        }

        return $routeParams;
    }

    private function handleConsoleIfCliRunning()
    {
        if (php_sapi_name() === 'cli') {
            (new Console)->handle();
            exit;
        }
    }
}
