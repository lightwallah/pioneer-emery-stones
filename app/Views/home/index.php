<?php
$heroPhone = preg_replace('/\s+/', '', $settings['phone'] ?? '');
$waQuote = whatsapp_link($t['wa_quote_msg'] ?? '');
$hasBanners = !empty($banners);
$stoneCategories = $stoneCategories ?? [];
$categoryIcons = [
    'horizontal-bolt-type' => 'bi-arrow-left-right',
    'horizontal-janta-type' => 'bi-disc',
    'vertical-danish-type' => 'bi-circle-half',
    'vertical-bush-type' => 'bi-layers-half',
    'vertical-rajkot-type' => 'bi-record-circle',
];

$brandLogos = [
    ['name' => 'Natraj', 'logo' => asset('images/brands/natraj.png'), 'slug' => 'natraj-emery-stones'],
    ['name' => 'Surabhi', 'logo' => asset('images/brands/surabhi.png'), 'slug' => 'surabhi-emery-stones'],
    ['name' => 'Ravi', 'logo' => asset('images/brands/ravi.png'), 'slug' => 'ravi-emery-stones'],
    ['name' => 'Savaliya', 'logo' => asset('images/brands/savaliya.png'), 'slug' => 'savaliya-emery-stones'],
    ['name' => 'Pioneer', 'logo' => asset('images/brands/pioneer.png'), 'slug' => 'products'],
];
$whyChoose = $t['landing_why_choose'] ?? [];
$processSteps = $processSteps ?? [];
$processSection = $processSection ?? [
    'title' => $t['landing_process_title'] ?? $t['manufacturing_process'] ?? '',
    'desc' => $t['landing_process_desc'] ?? '',
    'step_label' => $t['landing_process_step_label'] ?? 'Step',
];
$firstStep = $processSteps[0] ?? [];
$firstImage = $firstStep['image'] ?? asset('images/pioneer-banner.png');
$factoryItems = $t['landing_factory_items'] ?? [];
$heroPoints = array_slice($t['landing_hero_points'] ?? [], 0, 4);
$landingStats = $t['landing_stats'] ?? [];
$dealerBenefits = $t['landing_dealer_benefits'] ?? [];
?>

<div class="landing-page">

