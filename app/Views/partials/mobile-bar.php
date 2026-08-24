<?php

$settings = $settings ?? (new \App\Models\Setting())->getAll();

$phone = preg_replace('/\s+/', '', $settings['phone'] ?? '');

$waQuote = whatsapp_link($t['wa_quote_msg'] ?? 'Hello, I need emery stones. Please share price.');

$uri = $_SERVER['REQUEST_URI'] ?? '';

?>

<nav class="mobile-bottom-bar d-lg-none" aria-label="Quick actions">

    <a href="<?= url($lang) ?>" class="mobile-bar-item <?= preg_match('#/' . preg_quote($lang, '#') . '/?$#', $uri) ? 'active' : '' ?>">

        <i class="bi bi-house-door-fill"></i>

        <span><?= e($t['mobile_home']) ?></span>

    </a>

    <a href="<?= url($lang, 'products') ?>" class="mobile-bar-item <?= str_contains($uri, '/products') ? 'active' : '' ?>">

        <i class="bi bi-grid-fill"></i>

        <span><?= e($t['products']) ?></span>

    </a>

    <?php if ($phone): ?>

    <a href="tel:<?= e($phone) ?>" class="mobile-bar-item mobile-bar-item-call">

        <i class="bi bi-telephone-fill"></i>

        <span><?= e($t['mobile_call']) ?></span>

    </a>

    <?php endif; ?>

    <a href="<?= e($waQuote) ?>" class="mobile-bar-item mobile-bar-item-whatsapp mobile-bar-item-featured" target="_blank" rel="noopener">

        <span class="mobile-bar-wa-circle"><i class="bi bi-whatsapp"></i></span>

        <span><?= e($t['mobile_wa']) ?></span>

    </a>

    <a href="<?= url($lang, 'contact') ?>" class="mobile-bar-item <?= str_contains($uri, '/contact') ? 'active' : '' ?>">

        <i class="bi bi-chat-dots-fill"></i>

        <span><?= e($t['mobile_contact']) ?></span>

    </a>

</nav>


