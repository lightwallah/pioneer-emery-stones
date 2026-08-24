<?php
/**
 * Pioneer Emery Stones — one-click hosting installer
 * Open: https://yourdomain.com/install.php
 * Delete this file after install.
 */

declare(strict_types=1);

require __DIR__ . '/app/Helpers/polyfill.php';

$root = __DIR__;
$lockFile = $root . '/config/installed.lock';
$schemaFile = $root . '/database/schema.sql';
$seedFile = $root . '/database/seed.sql';
$fullFile = $root . '/database/full-install.sql';

function install_base_url(): string
{
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $scheme = $https ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/install.php');
    $dir = rtrim(dirname($script), '/.');
    if (str_ends_with($dir, '/public')) {
        $dir = substr($dir, 0, -7);
    }
    return rtrim($scheme . '://' . $host . $dir, '/');
}

function install_public_url(): string
{
    return install_base_url() . '/public';
}

function install_rewrite_sql(string $sql): string
{
    $sql = preg_replace('/^\s*CREATE\s+DATABASE\b.*?;/im', '', $sql) ?? $sql;
    $sql = preg_replace('/^\s*USE\s+\S+;/im', '', $sql) ?? $sql;
    return $sql;
}

function install_run_sql($db, string $sql): void
{
    $sql = install_rewrite_sql($sql);
    if ($db instanceof mysqli) {
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        if (!$db->multi_query($sql . ';SET FOREIGN_KEY_CHECKS=1')) {
            throw new RuntimeException($db->error);
        }
        do {
            if ($result = $db->store_result()) {
                $result->free();
            }
            if ($db->errno) {
                throw new RuntimeException($db->error);
            }
        } while ($db->more_results() && $db->next_result());
        return;
    }
    $db->exec('SET FOREIGN_KEY_CHECKS=0');
    $statements = preg_split('/;\s*\n/', $sql) ?: [];
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if ($statement === '' || str_starts_with($statement, '--')) {
            continue;
        }
        $db->exec($statement);
    }
    $db->exec('SET FOREIGN_KEY_CHECKS=1');
}

