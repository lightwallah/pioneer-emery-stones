<?php

declare(strict_types=1);

$root = dirname(__DIR__);
require $root . '/app/Helpers/functions.php';

$dbConfig = require $root . '/config/database.php';
$pdo = new PDO(
    sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbConfig['host'], $dbConfig['dbname']),
    $dbConfig['username'],
    $dbConfig['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$pdo->exec('
    CREATE TABLE IF NOT EXISTS process_steps (
        id INT AUTO_INCREMENT PRIMARY KEY,
        icon VARCHAR(50) DEFAULT "bi-gear",
        image VARCHAR(255),
        image_position VARCHAR(50) DEFAULT "center",
        sort_order INT DEFAULT 0,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
');

$pdo->exec('
    CREATE TABLE IF NOT EXISTS process_step_translations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        process_step_id INT NOT NULL,
        lang VARCHAR(5) NOT NULL,
        label VARCHAR(200) NOT NULL,
        description TEXT,
        FOREIGN KEY (process_step_id) REFERENCES process_steps(id) ON DELETE CASCADE,
        UNIQUE KEY (process_step_id, lang)
    )
');

$count = (int) $pdo->query('SELECT COUNT(*) FROM process_steps')->fetchColumn();
if ($count > 0) {
    echo "Process steps already exist ({$count}). Skipping seed.\n";
    exit(0);
}

$en = require $root . '/lang/en.php';
$hi = require $root . '/lang/hi.php';
$stepsEn = $en['landing_process_steps'] ?? [];
$stepsHi = $hi['landing_process_steps'] ?? [];

$insertStep = $pdo->prepare('INSERT INTO process_steps (icon, sort_order, is_active) VALUES (?, ?, 1)');
$insertTr = $pdo->prepare('
    INSERT INTO process_step_translations (process_step_id, lang, label, description)
    VALUES (?, ?, ?, ?)
');

foreach ($stepsEn as $idx => $step) {
    $insertStep->execute([$step['icon'] ?? 'bi-gear', $idx]);
    $id = (int) $pdo->lastInsertId();
    $insertTr->execute([$id, 'en', $step['label'] ?? '', $step['desc'] ?? '']);
    $hiStep = $stepsHi[$idx] ?? [];
    $insertTr->execute([
        $id,
        'hi',
        $hiStep['label'] ?? $step['label'] ?? '',
        $hiStep['desc'] ?? $step['desc'] ?? '',
    ]);
}

$settings = [
    'manufacturing_process_title_en' => $en['landing_process_title'] ?? '',
    'manufacturing_process_title_hi' => $hi['landing_process_title'] ?? '',
    'manufacturing_process_desc_en' => $en['landing_process_desc'] ?? '',
    'manufacturing_process_desc_hi' => $hi['landing_process_desc'] ?? '',
];

$setStmt = $pdo->prepare('
    INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
    ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
');

foreach ($settings as $key => $value) {
    $setStmt->execute([$key, $value]);
}

echo 'Seeded ' . count($stepsEn) . " manufacturing process steps.\n";
