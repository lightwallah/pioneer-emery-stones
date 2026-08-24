<?php

namespace App\Core;

class Controller
{
    protected string $lang = 'en';
    protected array $config;
    protected array $translations = [];

    public function __construct()
    {
        $this->config = app_config();
        $this->lang = $_SESSION['lang'] ?? $this->config['default_lang'];
        $this->translations = require dirname(__DIR__, 2) . '/lang/' . $this->lang . '.php';
    }

    protected function view(string $view, array $data = [], ?string $layout = 'main'): void
    {
        $data['lang'] = $this->lang;
        $data['config'] = $this->config;
        $data['t'] = $this->translations;
        $data['baseUrl'] = rtrim($this->config['url'], '/');
        $data['langUrl'] = $data['baseUrl'] . '/' . $this->lang;

        extract($data);

        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "View not found: {$view}";
            return;
        }

        if ($layout) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
            require dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
        } else {
            require $viewFile;
        }
    }

    protected function adminView(string $view, array $data = []): void
    {
        $data['config'] = $this->config;
        $data['baseUrl'] = rtrim($this->config['url'], '/');
        extract($data);

        ob_start();
        require dirname(__DIR__) . '/Views/admin/' . $view . '.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/admin/layout.php';
    }

    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    protected function setSeo(array $seo): array
    {
        return array_merge([
            'title' => 'Pioneer Emery Stones - Emery Stone Manufacturer India',
            'description' => 'Leading manufacturer and supplier of Natraj, Surabhi, Ravi & Savaliya Emery Stones for flour mills across India.',
            'keywords' => 'Pioneer Emery Stones, Emery Stone Manufacturer, Flour Mill Emery Stone',
            'og_image' => '',
            'canonical' => '',
        ], $seo);
    }
}
