<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="section-title mb-4">About Pioneer Emery Stones</h1>
        <div class="row g-5">
            <div class="col-lg-8">
                <p class="lead text-muted">With over <?= e($settings['years_experience'] ?? '30') ?> years of experience, Pioneer Emery Stones is a leading manufacturer and supplier of premium emery stones for flour mills across India.</p>
                <p>Based in Rajasthan — the heart of India's flour milling industry — we manufacture and supply Natraj, Surabhi, Ravi, and Savaliya brand emery stones trusted by thousands of flour mill operators, dealers, and distributors nationwide.</p>

                <h3 class="mt-5 text-primary"><?= e($t['manufacturing_process']) ?></h3>
                <p>Our manufacturing process involves careful selection of high-grade emery raw materials, precision shaping using advanced machinery, heat treatment for optimal hardness, and rigorous quality testing at every stage. Each stone is crafted to deliver consistent grinding performance and extended service life.</p>

                <h3 class="mt-5 text-primary"><?= e($t['mission_vision']) ?></h3>
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded h-100">
                            <h5><i class="bi bi-bullseye text-warning me-2"></i>Mission</h5>
                            <p class="mb-0 text-muted">To provide the highest quality emery stones that enable flour mill operators to produce superior flour while maximizing operational efficiency and profitability.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded h-100">
                            <h5><i class="bi bi-eye text-warning me-2"></i>Vision</h5>
                            <p class="mb-0 text-muted">To be India's most trusted emery stone manufacturer, recognized globally for quality, innovation, and customer satisfaction.</p>
                        </div>
                    </div>
                </div>

                <h3 class="mt-5 text-primary"><?= e($t['quality_standards']) ?></h3>
                <ul class="text-muted">
                    <li>Premium grade emery raw material sourcing</li>
                    <li>Precision manufacturing with strict tolerances</li>
                    <li>Multi-stage quality inspection and testing</li>
                    <li>Consistent hardness and grinding performance</li>
                    <li>Compliance with industry standards</li>
                </ul>

                <h3 class="mt-5 text-primary"><?= e($t['company_strengths']) ?></h3>
                <div class="row g-3">
                    <?php foreach (['In-house manufacturing facility', 'Wide product range (12" to 24")', 'Strong dealer network across India', 'Competitive wholesale pricing', 'Timely delivery & logistics', 'Dedicated customer support'] as $strength): ?>
                    <div class="col-md-6"><div class="d-flex align-items-center"><i class="bi bi-check-circle-fill text-success me-2"></i><?= $strength ?></div></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow p-4 sticky-top" style="top: 100px;">
                    <h5 class="text-primary mb-3">Quick Contact</h5>
                    <p><i class="bi bi-telephone me-2"></i><?= e($settings['phone'] ?? '') ?></p>
                    <p><i class="bi bi-envelope me-2"></i><?= e($settings['email'] ?? '') ?></p>
                    <a href="<?= whatsapp_link('Hello Pioneer Emery Stones, I would like to know more about your company.') ?>" class="btn btn-success w-100 mb-2" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp Us</a>
                    <a href="<?= url($lang, 'dealer-inquiry') ?>" class="btn btn-warning w-100"><?= e($t['dealer_inquiry']) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
