<?php
$categories = $categories ?? (new \App\Models\Category())->getAll($lang);
$fbUrl = trim($settings['facebook_url'] ?? '');
$igUrl = trim($settings['instagram_url'] ?? '');
$ytUrl = trim($settings['youtube_url'] ?? '');
?>
<footer class="site-footer">
    <div class="container pt-5 pb-4">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-3">
                    <img src="<?= site_logo_url($settings) ?>" alt="Pioneer Emery Stones" class="footer-logo-img">
                    <div>
                        <strong>Pioneer Emery Stones</strong>
                        <small class="d-block text-muted"><?= e($t['direct_from_factory']) ?> · Jodhpur</small>
                    </div>
                </div>
                <p class="footer-desc small"><?= e($t['mfg_tagline']) ?></p>
                <?php if ($fbUrl || $igUrl || $ytUrl): ?>
                <div class="footer-social">
                    <?php if ($fbUrl): ?><a href="<?= e($fbUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a><?php endif; ?>
                    <?php if ($igUrl): ?><a href="<?= e($igUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a><?php endif; ?>
                    <?php if ($ytUrl): ?><a href="<?= e($ytUrl) ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube"></i></a><?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="footer-downloads d-flex flex-column gap-2 mt-3">
                    <a href="<?= url($lang, 'products') ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-download me-1"></i><?= e($t['landing_download_catalogue'] ?? $t['download_brochure']) ?></a>
                    <a href="<?= url($lang) ?>#specifications" class="btn btn-outline-light btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i><?= e($t['landing_size_chart_pdf'] ?? $t['size_chart']) ?></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading"><?= e($t['landing_quick_links'] ?? 'Quick Links') ?></h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= url($lang) ?>"><?= e($t['home']) ?></a></li>
                    <li><a href="<?= url($lang, 'products') ?>"><?= e($t['products']) ?></a></li>
                    <li><a href="<?= url($lang) ?>#specifications"><?= e($t['size_chart']) ?></a></li>
                    <li><a href="<?= url($lang, 'track-delivery') ?>"><?= e($t['track_delivery']) ?></a></li>
                    <li><a href="<?= url($lang, 'about') ?>"><?= e($t['about']) ?></a></li>
                    <li><a href="<?= url($lang, 'blog') ?>"><?= e($t['blog']) ?></a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="footer-heading"><?= e($t['products']) ?></h6>
                <ul class="list-unstyled footer-links">
                    <?php foreach ($categories as $cat): ?>
                    <li><a href="<?= url($lang, 'products/' . $cat['slug']) ?>"><?= e($cat['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="mb-0 text-center small">&copy; <?= date('Y') ?> Pioneer Emery Stones · <?= e($t['landing_made_with_love'] ?? 'Made in Jodhpur, Rajasthan') ?></p>
        </div>
    </div>
</footer>
