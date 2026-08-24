<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="section-title text-center mb-3"><?= e($t['dealer_inquiry']) ?></h1>
                <p class="text-center text-muted mb-5">Partner with Pioneer Emery Stones as a dealer or distributor. Fill out the form below and our team will contact you.</p>

                <?php if ($success): ?>
                <div class="alert alert-success">
                    Thank you for your inquiry! We will contact you shortly.
                    <a href="<?= whatsapp_link('Hello Pioneer Emery Stones, I have submitted a dealer inquiry. Please contact me.') ?>" class="alert-link" target="_blank">Or contact us on WhatsApp</a>
                </div>
                <?php endif; ?>

                <div class="card border-0 shadow p-4">
                    <form method="POST" action="<?= url($lang, 'dealer-inquiry') ?>">
                        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['name']) ?> *</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['company_name']) ?> *</label>
                                <input type="text" name="company_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['phone']) ?> *</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['email']) ?></label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['city']) ?> *</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['state']) ?> *</label>
                                <input type="text" name="state" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['business_type']) ?></label>
                                <select name="business_type" class="form-select">
                                    <option value="">Select...</option>
                                    <option value="Dealer">Dealer</option>
                                    <option value="Distributor">Distributor</option>
                                    <option value="Retailer">Retailer</option>
                                    <option value="Flour Mill Owner">Flour Mill Owner</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?= e($t['annual_requirement']) ?></label>
                                <select name="annual_requirement" class="form-select">
                                    <option value="">Select...</option>
                                    <option value="Below 100 units">Below 100 units</option>
                                    <option value="100-500 units">100-500 units</option>
                                    <option value="500-1000 units">500-1000 units</option>
                                    <option value="1000+ units">1000+ units</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label"><?= e($t['message']) ?></label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your business and requirements..."></textarea>
                            </div>
                            <div class="col-12 d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-warning btn-lg"><?= e($t['submit_inquiry']) ?></button>
                                <a href="<?= whatsapp_link('Hello Pioneer Emery Stones, I am interested in becoming a dealer/distributor.') ?>" class="btn btn-success btn-lg" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp Direct</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
