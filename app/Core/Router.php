<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $lang = 'en';

    public function get(string $pattern, string $handler): void
    {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post(string $pattern, string $handler): void
    {
        $this->addRoute('POST', $pattern, $handler);
    }

    private function addRoute(string $method, string $pattern, string $handler): void
    {
        $this->routes[] = compact('method', 'pattern', 'handler');
    }

    public function dispatch(string $url): void
    {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $url = trim($url, '/');
        $segments = $url ? explode('/', $url) : [];

        if (!empty($segments) && in_array($segments[0], $config['languages'])) {
            $this->lang = array_shift($segments);
            $_SESSION['lang'] = $this->lang;
        } elseif (empty($segments)) {
            $this->lang = $_SESSION['lang'] ?? $config['default_lang'];
        }

        $path = implode('/', $segments);

        if ($path === 'admin' || str_starts_with($path, 'admin/')) {
            $this->dispatchAdmin($path);
            return;
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
                continue;
            }

            $params = $this->match($route['pattern'], $path);
            if ($params !== false) {
                [$controllerName, $method] = explode('@', $route['handler']);
                $controllerClass = "App\\Controllers\\{$controllerName}";

                if (!class_exists($controllerClass)) {
                    $this->notFound();
                    return;
                }

                $controller = new $controllerClass();
                call_user_func_array([$controller, $method], $params);
                return;
            }
        }

        $this->notFound();
    }

    private function dispatchAdmin(string $path): void
    {
        $adminPath = $path === 'admin' ? '' : substr($path, 6);
        $segments = $adminPath ? explode('/', trim($adminPath, '/')) : [];
        $controller = $segments[0] ?? 'dashboard';
        $action = $segments[1] ?? 'index';
        $param = $segments[2] ?? null;

        $controllerMap = [
            'login' => 'AuthController',
            'logout' => 'AuthController',
            'dashboard' => 'DashboardController',
            'products' => 'ProductController',
            'categories' => 'CategoryController',
            'blogs' => 'BlogController',
            'faqs' => 'FaqController',
            'testimonials' => 'TestimonialController',
            'inquiries' => 'InquiryController',
            'dealer-inquiries' => 'DealerInquiryController',
            'banners' => 'BannerController',
            'manufacturing-process' => 'ManufacturingProcessController',
            'seo' => 'SeoController',
            'settings' => 'SettingController',
        ];

        $className = $controllerMap[$controller] ?? null;
        if (!$className) {
            $this->notFound();
            return;
        }

        $controllerClass = "App\\Controllers\\Admin\\{$className}";
        if (!class_exists($controllerClass)) {
            $this->notFound();
            return;
        }

        $instance = new $controllerClass();

        if ($controller === 'login') {
            $instance->login();
            return;
        }
        if ($controller === 'logout') {
            $instance->logout();
            return;
        }

        if (!isset($_SESSION['admin_id']) && $controller !== 'login') {
            header('Location: ' . rtrim(base_url(), '/') . '/admin/login');
            exit;
        }

        $methods = [
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'edit' => 'edit',
            'update' => 'update',
            'delete' => 'delete',
            'view' => 'show',
        ];

        $methodName = $methods[$action] ?? $action;
        if (!method_exists($instance, $methodName)) {
            $this->notFound();
            return;
        }

        if ($param !== null) {
            $instance->$methodName($param);
        } else {
            $instance->$methodName();
        }
    }

    /** @return array|false */
    private function match(string $pattern, string $path)
    {
        $pattern = trim($pattern, '/');
        $path = trim($path, '/');

        if ($pattern === '' && $path === '') {
            return [];
        }

        $patternParts = $pattern ? explode('/', $pattern) : [];
        $pathParts = $path ? explode('/', $path) : [];

        if (count($patternParts) !== count($pathParts)) {
            return false;
        }

        $params = [];
        foreach ($patternParts as $i => $part) {
            if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                $params[] = $pathParts[$i];
            } elseif ($part !== $pathParts[$i]) {
                return false;
            }
        }

        return $params;
    }

    private function notFound(): void
    {
        http_response_code(404);
        $controller = new \App\Controllers\HomeController();
        $controller->notFound();
    }
}