function install_connect(string $host, string $name, string $user, string $pass)
{
    if (class_exists('PDO')) {
        $drivers = method_exists('PDO', 'getAvailableDrivers') ? PDO::getAvailableDrivers() : [];
        if (in_array('mysql', $drivers, true)) {
            return new PDO(
                sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $name),
                $user,
                $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
    }
    if (class_exists('mysqli')) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
    throw new RuntimeException('MySQL PHP extension missing. In cPanel → Select PHP Version, enable mysqli or pdo_mysql.');
}

function install_write_php(string $path, string $contents): void
{
    if (file_put_contents($path, $contents) === false) {
        throw new RuntimeException('Could not write ' . basename($path) . '. Make config/ writable.');
    }
}

function install_config_is_placeholder(): bool
{
    $file = __DIR__ . '/config/database.php';
    if (!is_file($file)) {
        return true;
    }
    $db = require $file;
    $user = (string) ($db['username'] ?? '');
    $pass = (string) ($db['password'] ?? '');
    $name = (string) ($db['dbname'] ?? '');
    if ($user === '' || $name === '') {
        return true;
    }
    $httpHost = strtolower((string) ($_SERVER['HTTP_HOST'] ?? ''));
    $httpHost = preg_replace('/:\d+$/', '', $httpHost);
    $isLocal = in_array($httpHost, ['localhost', '127.0.0.1', '::1'], true);
    return !$isLocal && $user === 'root' && $pass === '';
}

$errors = [];
$success = false;
$already = is_file($lockFile) && !install_config_is_placeholder();

if ($already && ($_GET['reset'] ?? '') !== '1') {
    $publicUrl = install_public_url();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim((string) ($_POST['db_host'] ?? 'localhost'));
    $name = trim((string) ($_POST['db_name'] ?? ''));
    $user = trim((string) ($_POST['db_user'] ?? ''));
    $pass = (string) ($_POST['db_pass'] ?? '');
    $siteUrl = rtrim(trim((string) ($_POST['site_url'] ?? install_public_url())), '/');

    if ($name === '' || $user === '') {
        $errors[] = 'Database name and username are required.';
    }

    if ($errors === []) {
        try {
            $db = install_connect($host, $name, $user, $pass);

            if (is_file($fullFile) && filesize($fullFile) > 100) {
                install_run_sql($db, (string) file_get_contents($fullFile));
            } else {
                if (!is_file($schemaFile) || !is_file($seedFile)) {
                    throw new RuntimeException('database/schema.sql or database/seed.sql is missing.');
                }
                install_run_sql($db, (string) file_get_contents($schemaFile));
                install_run_sql($db, (string) file_get_contents($seedFile));
            }

            $dbPhp = "<?php\n\nreturn [\n"
                . "    'host' => " . var_export($host, true) . ",\n"
                . "    'dbname' => " . var_export($name, true) . ",\n"
                . "    'username' => " . var_export($user, true) . ",\n"
                . "    'password' => " . var_export($pass, true) . ",\n"
                . "    'charset' => 'utf8mb4',\n"
                . "];\n";
            install_write_php($root . '/config/database.php', $dbPhp);

            $appPhp = "<?php\n\nreturn [\n"
                . "    'name' => 'Pioneer Emery Stones',\n"
                . "    'url' => " . var_export($siteUrl, true) . ",\n"
                . "    'default_lang' => 'en',\n"
                . "    'languages' => ['en', 'hi'],\n"
                . "    'timezone' => 'Asia/Kolkata',\n"
                . "    'upload_path' => dirname(__DIR__) . '/public/uploads',\n"
                . "    'upload_url' => '/uploads',\n"
                . "    'items_per_page' => 12,\n"
                . "    'compare_max' => 4,\n"
                . "];\n";
            install_write_php($root . '/config/app.php', $appPhp);

            $uploads = $root . '/public/uploads';
            if (!is_dir($uploads)) {
                mkdir($uploads, 0755, true);
            }
            @chmod($uploads, 0755);

            file_put_contents($lockFile, date('c') . "\n");
            $success = true;
            $already = true;
            $publicUrl = $siteUrl;
        } catch (Throwable $e) {
            $errors[] = $e->getMessage();
        }
    }
}

$guessUrl = install_public_url();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Pioneer Emery Stones</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f7fc; margin: 0; color: #123; }
        .wrap { max-width: 560px; margin: 40px auto; background: #fff; padding: 28px; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,70,140,.12); }
        h1 { margin: 0 0 8px; font-size: 1.45rem; }
        p.lead { color: #567; margin: 0 0 22px; }
        label { display: block; font-weight: 700; font-size: .85rem; margin: 12px 0 5px; }
        input { width: 100%; box-sizing: border-box; padding: 10px 12px; border: 1px solid #cdd; border-radius: 8px; font-size: 16px; }
        button { margin-top: 18px; width: 100%; background: #0056b3; color: #fff; border: 0; padding: 12px; border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; }
        .err { background: #fde8e8; color: #8a1f1f; padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; }
        .ok { background: #e7f8ee; color: #146c2e; padding: 12px; border-radius: 8px; }
        .ok a { color: #0a7; font-weight: 700; }
        .hint { font-size: .8rem; color: #789; margin-top: 4px; }
        code { background: #eef3f9; padding: 1px 5px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="wrap">
    <h1>Pioneer Emery Stones installer</h1>
    <p class="lead">Fill your hosting MySQL details. Tables and sample data will be created automatically.</p>

    <?php if ($already && $success): ?>
        <div class="ok">
            <strong>Installed successfully.</strong>
            <p>Website: <a href="<?= htmlspecialchars($publicUrl) ?>/en"><?= htmlspecialchars($publicUrl) ?>/en</a></p>
            <p>Admin: <a href="<?= htmlspecialchars($publicUrl) ?>/admin/login"><?= htmlspecialchars($publicUrl) ?>/admin/login</a></p>
            <p>Login: <code>admin</code> / <code>password</code> — change this after login.</p>
            <p><strong>Delete <code>install.php</code> from the server now.</strong></p>
        </div>
    <?php elseif ($already): ?>
        <div class="ok">
            This site is already installed.<br>
            Open <a href="<?= htmlspecialchars(install_public_url()) ?>/en">the website</a>
            or <a href="<?= htmlspecialchars(install_public_url()) ?>/admin/login">admin login</a>.
        </div>
    <?php else: ?>
        <?php foreach ($errors as $err): ?>
            <div class="err"><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
        <form method="post">
            <label>MySQL host</label>
            <input name="db_host" value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost') ?>" required>
            <div class="hint">Usually <code>localhost</code> on cPanel hosting.</div>

            <label>Database name</label>
            <input name="db_name" value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>" required>
            <div class="hint">Create an empty database in cPanel → MySQL Databases first.</div>

            <label>Database username</label>
            <input name="db_user" value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>" required>

            <label>Database password</label>
            <input name="db_pass" type="password" value="<?= htmlspecialchars($_POST['db_pass'] ?? '') ?>">

            <label>Website URL</label>
            <input name="site_url" value="<?= htmlspecialchars($_POST['site_url'] ?? $guessUrl) ?>" required>
            <div class="hint">Must end with <code>/public</code> if you keep the default folder structure.</div>

            <button type="submit">Install website</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
