<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="section-title text-center mb-5"><?= e($t['faq']) ?></h1>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faqs as $i => $faq): ?>
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $faq['id'] ?>">
                                <?= e($faq['question']) ?>
                            </button>
                        </h2>
                        <div id="faq<?= $faq['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted"><?= nl2br(e($faq['answer'])) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-5">
                    <p>Still have questions?</p>
                    <a href="<?= whatsapp_link('Hello Pioneer Emery Stones, I have a question about your emery stones.') ?>" class="btn btn-success me-2" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp</a>
                    <a href="<?= url($lang, 'contact') ?>" class="btn btn-primary"><?= e($t['contact']) ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
