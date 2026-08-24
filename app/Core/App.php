<?php

namespace App\Core;

class App
{
    public static function init(): void
    {
        session_start();
        require_once dirname(__DIR__) . '/Helpers/polyfill.php';
        date_default_timezone_set((require dirname(__DIR__, 2) . '/config/app.php')['timezone']);
        require_once dirname(__DIR__) . '/Helpers/functions.php';
        self::loadRoutes();
    }

    private static function loadRoutes(): void
    {
        $router = new Router();
        require dirname(__DIR__, 2) . '/config/routes.php';

        $url = $_GET['url'] ?? '';
        $router->dispatch($url);
    }
}
