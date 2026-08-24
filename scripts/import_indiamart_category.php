<?php
/**
 * Import categories + products from IndiaMART catalog pages.
 * Run: php scripts/import_indiamart_category.php
 * Optional: php scripts/import_indiamart_category.php emery-stone flour-mill-emery-stone grinding-stone
 */

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/app/Helpers/functions.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = ROOT_PATH . '/app/' . $relative . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$categoryPages = $argv;
array_shift($categoryPages);
if ($categoryPages === []) {
    $categoryPages = ['emery-stone', 'flour-mill-emery-stone', 'grinding-stone'];
}

$categoryMeta = [
    'emery-stone' => [
        'name_en' => 'Emery Stone',
        'name_hi' => 'एमरी स्टोन',
        'desc_en' => 'Premium emery stones for flour mills and atta chakki — all sizes from Pioneer, Jodhpur.',
        'desc_hi' => 'आटा चक्की और फ्लोर मिल के लिए प्रीमियम एमरी स्टोन्स — पायनियर, जोधपुर।',
        'sort_order' => 6,
    ],
    'flour-mill-emery-stone' => [
        'name_en' => 'Flour Mill Emery Stone',
        'name_hi' => 'फ्लोर मिल एमरी स्टोन',
        'desc_en' => 'Flour mill emery stones for domestic and commercial grinding.',
        'desc_hi' => 'घरेलू और व्यावसायिक पीसने के लिए फ्लोर मिल एमरी स्टोन्स।',
        'sort_order' => 7,
    ],
    'grinding-stone' => [
        'name_en' => 'Grinding Stone',
        'name_hi' => 'ग्राइंडिंग स्टोन',
        'desc_en' => 'Heavy-duty grinding stones for industrial flour milling.',
        'desc_hi' => 'औद्योगिक आटा पीसने के लिए भारी-भरकम ग्राइंडिंग स्टोन्स।',
        'sort_order' => 8,
    ],
];

function fetchIndiaMartHtml(string $slug): string
{
    $url = 'https://www.indiamart.com/pioneeremerystones-jodhpur/' . $slug . '.html';
    $ctx = stream_context_create([
        'http' => [
            'header' => "User-Agent: Mozilla/5.0\r\nAccept-Encoding: gzip\r\n",
            'timeout' => 45,
        ],
    ]);
    $raw = @file_get_contents($url, false, $ctx);
    if ($raw === false) {
        throw new RuntimeException("Failed to fetch {$url}");
    }
    if (str_starts_with($raw, "\x1f\x8b")) {
        $decoded = @gzdecode($raw);
        if ($decoded !== false) {
            return $decoded;
        }
    }
    return $raw;
}

function parseProducts(string $html): array
{
    $text = html_entity_decode(str_replace(['&quot;', '&amp;'], ['"', '&'], $html));
    $items = [];
    $seen = [];
    if (!preg_match_all(
        '/"productId":(\d+),"productName":"([^"]+)","productImage":"(https:\/\/[^"]+)"/',
        $text,
        $matches,
        PREG_SET_ORDER
    )) {
        return [];
    }
    foreach ($matches as $m) {
        $name = trim(str_replace(["''", "&#39;"], "'", $m[2]));
        if ($name === '' || isset($seen[$name])) {
            continue;
        }
        $seen[$name] = true;
        $items[] = [
            'product_id' => $m[1],
            'name' => $name,
            'image' => str_replace('250x250', '500x500', $m[3]),
        ];
    }
    return $items;
}

function detectBrandCategorySlug(string $name): ?string
{
    $upper = strtoupper($name);
    if (str_contains($upper, 'NATRAJ')) {
        return 'natraj-emery-stones';
    }
    if (str_contains($upper, 'SURABHI')) {
        return 'surabhi-emery-stones';
    }
    if (preg_match('/\bRAVI\b/', $upper)) {
        return 'ravi-emery-stones';
    }
    if (str_contains($upper, 'SAVALIYA') || str_contains($upper, 'SAVLIYA')) {
        return 'savaliya-emery-stones';
    }
    return null;
}

