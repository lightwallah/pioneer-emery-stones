<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="page-hero py-5">
    <div class="container text-center">
        <div class="track-hero-icon mx-auto mb-3"><i class="bi bi-truck-front-fill"></i></div>
        <h1 class="section-title mb-2"><?= e($t['track_delivery']) ?></h1>
        <p class="text-muted col-lg-7 mx-auto mb-0"><?= e($t['track_delivery_desc']) ?></p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="track-card p-4 p-md-5">
                    <?php if ($error): ?>
                    <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>

                    <?php if ($redirectUrl): ?>
                    <div class="alert alert-info d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle-fill mt-1"></i>
                        <div>
                            <strong><?= e($t['track_redirecting']) ?></strong>
                            <p class="mb-2 small"><?= e($t['track_redirect_note']) ?></p>
                            <a href="<?= e($redirectUrl) ?>" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-box-arrow-up-right me-1"></i><?= e($t['track_open_portal']) ?>
                            </a>
                        </div>
                    </div>
                    <script>window.open(<?= json_encode($redirectUrl) ?>, '_blank');</script>
                    <?php endif; ?>

                    <form method="POST" action="<?= url($lang, 'track-delivery') ?>" class="track-form">
                        <label class="form-label fw-semibold" for="tracking_id"><?= e($t['track_enter_id']) ?></label>
                        <div class="input-group input-group-lg mb-3">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input type="text"
                                   id="tracking_id"
                                   name="tracking_id"
                                   class="form-control"
                                   value="<?= e($trackingId) ?>"
                                   placeholder="<?= e($t['track_id_placeholder']) ?>"
                                   required
                                   autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search me-2"></i><?= e($t['track_now']) ?>
                        </button>
                    </form>

                    <?php if (!$trackBaseUrl): ?>
                    <div class="track-notice mt-4">
                        <i class="bi bi-exclamation-circle"></i>
                        <p class="mb-0 small"><?= e($t['track_url_not_set']) ?></p>
                    </div>
                    <?php endif; ?>

                    <hr class="my-4">

                    <div class="track-help">
                        <h6 class="fw-bold text-primary mb-3"><?= e($t['track_need_help']) ?></h6>
                        <p class="text-muted small mb-3"><?= e($t['track_help_desc']) ?></p>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($settings['phone'])): ?>
                            <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['phone'])) ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-telephone me-1"></i><?= e($settings['phone']) ?>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($settings['phone_secondary'])): ?>
                            <a href="tel:<?= e(preg_replace('/\s+/', '', $settings['phone_secondary'])) ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-phone me-1"></i><?= e($settings['phone_secondary']) ?>
                            </a>
                            <?php endif; ?>
                            <a href="<?= whatsapp_link($t['track_whatsapp_msg'] ?? 'Hello, I need help tracking my delivery.') ?>" class="btn btn-success btn-sm" target="_blank">
                                <i class="bi bi-whatsapp me-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
