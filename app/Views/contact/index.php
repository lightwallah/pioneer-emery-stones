<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="section-title mb-5"><?= e($t['contact']) ?></h1>

        <?php if ($success): ?>
        <div class="alert alert-success">Thank you! Your message has been sent. We will contact you soon.</div>
        <?php endif; ?>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="card border-0 shadow p-4 h-100">
                    <h5 class="text-primary mb-4">Contact Information</h5>
                    <p><i class="bi bi-telephone text-warning me-2"></i><a href="tel:<?= e($settings['phone'] ?? '') ?>" class="text-decoration-none"><?= e($settings['phone'] ?? '') ?></a></p>
                    <p><i class="bi bi-envelope text-warning me-2"></i><a href="mailto:<?= e($settings['email'] ?? '') ?>" class="text-decoration-none"><?= e($settings['email'] ?? '') ?></a></p>
                    <p><i class="bi bi-geo-alt text-warning me-2"></i><?= e($settings['address'] ?? '') ?></p>
                    <a href="<?= whatsapp_link('Hello Pioneer Emery Stones, I would like to get in touch.') ?>" class="btn btn-success w-100 mt-3" target="_blank"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow p-4">
                    <form method="POST" action="<?= url($lang, 'contact') ?>">
                        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['name']) ?> *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['phone']) ?> *</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?= e($t['email']) ?></label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?= e($t['message']) ?></label>
                                <textarea name="message" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg"><?= e($t['send_message']) ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($settings['google_map_embed'])): ?>
        <div class="mt-5 rounded overflow-hidden shadow">
            <?= $settings['google_map_embed'] ?>
        </div>
        <?php endif; ?>
    </div>
</section>
