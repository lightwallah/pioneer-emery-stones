<?php

$settings = $settings ?? (new \App\Models\Setting())->getAll();

$trackPageUrl = url($lang, 'track-delivery');

$phone = preg_replace('/\s+/', '', $settings['phone'] ?? '');

$waQuote = whatsapp_link($t['wa_quote_msg'] ?? 'Hello, I need emery stones. Please share price.');

$altLang = $lang === 'en' ? 'hi' : 'en';

$langSwitchUrl = str_replace('/' . $lang, '/' . $altLang, $_SERVER['REQUEST_URI'] ?? url($lang));

$langSwitchLabel = $lang === 'en' ? ($t['switch_to_hindi'] ?? 'हिंदी') : ($t['switch_to_english'] ?? 'English');

$fbUrl = trim($settings['facebook_url'] ?? '');
$igUrl = trim($settings['instagram_url'] ?? '');
$ytUrl = trim($settings['youtube_url'] ?? '');
$gstNo = $settings['gst_number'] ?? '';
?>

<header class="site-header sticky-top">

    <div class="header-top d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="header-top-left">
                <?php if ($gstNo): ?>
                <span class="header-top-gst"><i class="bi bi-receipt"></i><?= e($t['gst_label']) ?>: <?= e($gstNo) ?></span>
                <?php endif; ?>
                <span class="header-top-location"><i class="bi bi-geo-alt-fill"></i><?= e($t['made_in_jodhpur']) ?> · <?= e($t['pan_india']) ?></span>
            </div>
            <div class="header-top-social">
                <?php if ($fbUrl): ?>
                <a href="<?= e($fbUrl) ?>" class="header-social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <?php endif; ?>
                <?php if ($igUrl): ?>
                <a href="<?= e($igUrl) ?>" class="header-social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <?php endif; ?>
                <?php if ($ytUrl): ?>
                <a href="<?= e($ytUrl) ?>" class="header-social-link" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg main-navbar">

        <div class="container">

            <a class="navbar-brand" href="<?= url($lang) ?>">

                <img src="<?= site_logo_url($settings) ?>" alt="Pioneer Emery Stones" class="brand-logo-img">

                <span class="brand-text d-none d-md-inline">

                    <span class="brand-title">Pioneer</span>

                    <span class="brand-subtitle d-none d-sm-inline">Emery Stones</span>

                </span>

            </a>



            <div class="navbar-mobile-actions d-lg-none">

                <a href="<?= e($langSwitchUrl) ?>" class="mobile-header-btn mobile-header-lang" aria-label="Switch language"><?= e($langSwitchLabel) ?></a>

                <?php if ($phone): ?>

                <a href="tel:<?= e($phone) ?>" class="mobile-header-btn mobile-header-call" aria-label="<?= e($t['call_now']) ?>"><i class="bi bi-telephone-fill"></i></a>

                <?php endif; ?>

                <a href="<?= e($waQuote) ?>" class="mobile-header-btn mobile-header-wa" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">

                    <span class="navbar-toggler-icon"></span>

                </button>

            </div>



            <div class="collapse navbar-collapse" id="mainNav">

                <button type="button" class="mobile-menu-close d-lg-none" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>



                <div class="mobile-menu-cta d-lg-none">

                    <?php if ($phone): ?>

                    <a href="tel:<?= e($phone) ?>" class="btn btn-primary btn-lg w-100 mb-2"><i class="bi bi-telephone-fill me-2"></i><?= e($t['hero_cta_call']) ?></a>

                    <?php endif; ?>

                    <a href="<?= e($waQuote) ?>" class="btn btn-success btn-lg w-100" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-2"></i><?= e($t['hero_cta_wa']) ?></a>

                    <p class="text-muted small text-center mt-2 mb-0"><?= e($t['tap_to_call']) ?></p>

                </div>



                <ul class="navbar-nav mx-lg-auto mobile-nav-list">

                    <li class="nav-item"><a class="nav-link <?= nav_active($lang) ?>" href="<?= url($lang) ?>"><i class="bi bi-house-door d-lg-none me-2"></i><?= e($t['home']) ?></a></li>

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle <?= nav_active($lang, 'products') ?>" href="#" data-bs-toggle="dropdown"><i class="bi bi-grid d-lg-none me-2"></i><?= e($t['products']) ?></a>

                        <ul class="dropdown-menu dropdown-menu-nav">

                            <li><a class="dropdown-item" href="<?= url($lang, 'products') ?>"><?= e($t['view_all_products']) ?></a></li>

                            <li><hr class="dropdown-divider"></li>

                            <?php foreach ((new \App\Models\Category())->getAll($lang) as $cat): ?>

                            <li><a class="dropdown-item" href="<?= url($lang, 'products/' . $cat['slug']) ?>"><?= e($cat['name']) ?></a></li>

                            <?php endforeach; ?>

                        </ul>

                    </li>

                    <li class="nav-item"><a class="nav-link" href="<?= url($lang) ?>#specifications"><i class="bi bi-rulers d-lg-none me-2"></i><?= e($t['size_chart']) ?></a></li>

                    <li class="nav-item"><a class="nav-link <?= nav_active($lang, 'track-delivery') ?>" href="<?= e($trackPageUrl) ?>"><i class="bi bi-truck d-lg-none me-2"></i><?= e($t['track_delivery']) ?></a></li>

                    <li class="nav-item"><a class="nav-link <?= nav_active($lang, 'about') ?>" href="<?= url($lang, 'about') ?>"><i class="bi bi-building d-lg-none me-2"></i><?= e($t['about']) ?></a></li>

                    <li class="nav-item"><a class="nav-link <?= nav_active($lang, 'blog') ?>" href="<?= url($lang, 'blog') ?>"><i class="bi bi-journal-text d-lg-none me-2"></i><?= e($t['blog']) ?></a></li>

                    <li class="nav-item"><a class="nav-link <?= nav_active($lang, 'contact') ?>" href="<?= url($lang, 'contact') ?>"><i class="bi bi-telephone d-lg-none me-2"></i><?= e($t['contact']) ?></a></li>

                </ul>



                <ul class="navbar-nav navbar-actions align-items-lg-center">

                    <li class="nav-item dropdown d-none d-lg-block">

                        <a class="nav-lang-btn dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-globe2"></i><span><?= strtoupper($lang) ?></span></a>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-nav">

                            <?php foreach ($config['languages'] as $altLangItem): ?>

                            <li><a class="dropdown-item <?= $altLangItem === $lang ? 'active' : '' ?>" href="<?= e(str_replace('/' . $lang, '/' . $altLangItem, $_SERVER['REQUEST_URI'] ?? url($lang))) ?>"><?= $altLangItem === 'en' ? 'English' : 'हिंदी' ?></a></li>

                            <?php endforeach; ?>

                        </ul>

                    </li>

                    <li class="nav-item d-lg-none w-100">

                        <a class="nav-lang-btn w-100 justify-content-center" href="<?= e($langSwitchUrl) ?>"><i class="bi bi-translate"></i> <?= e($langSwitchLabel) ?></a>

                    </li>

                    <?php if ($phone): ?>
                    <li class="nav-item d-none d-xl-flex align-items-center">
                        <a href="tel:<?= e($phone) ?>" class="header-nav-phone">
                            <i class="bi bi-telephone-fill"></i>
                            <span><?= e($settings['phone'] ?? '') ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item d-none d-lg-block">

                        <a class="btn btn-whatsapp-nav" href="<?= e($waQuote) ?>" target="_blank" rel="noopener">

                            <i class="bi bi-whatsapp"></i><span class="d-none d-xl-inline ms-1"><?= e($t['whatsapp_price']) ?></span>

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>