function detectStoneType(string $name): ?string
{
    $n = strtolower($name);
    if (str_contains($n, 'rajkot')) {
        return 'vertical_rajkot';
    }
    if (str_contains($n, 'janta')) {
        return 'horizontal_janta';
    }
    if (str_contains($n, 'horizontal') || str_contains($n, 'bolt type')) {
        return 'horizontal_taper';
    }
    if (str_contains($n, 'danish') || str_contains($n, 'vertical')) {
        return 'vertical_danish';
    }
    return null;
}

function extractSizes(string $name): array
{
    if (!preg_match_all('/(\d+)\s*(?:\'\'|\'|inch|in\b)/i', $name, $m)) {
        return [];
    }
    $sizes = [];
    foreach ($m[1] as $i => $inch) {
        $sizes[] = [
            'label' => $inch . ' Inch',
            'diameter' => $inch . '"',
            'bore' => '',
            'thickness' => '',
            'weight' => '',
        ];
    }
    return $sizes;
}

function downloadImage(string $url, string $dest): bool
{
    $ctx = stream_context_create([
        'http' => ['header' => "User-Agent: Mozilla/5.0\r\n", 'timeout' => 60],
    ]);
    $bytes = @file_get_contents($url, false, $ctx);
    if ($bytes === false) {
        return false;
    }
    return file_put_contents($dest, $bytes) !== false;
}

