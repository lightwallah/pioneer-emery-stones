<section class="features-section py-5 bg-white">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="features-banner">
                    <div class="features-banner-inner">
                        <span class="features-watermark"><i class="bi bi-hexagon-fill"></i></span>
                        <h2 class="features-title"><?= e($t['stone_features_title']) ?></h2>
                        <p class="features-subtitle"><?= e($t['tagline']) ?></p>
                        <div class="brand-pills mt-4">
                            <span class="brand-pill">नटराज / Nataraj</span>
                            <span class="brand-pill">सुरभि / Surabhi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <ul class="stone-features-list">
                    <?php foreach ($t['stone_features'] as $feature): ?>
                    <li><i class="bi bi-check-circle-fill"></i><span><?= e($feature) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
