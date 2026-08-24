<?php
$settings = $settings ?? (new \App\Models\Setting())->getAll();
$phone = preg_replace('/\s+/', '', $settings['phone'] ?? '');
$waMsg = $t['wa_quote_msg'] ?? 'Hello, I need emery stones. Please share price and details.';
?>
<section class="quick-actions-section">
    <div class="container">
        <div class="row g-3 g-md-4">
            <div class="col-6 col-lg-3">
                <a href="<?= url($lang, 'products') ?>" class="quick-action-card">
                    <span class="quick-action-icon"><i class="bi bi-grid-fill"></i></span>
                    <strong><?= e($t['our_products']) ?></strong>
                    <small><?= e($t['our_products_desc']) ?></small>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?= url($lang) ?>#specifications" class="quick-action-card">
                    <span class="quick-action-icon"><i class="bi bi-rulers"></i></span>
                    <strong><?= e($t['size_chart']) ?></strong>
                    <small><?= e($t['sizes_range']) ?></small>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <?php if ($phone): ?>
                <a href="tel:<?= e($phone) ?>" class="quick-action-card quick-action-call">
                    <span class="quick-action-icon"><i class="bi bi-telephone-fill"></i></span>
                    <strong><?= e($t['call_factory']) ?></strong>
                    <small><?= e($settings['phone'] ?? '') ?></small>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-6 col-lg-3">
                <a href="<?= whatsapp_link($waMsg) ?>" class="quick-action-card quick-action-whatsapp" target="_blank" rel="noopener">
                    <span class="quick-action-icon"><i class="bi bi-whatsapp"></i></span>
                    <strong><?= e($t['whatsapp_price']) ?></strong>
                </a>
            </div>
        </div>
    </div>
</section>
