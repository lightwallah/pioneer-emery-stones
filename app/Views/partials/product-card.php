<?php
$showCategory = $showCategory ?? true;
$compact = $compact ?? false;
$homeCard = $homeCard ?? false;
$revealIndex = (int) ($revealIndex ?? 0);
$placeholderImg = asset('images/placeholder-product.svg');
?>
<article class="card product-card product-card-enhanced h-100 product-reveal-item<?= $homeCard ? ' product-card--home' : '' ?><?= $compact ? ' product-card--compact' : '' ?>" style="--reveal-i: <?= $revealIndex ?>">
    <a href="<?= url($lang, 'product/' . $product['slug']) ?>" class="product-card-img-wrap d-block text-decoration-none">
        <img src="<?= upload_url($product['image'] ?? '') ?>" class="card-img-top" alt="<?= e($product['name']) ?>" loading="lazy" onerror="this.onerror=null;this.src='<?= e($placeholderImg) ?>';">
        <div class="product-card-shine" aria-hidden="true"></div>
        <?php if (!$homeCard): ?>
        <div class="product-card-hover-bar">
            <span><?= e($t['details']) ?> <i class="bi bi-arrow-right"></i></span>
        </div>
        <?php endif; ?>
    </a>
    <div class="card-body d-flex flex-column">
        <?php if ($showCategory && !empty($product['category_name'])): ?>
        <span class="product-category-tag"><?= e($product['category_name']) ?></span>
        <?php endif; ?>
        <h<?= ($compact || $homeCard) ? '6' : '5' ?> class="card-title mb-1">
            <a href="<?= url($lang, 'product/' . $product['slug']) ?>" class="text-decoration-none text-dark stretched-link-target"><?= e($product['name']) ?></a>
        </h<?= ($compact || $homeCard) ? '6' : '5' ?>>
        <?php if (!$compact && !$homeCard && !empty($product['short_description'])): ?>
        <p class="card-text text-muted small mb-2 flex-grow-1"><?= e(truncate($product['short_description'], 80)) ?></p>
        <?php endif; ?>
        <?php if (!empty($product['size_count'])): ?>
        <span class="product-size-tag mb-2"><i class="bi bi-rulers"></i> <?= (int) $product['size_count'] ?> <?= e($t['sizes']) ?></span>
        <?php endif; ?>
        <div class="product-card-actions position-relative" style="z-index:2">
            <a href="<?= whatsapp_link(product_whatsapp_message($product['name'], $lang)) ?>" class="btn btn-success<?= $homeCard ? ' btn-sm' : '' ?> flex-grow-1" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i> <?= e($t['get_price']) ?>
            </a>
            <a href="<?= url($lang, 'product/' . $product['slug']) ?>" class="btn btn-outline-primary<?= $homeCard ? ' btn-sm' : '' ?>"><?= e($t['details']) ?></a>
        </div>
    </div>
</article>
