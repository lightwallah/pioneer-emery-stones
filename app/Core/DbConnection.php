<?php

namespace App\Core;

class DbConnection
{
    /** @var \PDO|\mysqli */
    private $driver;
    /** @var string */
    private $type;

    private function __construct($driver, $type)
    {
        $this->driver = $driver;
        $this->type = $type;
    }

    public static function connect(array $config)
    {
        $host = $config['host'] ?? 'localhost';
        $name = $config['dbname'] ?? '';
        $user = $config['username'] ?? '';
        $pass = $config['password'] ?? '';
        $charset = $config['charset'] ?? 'utf8mb4';

        if (self::needsInstaller($user, $pass, $name)) {
            self::sendToInstaller();
        }

        if (class_exists('PDO')) {
            $drivers = [];
            if (method_exists('PDO', 'getAvailableDrivers')) {
                $drivers = \PDO::getAvailableDrivers();
            }
            if (in_array('mysql', $drivers, true)) {
                try {
                    $pdo = new \PDO(
                        "mysql:host={$host};dbname={$name};charset={$charset}",
                        $user,
                        $pass,
                        [
                            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                            \PDO::ATTR_EMULATE_PREPARES => false,
                        ]
                    );
                    return new self($pdo, 'pdo');
                } catch (\PDOException $e) {
                    self::fail($e->getMessage(), $user, $pass);
                }
            }
        }

        if (class_exists('mysqli')) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            try {
                $mysqli = new \mysqli($host, $user, $pass, $name);
                $mysqli->set_charset($charset);
                return new self($mysqli, 'mysqli');
            } catch (\Throwable $e) {
                self::fail($e->getMessage(), $user, $pass);
            }
        }

        self::fail('Neither PDO MySQL nor mysqli is available. Enable pdo_mysql or mysqli in cPanel → Select PHP Version.');
        return null;
    }

    public function prepare($sql)
    {
        if ($this->type === 'pdo') {
            return new DbStatement($this->driver->prepare($sql), 'pdo');
        }
        return new DbStatement($this->driver, 'mysqli', $sql);
    }

    public function query($sql)
    {
        if ($this->type === 'pdo') {
            return new DbStatement($this->driver->query($sql), 'pdo');
        }
        $result = $this->driver->query($sql);
        return new DbStatement($this->driver, 'mysqli', $sql, $result);
    }

    public function exec($sql)
    {
        if ($this->type === 'pdo') {
            return $this->driver->exec($sql);
        }
        $this->driver->query($sql);
        return $this->driver->affected_rows;
    }

    public function lastInsertId()
    {
        if ($this->type === 'pdo') {
            return $this->driver->lastInsertId();
        }
        return (string) $this->driver->insert_id;
    }

    public function multiQuery($sql)
    {
        if ($this->type === 'pdo') {
            $this->driver->exec($sql);
            return;
        }
        if (!$this->driver->multi_query($sql)) {
            throw new \RuntimeException($this->driver->error);
        }
        do {
            if ($result = $this->driver->store_result()) {
                $result->free();
            }
        } while ($this->driver->more_results() && $this->driver->next_result());
    }

    private static function isLocalRequest()
    {
        $httpHost = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
        $httpHost = preg_replace('/:\d+$/', '', $httpHost);
        return in_array($httpHost, ['localhost', '127.0.0.1', '::1'], true);
    }

    private static function needsInstaller($user, $pass, $name)
    {
        if (self::isLocalRequest()) {
            return false;
        }
        if ($user === '' || $name === '') {
            return true;
        }
        return $user === 'root' && $pass === '';
    }

    private static function installerUrl()
    {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
        if (preg_match('#/public/index\.php$#', $script)) {
            $path = substr($script, 0, -strlen('/public/index.php')) . '/install.php';
        } else {
            $path = rtrim(dirname($script), '/') . '/install.php';
            if (strpos($script, '/public/') !== false) {
                $path = preg_replace('#/public/install\.php$#', '/install.php', $path);
            }
        }
        if ($path === '/install.php' || $path === 'install.php') {
            $path = '/install.php';
        }
        return ($https ? 'https' : 'http') . '://' . $host . $path;
    }

    private static function sendToInstaller()
    {
        $url = self::installerUrl();
        if (!headers_sent()) {
            header('Location: ' . $url, true, 302);
            exit;
        }
        echo '<p>Open the installer: <a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '</a></p>';
        exit;
    }

    private static function fail($message, $user = '', $pass = '')
    {
        if (!self::isLocalRequest() && $user === 'root' && $pass === '') {
            self::sendToInstaller();
        }
        if (stripos((string) $message, 'Access denied') !== false && !self::isLocalRequest()) {
            self::sendToInstaller();
        }
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
        echo '<h1>Database error</h1><p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p>On hosting, run <a href="' . htmlspecialchars(self::installerUrl(), ENT_QUOTES, 'UTF-8') . '">install.php</a> with your cPanel MySQL user (not root).</p>';
        exit;
    }
}

class DbStatement
{
    private $stmt;
    private $type;
    private $sql;
    private $result;
    private $mysqli;

    public function __construct($stmtOrMysqli, $type, $sql = '', $result = null)
    {
        $this->type = $type;
        $this->sql = $sql;
        $this->result = $result;
        if ($type === 'pdo') {
            $this->stmt = $stmtOrMysqli;
        } else {
            $this->mysqli = $stmtOrMysqli;
        }
    }

    public function execute($params = [])
    {
        if ($this->type === 'pdo') {
            return $this->stmt->execute($params);
        }
        $sql = $this->bind($this->sql, $params);
        $this->result = $this->mysqli->query($sql);
        return (bool) $this->result;
    }

    public function fetch()
    {
        if ($this->type === 'pdo') {
            $row = $this->stmt->fetch(\PDO::FETCH_ASSOC);
            return $row ?: false;
        }
        if ($this->result instanceof \mysqli_result) {
            $row = $this->result->fetch_assoc();
            return $row ?: false;
        }
        return false;
    }

    public function fetchAll()
    {
        if ($this->type === 'pdo') {
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        }
        $rows = [];
        if ($this->result instanceof \mysqli_result) {
            while ($row = $this->result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    public function fetchColumn($column = 0)
    {
        $row = $this->fetch();
        if (!$row) {
            return false;
        }
        $values = array_values($row);
        return $values[$column] ?? false;
    }

    private function bind($sql, $params)
    {
        foreach ($params as $value) {
            $pos = strpos($sql, '?');
            if ($pos === false) {
                break;
            }
            $sql = substr_replace($sql, $this->quote($value), $pos, 1);
        }
        return $sql;
    }

    private function quote($value)
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }
        return "'" . $this->mysqli->real_escape_string((string) $value) . "'";
    }
}
