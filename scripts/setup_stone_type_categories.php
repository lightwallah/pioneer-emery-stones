<?php
/**
 * Create stone-type categories and assign products.
 * Run: php scripts/setup_stone_type_categories.php
 */

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/app/Helpers/functions.php';

$config = require ROOT_PATH . '/config/database.php';
$pdo = new PDO(
    sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['dbname'], $config['charset']),
    $config['username'],
    $config['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$stoneCategories = [
    'horizontal-bolt-type' => [
        'sort_order' => 1,
        'name_en' => 'Horizontal Bolt Type',
        'name_hi' => 'हॉरिजॉन्टल बोल्ट टाइप',
        'desc_en' => 'Horizontal bolt type emery stones for heavy flour mills — 16" to 30" sizes.',
        'desc_hi' => 'भारी फ्लोर मिल के लिए हॉरिजॉन्टल बोल्ट टाइप एमरी स्टोन्स — 16" से 30" साइज।',
        'stone_types' => ['horizontal_taper'],
    ],
    'horizontal-janta-type' => [
        'sort_order' => 2,
        'name_en' => 'Horizontal Janta Type',
        'name_hi' => 'हॉरिजॉन्टल जनता टाइप',
        'desc_en' => 'Horizontal Janta type emery stones for atta chakki and flour mills.',
        'desc_hi' => 'आटा चक्की और फ्लोर मिल के लिए हॉरिजॉन्टल जनता टाइप एमरी स्टोन्स।',
        'stone_types' => ['horizontal_janta'],
    ],
    'vertical-danish-type' => [
        'sort_order' => 3,
        'name_en' => 'Vertical Danish Type',
        'name_hi' => 'वर्टिकल डेनिश टाइप',
        'desc_en' => 'Vertical Danish type emery stones — 8" to 20" for domestic and commercial mills.',
        'desc_hi' => 'वर्टिकल डेनिश टाइप एमरी स्टोन्स — 8" से 20" घरेलू और व्यावसायिक चक्की के लिए।',
        'stone_types' => ['vertical_danish'],
    ],
    'vertical-bush-type' => [
        'sort_order' => 4,
        'name_en' => 'Vertical Bush Type',
        'name_hi' => 'वर्टिकल बुश टाइप',
        'desc_en' => 'Vertical bush type emery stones for flour milling machines.',
        'desc_hi' => 'फ्लोर मिलिंग मशीनों के लिए वर्टिकल बुश टाइप एमरी स्टोन्स।',
        'stone_types' => ['vertical_marshal'],
    ],
    'vertical-rajkot-type' => [
        'sort_order' => 5,
        'name_en' => 'Vertical Rajkot Type',
        'name_hi' => 'वर्टिकल राजकोट टाइप',
        'desc_en' => 'Vertical Rajkot type emery stones — durable grinding for flour mills.',
        'desc_hi' => 'वर्टिकल राजकोट टाइप एमरी स्टोन्स — फ्लोर मिल के लिए टिकाऊ पीसने की गुणवत्ता।',
        'stone_types' => ['vertical_rajkot'],
    ],
];

function detectStoneTypeFromName(string $name): ?string
{
    $n = strtolower($name);
    if (str_contains($n, 'rajkot')) {
        return 'vertical_rajkot';
    }
    if (str_contains($n, 'janta')) {
        return 'horizontal_janta';
    }
    if (str_contains($n, 'bush') || str_contains($n, 'marshal')) {
        return 'vertical_marshal';
    }
    if (str_contains($n, 'horizontal') || str_contains($n, 'bolt')) {
        return 'horizontal_taper';
    }
    if (str_contains($n, 'danish') || str_contains($n, 'vertical')) {
        return 'vertical_danish';
    }
    return null;
}

$slugToId = [];
$findCat = $pdo->prepare('SELECT id FROM categories WHERE slug = ?');
$insertCat = $pdo->prepare('INSERT INTO categories (slug, sort_order, is_active) VALUES (?, ?, 1)');
$updateCat = $pdo->prepare('UPDATE categories SET sort_order = ?, is_active = 1 WHERE id = ?');
$upsertTr = $pdo->prepare('
    INSERT INTO category_translations (category_id, lang, name, description, meta_title, meta_description)
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description),
        meta_title = VALUES(meta_title), meta_description = VALUES(meta_description)
');

foreach ($stoneCategories as $slug => $meta) {
    $findCat->execute([$slug]);
    $id = $findCat->fetchColumn();
    if ($id) {
        $id = (int) $id;
        $updateCat->execute([$meta['sort_order'], $id]);
        echo "Updated category: {$meta['name_en']}\n";
    } else {
        $insertCat->execute([$slug, $meta['sort_order']]);
        $id = (int) $pdo->lastInsertId();
        echo "Created category: {$meta['name_en']}\n";
    }
    $slugToId[$slug] = $id;

    foreach (['en', 'hi'] as $lang) {
        $nameKey = 'name_' . $lang;
        $descKey = 'desc_' . $lang;
        $upsertTr->execute([
            $id,
            $lang,
            $meta[$nameKey],
            $meta[$descKey],
            $meta[$nameKey] . ' | Pioneer Emery Stones',
            $meta[$descKey],
        ]);
    }
}

$stoneTypeToSlug = [];
foreach ($stoneCategories as $slug => $meta) {
    foreach ($meta['stone_types'] as $type) {
        $stoneTypeToSlug[$type] = $slug;
    }
}

$products = $pdo->query('
    SELECT p.id, p.stone_type, pt.name
    FROM products p
    JOIN product_translations pt ON p.id = pt.product_id AND pt.lang = "en"
    WHERE p.is_active = 1
')->fetchAll(PDO::FETCH_ASSOC);

$updateProduct = $pdo->prepare('UPDATE products SET category_id = ?, stone_type = ? WHERE id = ?');
$assigned = 0;

foreach ($products as $product) {
    $stoneType = $product['stone_type'] ?: detectStoneTypeFromName($product['name']);
    if (!$stoneType) {
        $stoneType = 'vertical_danish';
    }

    $slug = $stoneTypeToSlug[$stoneType] ?? 'vertical-danish-type';
    $categoryId = $slugToId[$slug] ?? $slugToId['vertical-danish-type'];

    $updateProduct->execute([$categoryId, $stoneType, $product['id']]);
    echo "Product #{$product['id']} → {$slug} ({$stoneType})\n";
    $assigned++;
}

// Push old IndiaMART / generic categories lower in menu
$pdo->exec('UPDATE categories SET sort_order = sort_order + 20 WHERE slug IN ("emery-stone","flour-mill-emery-stone","grinding-stone")');
$pdo->exec('UPDATE categories SET sort_order = sort_order + 10 WHERE slug IN ("natraj-emery-stones","surabhi-emery-stones","ravi-emery-stones","savaliya-emery-stones","other-emery-stone-products")');

echo "\nDone. Assigned {$assigned} products to stone-type categories.\n";
