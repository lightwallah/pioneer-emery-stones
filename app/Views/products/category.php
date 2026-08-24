<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="products-page-hero">
    <div class="container">
        <div class="products-page-hero-inner">
            <div>
                <span class="section-label"><?= e($t['our_brands']) ?></span>
                <h1 class="section-title mb-2"><?= e($category['name']) ?></h1>
                <?php if (!empty($category['description'])): ?>
                <p class="products-page-lead mb-0"><?= e($category['description']) ?></p>
                <?php endif; ?>
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
                <a href="<?= url($lang, 'products') ?>" class="category-chip"><?= e($t['view_all']) ?></a>
                <?php foreach ((new \App\Models\Category())->getAll($lang) as $cat): ?>
                <a href="<?= url($lang, 'products/' . $cat['slug']) ?>" class="category-chip <?= $cat['slug'] === $category['slug'] ? 'active' : '' ?>"><?= e($cat['name']) ?></a>
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
            <p class="mb-3"><?= e($t['no_results']) ?></p>
            <a href="<?= url($lang, 'products') ?>" class="btn btn-primary"><?= e($t['view_all_products']) ?></a>
        </div>
        <?php else: ?>
        <div class="row g-3 g-md-4">
            <?php foreach ($products as $i => $product): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <?php
                    $revealIndex = $i;
                    $showCategory = false;
                    $homeCard = false;
                    require dirname(__DIR__) . '/partials/product-card.php';
                ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/manufacturer-contact.php'; ?>