<?php if (!empty($banners)): ?>
<section class="landing-home-banners" aria-label="<?= e($t['home'] ?? 'Home') ?> banners">
    <?php if (count($banners) > 1): ?>
    <div id="homeBannerCarousel" class="carousel slide landing-banner-carousel" data-bs-ride="carousel" data-bs-interval="6000">
        <div class="carousel-indicators landing-banner-indicators">
            <?php foreach ($banners as $idx => $banner): ?>
            <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="<?= (int) $idx ?>"<?= $idx === 0 ? ' class="active" aria-current="true"' : '' ?> aria-label="<?= e($banner['title'] ?: 'Banner ' . ($idx + 1)) ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($banners as $idx => $banner): ?>
            <?php
                $bannerImg = upload_url($banner['image']);
                $bannerLink = trim($banner['link'] ?? '');
                if ($bannerLink !== '') {
                    if (preg_match('#^https?://#i', $bannerLink)) {
                        $bannerHref = $bannerLink;
                    } elseif (str_starts_with($bannerLink, '/')) {
                        $bannerHref = rtrim(base_url(), '/') . $bannerLink;
                    } else {
                        $bannerHref = url($lang, $bannerLink);
                    }
                } else {
                    $bannerHref = '';
                }
                $hasCopy = !empty($banner['title']) || !empty($banner['subtitle']) || !empty($banner['button_text']);
            ?>
            <div class="carousel-item<?= $idx === 0 ? ' active' : '' ?>">
                <div class="landing-banner-slide">
                    <?php if ($bannerHref): ?><a href="<?= e($bannerHref) ?>" class="landing-banner-media-link"><?php endif; ?>
                        <img src="<?= e($bannerImg) ?>" alt="<?= e($banner['title'] ?: 'Pioneer Emery Stones') ?>" class="landing-banner-img" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>">
                    <?php if ($bannerHref): ?></a><?php endif; ?>
                    <?php if ($hasCopy): ?>
                    <div class="landing-banner-caption">
                        <div class="container">
                            <?php if (!empty($banner['title'])): ?><h2 class="landing-banner-title"><?= e($banner['title']) ?></h2><?php endif; ?>
                            <?php if (!empty($banner['subtitle'])): ?><p class="landing-banner-subtitle"><?= e($banner['subtitle']) ?></p><?php endif; ?>
                            <?php if (!empty($banner['button_text']) && $bannerHref): ?>
                            <a href="<?= e($bannerHref) ?>" class="btn btn-light btn-lg landing-btn-shadow"><?= e($banner['button_text']) ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev landing-banner-control" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev" aria-label="Previous banner">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next landing-banner-control" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next" aria-label="Next banner">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
    <?php else: ?>
    <?php
        $banner = $banners[0];
        $bannerImg = upload_url($banner['image']);
        $bannerLink = trim($banner['link'] ?? '');
        if ($bannerLink !== '') {
            if (preg_match('#^https?://#i', $bannerLink)) {
                $bannerHref = $bannerLink;
            } elseif (str_starts_with($bannerLink, '/')) {
                $bannerHref = rtrim(base_url(), '/') . $bannerLink;
            } else {
                $bannerHref = url($lang, $bannerLink);
            }
        } else {
            $bannerHref = '';
        }
        $hasCopy = !empty($banner['title']) || !empty($banner['subtitle']) || !empty($banner['button_text']);
    ?>
    <div class="landing-banner-single">
        <div class="landing-banner-slide">
            <?php if ($bannerHref): ?><a href="<?= e($bannerHref) ?>" class="landing-banner-media-link"><?php endif; ?>
                <img src="<?= e($bannerImg) ?>" alt="<?= e($banner['title'] ?: 'Pioneer Emery Stones') ?>" class="landing-banner-img" loading="eager">
            <?php if ($bannerHref): ?></a><?php endif; ?>
            <?php if ($hasCopy): ?>
            <div class="landing-banner-caption">
                <div class="container">
                    <?php if (!empty($banner['title'])): ?><h2 class="landing-banner-title"><?= e($banner['title']) ?></h2><?php endif; ?>
                    <?php if (!empty($banner['subtitle'])): ?><p class="landing-banner-subtitle"><?= e($banner['subtitle']) ?></p><?php endif; ?>
                    <?php if (!empty($banner['button_text']) && $bannerHref): ?>
                    <a href="<?= e($bannerHref) ?>" class="btn btn-light btn-lg landing-btn-shadow"><?= e($banner['button_text']) ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<!-- Hero -->
<section class="landing-hero landing-hero--clean<?= $hasBanners ? ' landing-hero--compact' : '' ?>" id="top">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 landing-hero-content text-center">
                <h1 class="landing-hero-title"><?= e($t['landing_hero_title'] ?? '') ?></h1>
                <p class="landing-hero-subtitle mx-auto"><?= e($t['landing_hero_subtitle'] ?? '') ?></p>

                <?php if ($heroPoints): ?>
                <ul class="landing-hero-checklist landing-hero-checklist--inline">
                    <?php foreach ($heroPoints as $point): ?>
                    <li><i class="bi bi-check-circle-fill"></i><span><?= e($point) ?></span></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <div class="landing-hero-actions justify-content-center">
                    <a href="<?= e($waQuote) ?>" class="btn btn-success btn-lg landing-btn-wa" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp"></i><span><?= e($t['whatsapp_price']) ?></span>
                    </a>
                    <?php if ($heroPhone): ?>
                    <a href="tel:<?= e($heroPhone) ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-telephone-fill"></i><span><?= e($t['hero_cta_call']) ?></span>
                    </a>
                    <?php endif; ?>
                    <a href="<?= url($lang, 'products') ?>" class="btn btn-outline-primary btn-lg landing-btn-outline">
                        <i class="bi bi-grid"></i><span><?= e($t['hero_cta_products']) ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats bar -->
<section class="landing-stats-bar landing-stats-bar--flat">
    <div class="container">
        <div class="landing-stats-grid">
            <?php foreach (array_slice($landingStats, 0, 4) as $stat): ?>
            <div class="landing-stat-chip">
                <i class="bi <?= e($stat['icon'] ?? 'bi-award') ?>"></i>
                <div>
                    <strong><?= e($stat['value'] ?? '') ?></strong>
                    <span><?= e($stat['label'] ?? '') ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Brands -->
