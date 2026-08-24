<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0056b3">
    <meta name="format-detection" content="telephone=yes">
    <title><?= e($seo['title'] ?? 'Pioneer Emery Stones') ?></title>
    <meta name="description" content="<?= e($seo['description'] ?? '') ?>">
    <meta name="keywords" content="<?= e($seo['keywords'] ?? '') ?>">
    <?php if (!empty($seo['canonical'])): ?>
    <link rel="canonical" href="<?= e($seo['canonical']) ?>">
    <?php endif; ?>
    <?php foreach ($config['languages'] as $altLang): ?>
    <link rel="alternate" hreflang="<?= $altLang ?>" href="<?= e(str_replace('/' . $lang, '/' . $altLang, $seo['canonical'] ?? url($lang))) ?>">
    <?php endforeach; ?>
    <meta property="og:title" content="<?= e($seo['title'] ?? '') ?>">
    <meta property="og:description" content="<?= e($seo['description'] ?? '') ?>">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= favicon_url('32') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= favicon_url('16') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= favicon_url('180') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="<?= asset('css/style.css') ?>" rel="stylesheet">
    <?php if (!empty($settings['google_search_console'])): ?>
    <?= $settings['google_search_console'] ?>
    <?php endif; ?>
    <?php if (!empty($settings['google_analytics'])): ?>
    <?= $settings['google_analytics'] ?>
    <?php endif; ?>
    <?php if (!empty($productSchema)): ?>
    <script type="application/ld+json"><?= $productSchema ?></script>
    <?php endif; ?>
    <?php if (!empty($faqSchema)): ?>
    <script type="application/ld+json"><?= $faqSchema ?></script>
    <?php endif; ?>
    <?php if (!empty($articleSchema)): ?>
    <script type="application/ld+json"><?= $articleSchema ?></script>
    <?php endif; ?>
    <?php if (!empty($breadcrumbs)): ?>
    <script type="application/ld+json"><?= breadcrumb_schema($breadcrumbs) ?></script>
    <?php endif; ?>
    <script type="application/ld+json">
    {"@context":"https://schema.org","@type":"Organization","name":"Pioneer Emery Stones","url":"<?= e($baseUrl) ?>","description":"Emery Stone Manufacturer and Supplier in Rajasthan, India"}
    </script>
</head>
<body class="site-body">
<script>document.documentElement.classList.add('js');</script>
<?php $settings = $settings ?? (new \App\Models\Setting())->getAll(); ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>
<main class="site-main"><?= $content ?></main>
<?php require dirname(__DIR__) . '/partials/footer.php'; ?>
<?php require dirname(__DIR__) . '/partials/mobile-bar.php'; ?>
<?php require dirname(__DIR__) . '/partials/whatsapp-float.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
