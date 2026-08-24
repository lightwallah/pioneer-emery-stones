<?php
/**
 * One-time import: IndiaMART catalog → pioneer_emery_stones DB
 * Run: php scripts/import_indiamart_products.php
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

$products = [
    [
        'name_en' => 'Flour Mill Stone',
        'name_hi' => 'आटा चक्की पत्थर',
        'slug' => 'flour-mill-stone',
        'sku' => 'IM-001',
        'category_id' => 5,
        'stone_type' => 'vertical_danish',
        'is_featured' => 1,
        'sort_order' => 10,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/6/429455396/UI/UM/AG/63309779/product-jpeg-500x500.png',
        'image_file' => 'flour-mill-stone.png',
        'short_en' => 'Premium flour mill emery stone for atta chakki and commercial flour mills.',
        'short_hi' => 'आटा चक्की और व्यावसायिक मिल के लिए प्रीमियम एमरी स्टोन।',
        'desc_en' => 'High-quality flour mill stone manufactured by Pioneer Emery Stones, Jodhpur. Suitable for domestic and commercial flour grinding with long service life.',
        'desc_hi' => 'पायनियर एमरी स्टोन्स, जोधपुर द्वारा निर्मित उच्च गुणवत्ता वाला आटा चक्की पत्थर।',
        'sizes' => [['10 Inch', '10"', '25 mm', '90/100 mm', '']],
    ],
    [
        'name_en' => 'Vertical Danish Type 10 Inch Emery Stone',
        'name_hi' => 'वर्टिकल डेनिश टाइप 10 इंच एमरी स्टोन',
        'slug' => 'vertical-danish-type-10-inch-emery-stone',
        'sku' => 'IM-002',
        'category_id' => 1,
        'stone_type' => 'vertical_danish',
        'is_featured' => 1,
        'sort_order' => 11,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/6/429289182/ZS/VM/CS/63309779/product-jpeg-500x500.png',
        'image_file' => 'vertical-danish-10-inch.png',
        'short_en' => '10 inch vertical Danish type emery stone for flour mills.',
        'short_hi' => 'आटा चक्की के लिए 10 इंच वर्टिकल डेनिश टाइप एमरी स्टोन।',
        'desc_en' => 'Vertical Danish type 10 inch emery stone — precision manufactured at our Jodhpur factory. Matched bore and thickness for your machine.',
        'desc_hi' => 'वर्टिकल डेनिश टाइप 10 इंच एमरी स्टोन — जोधपुर फैक्ट्री में निर्मित।',
        'sizes' => [['10 Inch', '10"', '25 mm', '90/100 mm', '']],
    ],
    [
        'name_en' => 'Vertical Danish Type Mill Stones 14 Inch',
        'name_hi' => 'वर्टिकल डेनिश टाइप 14 इंच मिल स्टोन',
        'slug' => 'vertical-danish-type-mill-stones-14-inch',
        'sku' => 'IM-003',
        'category_id' => 1,
        'stone_type' => 'vertical_danish',
        'is_featured' => 1,
        'sort_order' => 12,
        'image_url' => 'https://5.imimg.com/data5/SELLER/Default/2024/6/429624321/YH/BM/RK/63309779/product-jpeg-500x500.png',
        'image_file' => 'vertical-danish-14-inch.png',
        'short_en' => '14 inch vertical Danish type mill stones for medium flour mills.',
        'short_hi' => 'मध्यम आटा चक्की के लिए 14 इंच वर्टिकल डेनिश टाइप स्टोन।',
        'desc_en' => 'Vertical Danish Type Mill Stones 14 inch — durable grinding performance for atta chakki dealers and flour mill owners across India.',
        'desc_hi' => '14 इंच वर्टिकल डेनिश टाइप मिल स्टोन्स — पूरे भारत में डीलरों के लिए।',
        'sizes' => [['14 Inch', '14"', '30/35/40 mm', '150 mm', '']],
    ],
    [
        'name_en' => 'Flour Mill Stone 18 Inch Vertical Danish Type',
        'name_hi' => '18 इंच वर्टिकल डेनिश टाइप आटा चक्की पत्थर',
        'slug' => 'flour-mill-stone-18-inch-vertical-danish-type',
        'sku' => 'IM-004',
        'category_id' => 3,
        'stone_type' => 'vertical_danish',
        'is_featured' => 1,
        'sort_order' => 13,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/7/434034304/FD/DT/JU/63309779/product-jpeg-500x500.png',
        'image_file' => 'vertical-danish-18-inch.png',
        'short_en' => '18 inch vertical Danish type flour mill stone for heavy-duty grinding.',
        'short_hi' => 'भारी-भरकम पीसने के लिए 18 इंच वर्टिकल डेनिश टाइप पत्थर।',
        'desc_en' => 'Flour mill stone 18 inch vertical Danish type — industrial grade emery stone for large capacity flour mills. Factory direct from Pioneer, Jodhpur.',
        'desc_hi' => '18 इंच वर्टिकल डेनिश टाइप आटा चक्की पत्थर — बड़ी क्षमता वाली मिलों के लिए।',
        'sizes' => [['18 Inch', '18"', '40/45 mm', '150 mm', '']],
    ],
    [
        'name_en' => 'Vertical Emery Flour Mill Stones',
        'name_hi' => 'वर्टिकल एमरी फ्लोर मिल स्टोन्स',
        'slug' => 'vertical-emery-flour-mill-stones',
        'sku' => 'IM-005',
        'category_id' => 2,
        'stone_type' => 'vertical_danish',
        'is_featured' => 0,
        'sort_order' => 14,
        'image_url' => 'https://5.imimg.com/data5/SELLER/Default/2024/6/429453422/TL/TS/NU/63309779/verticsl-dsnish-type-10-inch-500x500.jpeg',
        'image_file' => 'vertical-emery-flour-mill-stones.jpeg',
        'short_en' => 'Vertical emery flour mill stones — Danish type, all popular sizes.',
        'short_hi' => 'वर्टिकल एमरी फ्लोर मिल स्टोन्स — डेनिश टाइप, सभी लोकप्रिय साइज।',
        'desc_en' => 'Vertical Emery Flour Mill Stones manufactured by Pioneer. Premium synthetic emery for consistent flour quality and long life.',
        'desc_hi' => 'पायनियर द्वारा निर्मित वर्टिकल एमरी फ्लोर मिल स्टोन्स।',
        'sizes' => [
            ['10 Inch', '10"', '25 mm', '90/100 mm', ''],
            ['12 Inch', '12"', '30 mm', '100 mm', ''],
        ],
    ],
    [
        'name_en' => 'Vertical Rajkot Type Emery Stones',
        'name_hi' => 'वर्टिकल राजकोट टाइप एमरी स्टोन्स',
        'slug' => 'vertical-rajkot-type-emery-stones',
        'sku' => 'IM-006',
        'category_id' => 5,
        'stone_type' => 'vertical_rajkot',
        'is_featured' => 0,
        'sort_order' => 15,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/9/451916282/DN/RG/OK/63309779/product-jpeg-500x500.png',
        'image_file' => 'vertical-rajkot-type.png',
        'short_en' => 'Vertical Rajkot type emery stones for flour mills — 16" to 24".',
        'short_hi' => 'आटा चक्की के लिए वर्टिकल राजकोट टाइप एमरी स्टोन्स — 16" से 24"।',
        'desc_en' => 'Vertical Rajkot Type Emery Stones — heavy-duty grinding stones for commercial flour mills. Made in Jodhpur with strict quality control.',
        'desc_hi' => 'वर्टिकल राजकोट टाइप एमरी स्टोन्स — व्यावसायिक आटा चक्की के लिए।',
        'sizes' => [
            ['16 Inch', '16"', '40 mm', '225 mm', ''],
            ['18 Inch', '18"', '40 mm', '225 mm', ''],
            ['20 Inch', '20"', '40/45 mm', '225 mm', ''],
        ],
    ],
    [
        'name_en' => '10 Inch Janta Type Emery Stone',
        'name_hi' => '10 इंच जनता टाइप एमरी स्टोन',
        'slug' => '10-inch-janta-type-emery-stone',
        'sku' => 'IM-007',
        'category_id' => 2,
        'stone_type' => 'horizontal_janta',
        'is_featured' => 0,
        'sort_order' => 16,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/9/451916435/LB/RD/CV/63309779/product-jpeg-500x500.png',
        'image_file' => 'janta-type-10-inch.png',
        'short_en' => '10 inch Janta type horizontal emery stone for flour mills.',
        'short_hi' => 'आटा चक्की के लिए 10 इंच जनता टाइप हॉरिजॉन्टल एमरी स्टोन।',
        'desc_en' => '10 inch JANTA Type emery stone — horizontal bolt type for atta chakki. Factory direct price from Pioneer Emery Stones, Jodhpur.',
        'desc_hi' => '10 इंच जनता टाइप एमरी स्टोन — हॉरिजॉन्टल बोल्ट टाइप।',
        'sizes' => [['10 Inch', '10"', '23/25 mm', '122-125 mm', '']],
    ],
    [
        'name_en' => '16 Inch Horizontal Type Emery Stone',
        'name_hi' => '16 इंच हॉरिजॉन्टल टाइप एमरी स्टोन',
        'slug' => '16-inch-horizontal-type-emery-stone',
        'sku' => 'IM-008',
        'category_id' => 5,
        'stone_type' => 'horizontal_taper',
        'is_featured' => 0,
        'sort_order' => 17,
        'image_url' => 'https://5.imimg.com/data5/IOS/Default/2024/9/451916682/BI/ZZ/NW/63309779/product-jpeg-500x500.png',
        'image_file' => 'horizontal-16-inch.png',
        'short_en' => '16 inch horizontal type emery stone with taper bore.',
        'short_hi' => '16 इंच हॉरिजॉन्टल टाइप टेपर बोर एमरी स्टोन।',
        'desc_en' => '16 inch horizontal type emery stone — taper bore design for large horizontal flour mills. Pan India delivery from manufacturer.',
        'desc_hi' => '16 इंच हॉरिजॉन्टल टाइप एमरी स्टोन — बड़ी हॉरिजॉन्टल मिलों के लिए।',
        'sizes' => [['16 Inch', '16"', '36/45 mm', '225 mm', '']],
    ],
];

$config = require ROOT_PATH . '/config/database.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['dbname'], $config['charset']);
$pdo = new PDO($dsn, $config['username'], $config['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$uploadDir = ROOT_PATH . '/public/uploads/products';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$imported = 0;
$skipped = 0;

foreach ($products as $item) {
    $check = $pdo->prepare('SELECT id FROM products WHERE slug = ?');
    $check->execute([$item['slug']]);
    if ($check->fetchColumn()) {
        echo "Skip (exists): {$item['slug']}\n";
        $skipped++;
        continue;
    }

    $localPath = 'products/' . $item['image_file'];
    $fullPath = $uploadDir . '/' . $item['image_file'];

    if (!is_file($fullPath)) {
        $ctx = stream_context_create([
            'http' => ['header' => "User-Agent: Mozilla/5.0\r\n", 'timeout' => 30],
        ]);
        $bytes = @file_get_contents($item['image_url'], false, $ctx);
        if ($bytes === false) {
            echo "WARN: Could not download image for {$item['slug']}\n";
        } else {
            file_put_contents($fullPath, $bytes);
            echo "Downloaded: {$item['image_file']}\n";
        }
    }

    $pdo->prepare('
        INSERT INTO products (category_id, stone_type, slug, sku, is_featured, is_active, sort_order)
        VALUES (?, ?, ?, ?, ?, 1, ?)
    ')->execute([
        $item['category_id'],
        $item['stone_type'],
        $item['slug'],
        $item['sku'],
        $item['is_featured'],
        $item['sort_order'],
    ]);
    $productId = (int) $pdo->lastInsertId();

    $benefitsEn = "Factory direct price\nPan India delivery\nPremium emery quality\nMatched to your machine bore";
    $benefitsHi = "सीधे फैक्ट्री कीमत\nपूरे भारत में डिलीवरी\nप्रीमियम एमरी गुणवत्ता";
    $appsEn = "Flour mills\nAtta chakki\nCommercial grinding";
    $appsHi = "आटा चक्की\nफ्लोर मिल\nव्यावसायिक पीसना";

    $trans = $pdo->prepare('
        INSERT INTO product_translations
        (product_id, lang, name, short_description, description, benefits, applications, meta_title, meta_description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ');

    $trans->execute([
        $productId, 'en', $item['name_en'], $item['short_en'], $item['desc_en'],
        $benefitsEn, $appsEn,
        $item['name_en'] . ' | Pioneer Emery Stones',
        $item['short_en'],
    ]);
    $trans->execute([
        $productId, 'hi', $item['name_hi'], $item['short_hi'], $item['desc_hi'],
        $benefitsHi, $appsHi,
        $item['name_hi'] . ' | Pioneer Emery Stones',
        $item['short_hi'],
    ]);

    if (is_file($fullPath)) {
        $pdo->prepare('
            INSERT INTO product_images (product_id, image_path, is_primary, sort_order)
            VALUES (?, ?, 1, 0)
        ')->execute([$productId, $localPath]);
    }

    $sizeStmt = $pdo->prepare('
        INSERT INTO product_sizes (product_id, size_label, diameter, bore, thickness, weight, sort_order)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ');
    foreach ($item['sizes'] as $i => $size) {
        $sizeStmt->execute([
            $productId, $size[0], $size[1], $size[2], $size[3], $size[4], $i + 1,
        ]);
    }

    $specStmt = $pdo->prepare('
        INSERT INTO product_specs (product_id, spec_key, spec_value, lang, sort_order)
        VALUES (?, ?, ?, ?, ?)
    ');
    $specStmt->execute([$productId, 'Type', stone_type_label($item['stone_type']), 'en', 1]);
    $specStmt->execute([$productId, 'Origin', 'Jodhpur, Rajasthan, India', 'en', 2]);
    $specStmt->execute([$productId, 'प्रकार', stone_type_label($item['stone_type']), 'hi', 1]);

    echo "Imported: {$item['name_en']} (id {$productId})\n";
    $imported++;
}

echo "\nDone. Imported: {$imported}, Skipped: {$skipped}\n";