$config = require ROOT_PATH . '/config/database.php';
$pdo = new PDO(
    sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['dbname'], $config['charset']),
    $config['username'],
    $config['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$uploadDir = ROOT_PATH . '/public/uploads/products';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$categoryIds = [];
$slugStmt = $pdo->prepare('SELECT id FROM categories WHERE slug = ?');
$insertCat = $pdo->prepare('INSERT INTO categories (slug, sort_order, is_active) VALUES (?, ?, 1)');
$insertCatTr = $pdo->prepare('
    INSERT INTO category_translations (category_id, lang, name, description, meta_title, meta_description)
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description)
');

foreach ($categoryPages as $pageSlug) {
    if (!isset($categoryMeta[$pageSlug])) {
        echo "Unknown category page: {$pageSlug}\n";
        continue;
    }
    $meta = $categoryMeta[$pageSlug];
    $slugStmt->execute([$pageSlug]);
    $catId = $slugStmt->fetchColumn();
    if (!$catId) {
        $insertCat->execute([$pageSlug, $meta['sort_order']]);
        $catId = (int) $pdo->lastInsertId();
        foreach (['en', 'hi'] as $lang) {
            $nameKey = 'name_' . $lang;
            $descKey = 'desc_' . $lang;
            $insertCatTr->execute([
                $catId,
                $lang,
                $meta[$nameKey],
                $meta[$descKey],
                $meta[$nameKey] . ' | Pioneer Emery Stones',
                $meta[$descKey],
            ]);
        }
        echo "Created category: {$meta['name_en']} ({$pageSlug})\n";
    } else {
        echo "Category exists: {$meta['name_en']} ({$pageSlug})\n";
    }
    $categoryIds[$pageSlug] = (int) $catId;
}

$brandSlugToId = [];
$brandRows = $pdo->query('SELECT id, slug FROM categories')->fetchAll(PDO::FETCH_ASSOC);
foreach ($brandRows as $row) {
    $brandSlugToId[$row['slug']] = (int) $row['id'];
}

$imported = 0;
$skipped = 0;
$updated = 0;

foreach ($categoryPages as $pageSlug) {
    echo "\nFetching: {$pageSlug}\n";
    try {
        $html = fetchIndiaMartHtml($pageSlug);
    } catch (RuntimeException $e) {
        echo $e->getMessage() . "\n";
        continue;
    }
    $products = parseProducts($html);
    echo 'Found ' . count($products) . " products\n";

    foreach ($products as $idx => $item) {
        $slug = slugify($item['name']);
        $brandSlug = detectBrandCategorySlug($item['name']);
        $categoryId = $brandSlug && isset($brandSlugToId[$brandSlug])
            ? $brandSlugToId[$brandSlug]
            : ($categoryIds[$pageSlug] ?? $brandSlugToId['other-emery-stone-products'] ?? 5);

        $check = $pdo->prepare('SELECT id FROM products WHERE slug = ?');
        $check->execute([$slug]);
        $existingId = $check->fetchColumn();

        $ext = pathinfo(parse_url($item['image'], PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg';
        $imageFile = $slug . '-im-' . $item['product_id'] . '.' . $ext;
        $localPath = 'products/' . $imageFile;
        $fullPath = $uploadDir . '/' . $imageFile;

        if (!is_file($fullPath)) {
            if (!downloadImage($item['image'], $fullPath)) {
                echo "WARN: image download failed for {$slug}\n";
                $localPath = null;
            }
        }

        $stoneType = detectStoneType($item['name']);
        $short = 'Premium emery stone from Pioneer Emery Stones, Jodhpur. Factory direct — pan India delivery.';
        $desc = $item['name'] . ' — manufactured by Pioneer Emery Stones in Jodhpur, Rajasthan. Matched bore and thickness for your flour mill. Contact us on WhatsApp for best price.';

        if ($existingId) {
            $productId = (int) $existingId;
            $pdo->prepare('UPDATE products SET category_id = ?, stone_type = ? WHERE id = ?')
                ->execute([$categoryId, $stoneType, $productId]);
            if ($localPath) {
                $pdo->prepare('DELETE FROM product_images WHERE product_id = ?')->execute([$productId]);
                $pdo->prepare('INSERT INTO product_images (product_id, image_path, is_primary, sort_order) VALUES (?, ?, 1, 0)')
                    ->execute([$productId, $localPath]);
            }
            echo "Updated: {$item['name']}\n";
            $updated++;
            continue;
        }

        $pdo->prepare('
            INSERT INTO products (category_id, stone_type, slug, sku, is_featured, is_active, sort_order)
            VALUES (?, ?, ?, ?, 0, 1, ?)
        ')->execute([
            $categoryId,
            $stoneType,
            $slug,
            'IM-' . $item['product_id'],
            20 + $idx,
        ]);
        $productId = (int) $pdo->lastInsertId();

        $trans = $pdo->prepare('
            INSERT INTO product_translations
            (product_id, lang, name, short_description, description, benefits, applications, meta_title, meta_description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $benefits = "Factory direct price\nPan India delivery\nPremium emery quality";
        $apps = "Flour mills\nAtta chakki\nCommercial grinding";
        $trans->execute([$productId, 'en', $item['name'], $short, $desc, $benefits, $apps, $item['name'] . ' | Pioneer Emery Stones', $short]);
        $trans->execute([$productId, 'hi', $item['name'], $short, $desc, $benefits, $apps, $item['name'] . ' | Pioneer Emery Stones', $short]);

        if ($localPath) {
            $pdo->prepare('INSERT INTO product_images (product_id, image_path, is_primary, sort_order) VALUES (?, ?, 1, 0)')
                ->execute([$productId, $localPath]);
        }

        $sizes = extractSizes($item['name']);
        if ($sizes !== []) {
            $sizeStmt = $pdo->prepare('
                INSERT INTO product_sizes (product_id, size_label, diameter, bore, thickness, weight, sort_order)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ');
            foreach ($sizes as $si => $size) {
                $sizeStmt->execute([
                    $productId,
                    $size['label'],
                    $size['diameter'],
                    $size['bore'],
                    $size['thickness'],
                    $size['weight'],
                    $si + 1,
                ]);
            }
        }

        if ($stoneType) {
            $pdo->prepare('INSERT INTO product_specs (product_id, spec_key, spec_value, lang, sort_order) VALUES (?, ?, ?, ?, ?)')
                ->execute([$productId, 'Type', stone_type_label($stoneType), 'en', 1]);
        }

        echo "Imported: {$item['name']}\n";
        $imported++;
    }
}

echo "\nDone. Imported: {$imported}, Updated: {$updated}, Skipped: {$skipped}\n";
