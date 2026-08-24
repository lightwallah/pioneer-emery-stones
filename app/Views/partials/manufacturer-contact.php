<?php $settings = $settings ?? (new \App\Models\Setting())->getAll(); ?>
<section class="mfg-contact-section py-5">
    <div class="container">
        <div class="mfg-contact-card">
            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <span class="section-label"><?= e($t['direct_from_factory']) ?></span>
                    <h2 class="section-title mb-2"><?= e($t['order_easy']) ?></h2>
                    <p class="text-muted mb-0"><?= e($t['order_easy_desc']) ?></p>
                </div>
                <div class="col-lg-7">
                    <div class="mfg-contact-actions">
                        <?php if (!empty($settings['phone'])): ?>
                        <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['phone'])) ?>" class="mfg-contact-btn mfg-btn-call">
                            <i class="bi bi-telephone-fill"></i>
                            <span>
                                <small><?= e($t['call_now']) ?></small>
                                <strong><?= e($settings['phone']) ?></strong>
                            </span>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($settings['phone_secondary'])): ?>
                        <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['phone_secondary'])) ?>" class="mfg-contact-btn mfg-btn-call">
                            <i class="bi bi-phone-fill"></i>
                            <span>
                                <small><?= e($t['phone']) ?> 2</small>
                                <strong><?= e($settings['phone_secondary']) ?></strong>
                            </span>
                        </a>
                        <?php endif; ?>
                        <a href="<?= whatsapp_link($t['wa_quote_msg'] ?? 'Hello, I need emery stones.') ?>" class="mfg-contact-btn mfg-btn-whatsapp" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp"></i>
                            <span>
                                <small>WhatsApp</small>
                                <strong><?= e($t['whatsapp_price']) ?></strong>
                            </span>
                        </a>
                    </div>
                    <div class="mfg-contact-info mt-3">
                        <?php if (!empty($settings['contact_person'])): ?>
                        <span><i class="bi bi-person-fill"></i> <?= e($settings['contact_person']) ?></span>
                        <?php endif; ?>
                        <span><i class="bi bi-geo-alt-fill"></i> <?= e($settings['address'] ?? '') ?></span>
                        <?php if (!empty($settings['gst_number'])): ?>
                        <span><i class="bi bi-receipt"></i> <?= e($t['gst_label']) ?>: <?= e($settings['gst_number']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
