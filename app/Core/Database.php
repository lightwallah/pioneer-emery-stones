<?php

namespace App\Core;

class Database
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';
            self::$instance = DbConnection::connect($config);
        }
        return self::$instance;
    }
}
