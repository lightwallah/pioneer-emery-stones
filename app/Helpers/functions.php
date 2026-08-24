<?php

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function base_url(): string
{
    static $url = null;
    if ($url !== null) {
        return $url;
    }

    $config = require dirname(__DIR__, 2) . '/config/app.php';
    $configured = rtrim($config['url'] ?? '', '/');

    if (PHP_SAPI === 'cli' || empty($_SERVER['HTTP_HOST'])) {
        $url = $configured ?: 'http://localhost';
        return $url;
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = parse_url($configured, PHP_URL_PATH) ?: '';
    $path = rtrim((string) $path, '/');

    // When document root is /public (PHP dev server or vhost), assets live at /assets not /subfolder/public/assets
    $publicPath = realpath(dirname(__DIR__, 2) . '/public');
    $docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
    if ($publicPath && $docRoot && $publicPath === $docRoot) {
        $path = '';
    } elseif ($path !== '') {
        $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        if (!str_starts_with($requestPath, $path)) {
            $path = '';
        }
    }

    $url = $scheme . '://' . $host . $path;
    return $url;
}

function app_config(): array
{
    static $config = null;
    if ($config === null) {
        $config = require dirname(__DIR__, 2) . '/config/app.php';
        $config['url'] = base_url();
    }
    return $config;
}

function asset(string $path): string
{
    return rtrim(base_url(), '/') . '/assets/' . ltrim($path, '/');
}

function upload_url(?string $path): string
{
    if (!$path) {
        return asset('images/placeholder-product.svg');
    }

    if (PHP_SAPI === 'cli' || empty($_SERVER['HTTP_HOST'])) {
        return rtrim(base_url(), '/') . '/uploads/' . ltrim($path, '/');
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDir = ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');

    return $scheme . '://' . $_SERVER['HTTP_HOST'] . $scriptDir . '/uploads/' . ltrim($path, '/');
}

function site_logo_url(?array $settings = null): string
{
    $settings = $settings ?? (new \App\Models\Setting())->getAll();
    if (!empty($settings['site_logo'])) {
        return upload_url($settings['site_logo']);
    }
    return asset('images/pioneer-logo.png');
}

function favicon_url(string $size = '32'): string
{
    if ($size === '16') {
        return asset('images/favicon-16x16.png');
    }
    if ($size === '180') {
        return asset('images/apple-touch-icon.png');
    }
    return asset('images/favicon-32x32.png');
}

function url(string $lang, string $path = ''): string
{
    $base = rtrim(base_url(), '/');
    $path = ltrim($path, '/');
    return $path ? "{$base}/{$lang}/{$path}" : "{$base}/{$lang}";
}

function upload_error_message(int $code): string
{
    if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) {
        return 'File is too large. Max upload size is ' . ini_get('upload_max_filesize');
    }
    if ($code === UPLOAD_ERR_PARTIAL) {
        return 'File was only partially uploaded. Please try again.';
    }
    if ($code === UPLOAD_ERR_NO_FILE) {
        return 'No file selected.';
    }
    if ($code === UPLOAD_ERR_NO_TMP_DIR) {
        return 'Server temp folder missing. Contact hosting support.';
    }
    if ($code === UPLOAD_ERR_CANT_WRITE) {
        return 'Server could not write the file. Check folder permissions.';
    }
    if ($code === UPLOAD_ERR_EXTENSION) {
        return 'Upload blocked by server extension.';
    }
    return 'Upload failed (error code ' . $code . ').';
}

function upload_image(array $file, string $folder, ?string &$error = null): ?string
{
    $error = null;
    $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
    if ($uploadError !== UPLOAD_ERR_OK) {
        if ($uploadError !== UPLOAD_ERR_NO_FILE) {
            $error = upload_error_message($uploadError);
        }
        return null;
    }
    if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        $error = 'Invalid upload file.';
        return null;
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/x-png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    $mime = null;
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = finfo_file($finfo, $file['tmp_name']) ?: null;
            finfo_close($finfo);
        }
    }
    if (!$mime && function_exists('mime_content_type')) {
        $mime = mime_content_type($file['tmp_name']) ?: null;
    }
    if (!$mime && !empty($file['type'])) {
        $mime = $file['type'];
    }

    $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
    $extMap = ['jpg' => 'jpg', 'jpeg' => 'jpg', 'png' => 'png', 'webp' => 'webp', 'gif' => 'gif'];
    if (!isset($allowed[$mime ?? '']) && isset($extMap[$ext])) {
        $mime = array_search($extMap[$ext], $allowed, true) ?: 'image/jpeg';
    }
    if (!isset($allowed[$mime ?? ''])) {
        $error = 'Invalid image type. Use JPG, PNG, WEBP or GIF.';
        return null;
    }

    $dir = dirname(__DIR__, 2) . '/public/uploads/' . trim($folder, '/');
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    if (!is_writable($dir)) {
        @chmod($dir, 0777);
    }
    if (!is_writable($dir)) {
        $error = 'Upload folder is not writable. Set permissions on public/uploads/' . trim($folder, '/');
        return null;
    }

    $filename = uniqid('img_', true) . '.' . $allowed[$mime];
    if (move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) {
        @chmod($dir . '/' . $filename, 0644);
        return trim($folder, '/') . '/' . $filename;
    }

    $error = 'Could not save uploaded file.';
    return null;
}

function delete_upload(?string $path): void
{
    if (!$path || str_contains($path, '..')) {
        return;
    }
    $file = dirname(__DIR__, 2) . '/public/uploads/' . ltrim($path, '/');
    if (is_file($file)) {
        unlink($file);
    }
}

function stone_types(): array
{
    static $types;
    if ($types === null) {
        $types = require dirname(__DIR__, 2) . '/config/stone_types.php';
    }
    return $types;
}

function stone_type_label(string $key): string
{
    $types = stone_types();
    return $types[$key]['label'] ?? $key;
}

function admin_url(string $path = ''): string
{
    $base = rtrim(base_url(), '/') . '/admin';
    $path = ltrim($path, '/');
    return $path ? "{$base}/{$path}" : $base;
}

function nav_active(string $lang, string $path = ''): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
    if ($path === '') {
        return preg_match('#/' . preg_quote($lang, '#') . '/?$#', $uri) ? 'active' : '';
    }
    return str_contains($uri, '/' . $lang . '/' . ltrim($path, '/')) ? 'active' : '';
}

function whatsapp_link(string $message, ?string $phone = null): string
{
    $settings = (new \App\Models\Setting())->getAll();
    $number = $phone ?? ($settings['whatsapp_number'] ?? '919876543210');
    $number = preg_replace('/[^0-9]/', '', $number);
    return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
}

function product_whatsapp_message(string $productName, string $lang = 'en'): string
{
    if ($lang === 'hi') {
        return "नमस्ते Pioneer Emery Stones,\n\nमुझे इस उत्पाद में रुचि है:\nउत्पाद का नाम: {$productName}\n\nकृपया कीमत और विवरण साझा करें।\n\nधन्यवाद।";
    }
    return "Hello Pioneer Emery Stones,\n\nI am interested in:\nProduct Name: {$productName}\n\nPlease share price and details.\n\nThank You.";
}

function slugify(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    return $text ?: 'item';
}

function truncate(string $text, int $length = 150): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

function breadcrumb_schema(array $items): string
{
    $list = [];
    foreach ($items as $i => $item) {
        $list[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'] ?? null,
        ];
    }
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