<section class="landing-section landing-brands landing-brands-logos landing-brands--upper" id="brands">
    <div class="container">
        <div class="landing-section-head text-center mb-3">
            <span class="section-label"><?= e($t['our_brands']) ?></span>
            <h2 class="section-title h4 mb-1"><?= e($t['landing_brands_title'] ?? $t['our_brands']) ?></h2>
            <p class="landing-section-desc mb-0"><?= e($t['our_brands_desc'] ?? '') ?></p>
        </div>
    </div>

    <div class="brand-logo-marquee brand-logo-marquee--single" aria-label="<?= e($t['our_brands']) ?>">
        <div class="brand-logo-track">
            <?php foreach (array_merge($brandLogos, $brandLogos, $brandLogos) as $brand): ?>
            <a href="<?= url($lang, $brand['slug']) ?>" class="brand-logo-slide" title="<?= e($brand['name']) ?>">
                <img src="<?= e($brand['logo']) ?>" alt="<?= e($brand['name']) ?>" loading="lazy" width="160" height="80">
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($stoneCategories)): ?>
<!-- Product categories -->
<section class="landing-section landing-featured landing-categories" id="products">
    <div class="container">
        <div class="landing-featured-head">
            <div>
                <span class="section-label"><?= e($t['products']) ?></span>
                <h2 class="section-title mb-1"><?= e($t['product_categories'] ?? $t['featured_products']) ?></h2>
                <p class="landing-section-desc mb-0"><?= e($t['our_products_desc'] ?? '') ?></p>
            </div>
            <a href="<?= url($lang, 'products') ?>" class="btn btn-outline-primary landing-featured-link d-none d-md-inline-flex">
                <?= e($t['view_all_products']) ?> <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3 g-md-4">
            <?php foreach ($stoneCategories as $i => $cat): ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <a href="<?= url($lang, 'products/' . $cat['slug']) ?>" class="landing-category-card product-reveal-item" style="--reveal-i: <?= (int) $i ?>">
                    <div class="landing-category-icon">
                        <i class="bi <?= e($categoryIcons[$cat['slug']] ?? 'bi-grid') ?>"></i>
                    </div>
                    <h3 class="landing-category-title"><?= e($cat['name']) ?></h3>
                    <?php if (!empty($cat['description'])): ?>
                    <p class="landing-category-desc"><?= e(truncate($cat['description'], 90)) ?></p>
                    <?php endif; ?>
                    <span class="landing-category-meta">
                        <i class="bi bi-box-seam"></i>
                        <?= (int) ($cat['product_count'] ?? 0) ?> <?= e($t['products']) ?>
                    </span>
                    <span class="landing-category-link"><?= e($t['view_all']) ?> <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="<?= url($lang, 'products') ?>" class="btn btn-primary btn-lg w-100"><?= e($t['view_all_products']) ?></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why Choose -->
<section class="landing-section landing-why">
    <div class="container">
        <div class="landing-section-head text-center">
            <span class="section-label"><?= e($t['why_choose_us']) ?></span>
            <h2 class="section-title"><?= e($t['landing_why_title'] ?? $t['why_choose_us']) ?></h2>
        </div>
        <div class="row g-3 g-md-4">
            <?php foreach ($whyChoose as $item): ?>
            <div class="col-6 col-md-3">
                <div class="landing-why-item">
                    <div class="landing-why-icon"><i class="bi <?= e($item['icon'] ?? 'bi-check-lg') ?>"></i></div>
                    <span><?= e($item['label'] ?? '') ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Manufacturing Process -->
