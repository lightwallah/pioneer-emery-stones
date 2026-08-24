<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="products-page-hero">
    <div class="container">
        <div class="products-page-hero-inner">
            <div>
                <span class="section-label"><?= e($t['our_products']) ?></span>
                <h1 class="section-title mb-2"><?= e($t['our_products']) ?></h1>
                <p class="products-page-lead mb-0"><?= e($t['our_products_desc']) ?></p>
            </div>
            <div class="products-page-hero-actions">
                <span class="products-count-badge"><i class="bi bi-box-seam"></i> <?= count($products) ?> <?= e($t['products']) ?></span>
                <a href="<?= whatsapp_link($t['wa_quote_msg'] ?? 'Hello, I need emery stones.') ?>" class="btn btn-success btn-lg" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i> <?= e($t['whatsapp_price']) ?>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="products-filter-section">
    <div class="container">
        <div class="category-filter-scroll">
            <div class="category-filter d-flex flex-nowrap gap-2">
                <a href="<?= url($lang, 'products') ?>" class="category-chip active"><?= e($t['view_all']) ?></a>
                <?php foreach ($categories as $cat): ?>
                <a href="<?= url($lang, 'products/' . $cat['slug']) ?>" class="category-chip"><?= e($cat['name']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="products-grid-section">
    <div class="container">
        <?php if (empty($products)): ?>
        <div class="text-center py-5 text-muted product-empty-state">
            <i class="bi bi-box-seam display-4 d-block mb-3 opacity-25"></i>
            <p class="mb-0"><?= e($t['no_results']) ?></p>
        </div>
        <?php else: ?>
        <div class="row g-3 g-md-4">
            <?php foreach ($products as $i => $product): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <?php
                    $showCategory = true;
                    $compact = false;
                    $homeCard = false;
                    $revealIndex = $i;
                    require dirname(__DIR__) . '/partials/product-card.php';
                ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/manufacturer-contact.php'; ?>
<?php require dirname(__DIR__) . '/partials/spec-tables.php'; ?>