<section class="landing-section landing-process landing-process--simple">
    <div class="container">
        <div class="landing-section-head text-center">
            <span class="section-label"><?= e($t['manufacturing_process']) ?></span>
            <h2 class="section-title"><?= e($processSection['title'] ?? '') ?></h2>
            <p class="landing-section-desc"><?= e($processSection['desc'] ?? '') ?></p>
        </div>

        <div class="landing-process-preview" id="processPreview" data-step-prefix="<?= e($processSection['step_label'] ?? 'Step') ?>">
            <div class="landing-process-preview-media">
                <img src="<?= e($firstImage) ?>" alt="<?= e($firstStep['label'] ?? '') ?>" class="landing-process-preview-img" id="processPreviewImg" loading="lazy">
            </div>
            <div class="landing-process-preview-content">
                <span class="landing-process-preview-step" id="processPreviewStep"><?= e($processSection['step_label'] ?? 'Step') ?> 1</span>
                <h3 class="landing-process-preview-title" id="processPreviewTitle"><?= e($firstStep['label'] ?? '') ?></h3>
                <p class="landing-process-preview-desc mb-0" id="processPreviewDesc"><?= e($firstStep['desc'] ?? '') ?></p>
            </div>
        </div>

        <div class="landing-process-flow" id="processFlow">
            <?php foreach ($processSteps as $idx => $step): ?>
            <button type="button"
                class="landing-process-step<?= $idx === 0 ? ' is-active' : '' ?>"
                data-step="<?= (int) $idx ?>"
                data-image="<?= e($step['image'] ?? asset('images/pioneer-banner.png')) ?>"
                data-pos="<?= e($step['pos'] ?? 'center') ?>"
                data-label="<?= e($step['label'] ?? '') ?>"
                data-desc="<?= e($step['desc'] ?? '') ?>"
                aria-pressed="<?= $idx === 0 ? 'true' : 'false' ?>"
                aria-label="<?= e($step['label'] ?? '') ?>">
                <div class="landing-process-icon"><span><?= $idx + 1 ?></span><i class="bi <?= e($step['icon'] ?? 'bi-gear') ?>"></i></div>
                <span class="landing-process-label"><?= e($step['label'] ?? '') ?></span>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Factory Gallery -->
<section class="landing-section landing-factory landing-factory--strip">
    <div class="container">
        <div class="landing-factory-strip">
            <div class="landing-factory-strip-copy">
                <span class="section-label"><?= e($t['landing_factory_label'] ?? '') ?></span>
                <h2 class="section-title h4 mb-1"><?= e($t['landing_factory_title'] ?? '') ?></h2>
                <p class="landing-section-desc mb-0"><?= e($t['landing_factory_desc'] ?? '') ?></p>
            </div>
            <ul class="landing-factory-strip-list">
                <?php foreach ($factoryItems as $item): ?>
                <li><i class="bi <?= e($item['icon'] ?? 'bi-building') ?>"></i><span><?= e($item['label'] ?? '') ?></span></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url($lang, 'about') ?>" class="btn btn-outline-primary"><?= e($t['landing_view_more_photos'] ?? $t['learn_more']) ?></a>
        </div>
    </div>
</section>

<!-- Testimonials | Dealer | Enquiry -->
<section class="landing-section landing-bottom-trio">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="landing-panel landing-testimonials-panel h-100">
                    <div class="landing-panel-icon"><i class="bi bi-chat-quote-fill"></i></div>
                    <span class="section-label"><?= e($t['testimonials']) ?></span>
                    <h2 class="section-title h4"><?= e($t['landing_testimonials_title'] ?? $t['testimonials']) ?></h2>
                    <div class="landing-stars mb-3" aria-hidden="true">
                        <?php for ($i = 0; $i < 5; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                    </div>
                    <?php if (!empty($testimonials)): ?>
                    <?php foreach (array_slice($testimonials, 0, 2) as $review): ?>
                    <blockquote class="landing-quote">"<?= e($review['review']) ?>"</blockquote>
                    <p class="landing-quote-author">
                        <strong><?= e($review['name'] ?? '') ?></strong>
                        <?php if (!empty($review['company'])): ?><span><?= e($review['company']) ?></span><?php endif; ?>
                    </p>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <blockquote class="landing-quote">"<?= e($t['landing_default_testimonial'] ?? '') ?>"</blockquote>
                    <p class="landing-quote-author"><strong><?= e($t['landing_default_testimonial_author'] ?? '') ?></strong></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="landing-panel landing-dealer-panel h-100">
                    <div class="landing-panel-icon landing-panel-icon-light"><i class="bi bi-handshake-fill"></i></div>
                    <span class="section-label section-label-light"><?= e($t['dealer_cta']) ?></span>
                    <h2 class="section-title h4 text-white"><?= e($t['landing_dealer_title'] ?? $t['dealer_cta']) ?></h2>
                    <ul class="landing-dealer-list">
                        <?php foreach ($dealerBenefits as $benefit): ?>
                        <li><i class="bi bi-check-circle-fill"></i><?= e($benefit) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?= url($lang, 'dealer-inquiry') ?>" class="btn btn-light w-100 btn-lg fw-bold"><?= e($t['landing_dealer_btn'] ?? $t['dealer_inquiry']) ?></a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="landing-panel landing-enquiry-panel h-100">
                    <div class="landing-enquiry-head">
                        <div class="landing-panel-icon landing-panel-icon-green"><i class="bi bi-whatsapp"></i></div>
                        <div>
                            <h2 class="section-title h5 mb-0"><?= e($t['landing_enquiry_title'] ?? '') ?></h2>
                        </div>
                    </div>
                    <form class="home-enquiry-form" id="homeEnquiryForm" novalidate>
                        <div class="mb-2">
                            <input type="text" name="name" class="form-control" placeholder="<?= e($t['name']) ?> *" required>
                        </div>
                        <div class="mb-2">
                            <input type="tel" name="phone" class="form-control" placeholder="<?= e($t['phone']) ?> *" required inputmode="tel">
                        </div>
                        <div class="mb-2">
                            <select name="product" class="form-select">
                                <option value=""><?= e($t['landing_select_product'] ?? $t['products']) ?></option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= e($cat['name']) ?>"><?= e($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select name="size" class="form-select">
                                <option value=""><?= e($t['landing_select_size'] ?? $t['sizes']) ?></option>
                                <option>08"</option><option>10"</option><option>12"</option><option>14"</option>
                                <option>16"</option><option>18"</option><option>20"</option><option>24"</option><option>30"</option>
                            </select>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="text" name="state" class="form-control" placeholder="<?= e($t['state']) ?>">
                            </div>
                            <div class="col-6">
                                <input type="text" name="city" class="form-control" placeholder="<?= e($t['city']) ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="quantity" class="form-control" placeholder="<?= e($t['landing_quantity'] ?? 'Quantity') ?>">
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg landing-btn-wa"><i class="bi bi-whatsapp"></i> <?= e($t['whatsapp_price']) ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

<script>
window.PIONEER_WA_BASE = <?= json_encode(whatsapp_link('')) ?>;
window.PIONEER_WA_INTRO = <?= json_encode($t['landing_wa_enquiry_intro'] ?? 'Hello Pioneer Emery Stones, I need a price quote.') ?>;

(function () {
  var preview = document.getElementById('processPreview');
  var flow = document.getElementById('processFlow');
  if (!preview || !flow) return;

  var img = document.getElementById('processPreviewImg');
  var titleEl = document.getElementById('processPreviewTitle');
  var descEl = document.getElementById('processPreviewDesc');
  var stepLabel = document.getElementById('processPreviewStep');
  var stepPrefix = preview.getAttribute('data-step-prefix') || 'Step';
  var animating = false;

  function activateStep(btn) {
    if (animating) return;
    animating = true;

    var stepNum = parseInt(btn.getAttribute('data-step'), 10) + 1;
    var image = btn.getAttribute('data-image');
    var pos = btn.getAttribute('data-pos') || 'center';
    var label = btn.getAttribute('data-label') || '';
    var textDesc = btn.getAttribute('data-desc') || '';

    flow.querySelectorAll('.landing-process-step').forEach(function (b) {
      b.classList.remove('is-active');
      b.setAttribute('aria-pressed', 'false');
    });
    btn.classList.add('is-active');
    btn.setAttribute('aria-pressed', 'true');

    preview.classList.add('is-animating');
    preview.classList.remove('is-entering');

    setTimeout(function () {
      if (img && image) {
        img.src = image;
        img.style.objectPosition = pos;
        img.alt = label;
      }
      if (stepLabel) stepLabel.textContent = stepPrefix + ' ' + stepNum;
      if (titleEl) titleEl.textContent = label;
      if (descEl) descEl.textContent = textDesc;

      preview.classList.remove('is-animating');
      preview.classList.add('is-entering');
      setTimeout(function () {
        preview.classList.remove('is-entering');
        animating = false;
      }, 560);
    }, 220);
  }

  flow.addEventListener('click', function (e) {
    var btn = e.target.closest('.landing-process-step');
    if (!btn || !flow.contains(btn)) return;
    e.preventDefault();
    if (btn.classList.contains('is-active')) return;
    activateStep(btn);
  });
})();
</script>
