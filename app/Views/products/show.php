<?php

require dirname(__DIR__) . '/partials/breadcrumbs.php';

$primaryImage = $images[0]['image_path'] ?? '';
$placeholderImg = asset('images/placeholder-product.svg');
$imageCount = count($images);

$waLink = whatsapp_link(product_whatsapp_message($product['name'], $lang));

$stoneLabel = !empty($product['stone_type']) ? stone_type_label($product['stone_type']) : '';

$settings = $settings ?? (new \App\Models\Setting())->getAll();

$phone = preg_replace('/\s+/', '', $settings['phone'] ?? '');

?>



<section class="product-detail-hero product-detail-hero-animated">

    <div class="product-detail-glow" aria-hidden="true"></div>

    <div class="container position-relative">

        <div class="row g-4 g-lg-5 align-items-start">

            <div class="col-lg-6 product-detail-reveal">
                <div class="product-gallery product-gallery-enhanced" id="productGallery" data-count="<?= $imageCount ?>">
                    <div class="product-gallery-stage">
                        <?php if ($imageCount > 1): ?>
                        <button type="button" class="product-gallery-nav product-gallery-prev" aria-label="Previous image">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <?php endif; ?>

                        <div class="product-gallery-main">
                            <div class="product-main-img-wrap">
                                <img src="<?= upload_url($primaryImage) ?>"
                                     id="productMainImage"
                                     class="product-main-img"
                                     alt="<?= e($product['name']) ?>"
                                     data-index="0"
                                     onerror="this.onerror=null;this.src='<?= e($placeholderImg) ?>';">
                                <?php if ($imageCount > 1): ?>
                                <span class="product-gallery-counter" id="productGalleryCounter">1 / <?= $imageCount ?></span>
                                <button type="button" class="product-gallery-zoom" id="productGalleryZoom" aria-label="View full image">
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($imageCount > 1): ?>
                        <button type="button" class="product-gallery-nav product-gallery-next" aria-label="Next image">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <?php endif; ?>
                    </div>

                    <?php if ($imageCount > 0): ?>
                    <div class="product-gallery-thumbs<?= $imageCount > 1 ? '' : ' product-gallery-thumbs--single' ?>" id="productGalleryThumbs">
                        <?php foreach ($images as $i => $img): ?>
                        <button type="button"
                            class="product-thumb-btn <?= $i === 0 ? 'active' : '' ?>"
                            data-index="<?= (int) $i ?>"
                            data-src="<?= e(upload_url($img['image_path'])) ?>"
                            aria-label="View image <?= $i + 1 ?>"
                            aria-current="<?= $i === 0 ? 'true' : 'false' ?>">
                            <img src="<?= upload_url($img['image_path']) ?>" alt="<?= e($product['name']) ?> — image <?= $i + 1 ?>" loading="lazy">
                        </button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>


            <div class="col-lg-6 product-detail-reveal product-detail-reveal-delay">

                <div class="product-info-panel product-info-panel-animated">

                    <div class="product-badges mb-3">

                        <?php if (!empty($product['category_name'])): ?>

                        <a href="<?= url($lang, 'products/' . $product['category_slug']) ?>" class="product-badge product-badge-brand"><?= e($product['category_name']) ?></a>

                        <?php endif; ?>

                        <?php if ($stoneLabel): ?>

                        <span class="product-badge product-badge-type"><?= e($stoneLabel) ?></span>

                        <?php endif; ?>

                    </div>



                    <h1 class="product-title"><?= e($product['name']) ?></h1>

                    <?php if (!empty($product['short_description'])): ?>

                    <p class="product-lead"><?= e($product['short_description']) ?></p>

                    <?php endif; ?>



                    <div class="product-trust-row">

                        <span class="product-trust-pill"><i class="bi bi-building-gear"></i> <?= e($t['direct_from_factory']) ?></span>

                        <span class="product-trust-pill"><i class="bi bi-truck"></i> <?= e($t['pan_india']) ?></span>

                        <?php if (!empty($sizes)): ?>

                        <span class="product-trust-pill"><i class="bi bi-rulers"></i> <?= count($sizes) ?> <?= e($t['sizes']) ?></span>

                        <?php endif; ?>

                    </div>



                    <div class="product-cta-group">

                        <a href="<?= e($waLink) ?>" class="btn btn-success btn-lg product-cta-wa product-cta-pulse" target="_blank" rel="noopener">

                            <i class="bi bi-whatsapp"></i> <?= e($t['get_quote']) ?>

                        </a>

                        <?php if ($phone): ?>

                        <a href="tel:<?= e($phone) ?>" class="btn btn-outline-primary btn-lg"><i class="bi bi-telephone-fill"></i> <?= e($t['call_now']) ?></a>

                        <?php endif; ?>

                    </div>



                    <div class="product-secondary-actions">

                        <?php if (!empty($product['brochure'])): ?>

                        <a href="<?= upload_url($product['brochure']) ?>" class="btn btn-sm btn-outline-secondary" download><i class="bi bi-download"></i> <?= e($t['download_brochure']) ?></a>

                        <?php endif; ?>

                        <form method="POST" action="<?= url($lang, 'compare/add') ?>" class="d-inline compare-form">

                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                            <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left-right"></i> <?= e($t['add_to_compare']) ?></button>

                        </form>

                        <?php if (!empty($sizes)): ?>

                        <a href="#product-sizes" class="btn btn-sm btn-outline-primary"><i class="bi bi-table"></i> <?= e($t['sizes']) ?></a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<?php if (!empty($sizes)): ?>

<section class="py-5 bg-white product-section-animated" id="product-sizes">

    <div class="container">

        <div class="section-heading text-center mb-4 reveal-on-scroll">

            <span class="section-label"><?= e($t['spec_section_label']) ?></span>

            <h2 class="section-title h3 mb-2"><?= e($t['sizes']) ?></h2>

        </div>

        <div class="spec-card product-size-card mx-auto reveal-on-scroll" style="max-width:900px">

            <div class="spec-card-header">

                <h3 class="spec-card-title"><i class="bi bi-table me-2"></i><?= e($product['name']) ?> — <?= e($t['spec_col_diameter']) ?>, <?= e($t['spec_col_bore']) ?>, <?= e($t['spec_col_thickness']) ?></h3>

            </div>

            <p class="table-scroll-hint d-md-none"><i class="bi bi-arrow-left-right"></i> <?= e($t['scroll_sizes']) ?></p>

            <div class="table-responsive table-scroll-wrap">

                <table class="table table-sm spec-table mb-0 product-size-table">

                    <thead>

                        <tr>

                            <th><?= e($t['spec_col_sl']) ?></th>

                            <th><?= e($t['spec_col_diameter']) ?></th>

                            <th><?= e($t['spec_col_bore']) ?></th>

                            <th><?= e($t['spec_col_thickness']) ?></th>

                            <th>Weight</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($sizes as $rowIdx => $size): ?>

                        <tr class="product-size-row" style="--row-i: <?= (int) $rowIdx ?>">

                            <td><?= e($size['sl_no'] ?? '—') ?></td>

                            <td><strong><?= e($size['diameter']) ?></strong></td>

                            <td><?= e($size['bore'] ?? '—') ?></td>

                            <td><?= e($size['thickness']) ?></td>

                            <td><?= e($size['weight'] ?: '—') ?></td>

                        </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

        <p class="text-center text-muted small mt-3 mb-0 reveal-on-scroll">

            <i class="bi bi-info-circle me-1"></i><?= e($t['order_easy_desc']) ?>

        </p>

    </div>

</section>

<?php endif; ?>



<section class="py-5 section-blue-light product-section-animated">

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-8">

                <?php if (!empty($product['description'])): ?>

                <div class="product-content-card mb-4 reveal-on-scroll">

                    <h3 class="product-content-title"><i class="bi bi-file-text me-2"></i>Description</h3>

                    <div class="product-content-body"><?= nl2br(e($product['description'])) ?></div>

                </div>

                <?php endif; ?>



                <div class="row g-3">

                    <?php if ($product['benefits']): ?>

                    <div class="col-md-6">

                        <div class="product-content-card h-100 reveal-on-scroll">

                            <h3 class="product-content-title"><i class="bi bi-check-circle me-2"></i><?= e($t['benefits']) ?></h3>

                            <ul class="product-feature-list">

                                <?php foreach (explode("\n", $product['benefits']) as $b): if (trim($b)): ?>

                                <li><i class="bi bi-check2"></i><?= e(trim($b)) ?></li>

                                <?php endif; endforeach; ?>

                            </ul>

                        </div>

                    </div>

                    <?php endif; ?>



                    <?php if ($product['applications']): ?>

                    <div class="col-md-6">

                        <div class="product-content-card h-100 reveal-on-scroll">

                            <h3 class="product-content-title"><i class="bi bi-gear me-2"></i><?= e($t['applications']) ?></h3>

                            <ul class="product-feature-list">

                                <?php foreach (explode("\n", $product['applications']) as $a): if (trim($a)): ?>

                                <li><i class="bi bi-dot"></i><?= e(trim($a)) ?></li>

                                <?php endif; endforeach; ?>

                            </ul>

                        </div>

                    </div>

                    <?php endif; ?>

                </div>

            </div>



            <div class="col-lg-4">

                <?php if (!empty($specs)): ?>

                <div class="product-content-card mb-4 reveal-on-scroll">

                    <h3 class="product-content-title"><i class="bi bi-list-check me-2"></i><?= e($t['specifications']) ?></h3>

                    <dl class="product-spec-list">

                        <?php foreach ($specs as $spec): ?>

                        <div class="product-spec-row">

                            <dt><?= e($spec['spec_key']) ?></dt>

                            <dd><?= e($spec['spec_value']) ?></dd>

                        </div>

                        <?php endforeach; ?>

                    </dl>

                </div>

                <?php endif; ?>



                <div class="product-quote-card reveal-on-scroll">

                    <div class="product-quote-icon"><i class="bi bi-whatsapp"></i></div>

                    <h4><?= e($t['whatsapp_price']) ?></h4>

                    <a href="<?= e($waLink) ?>" class="btn btn-success w-100" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i> <?= e($t['get_price']) ?></a>

                </div>

            </div>

        </div>

    </div>

</section>



<?php if (!empty($related)): ?>

<section class="py-5 bg-white products-grid-section product-section-animated">

    <div class="container">

        <div class="section-heading text-center mb-4 reveal-on-scroll">

            <span class="section-label"><?= e($t['related_products']) ?></span>

            <h2 class="section-title h3"><?= e($t['related_products']) ?></h2>

        </div>

        <div class="row g-4">

            <?php foreach ($related as $i => $rel): ?>

            <div class="col-6 col-md-4 col-lg-3">

                <?php

                $product = $rel;

                $revealIndex = $i;

                $showCategory = false;

                $compact = true;

                require dirname(__DIR__) . '/partials/product-card.php';

                ?>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<?php endif; ?>

<?php if ($imageCount > 0): ?>
<div class="product-lightbox" id="productLightbox" hidden aria-hidden="true">
    <button type="button" class="product-lightbox-close" id="productLightboxClose" aria-label="Close">
        <i class="bi bi-x-lg"></i>
    </button>
    <button type="button" class="product-lightbox-nav product-lightbox-prev" id="productLightboxPrev" aria-label="Previous image">
        <i class="bi bi-chevron-left"></i>
    </button>
    <img src="" alt="<?= e($product['name']) ?>" class="product-lightbox-img" id="productLightboxImg">
    <button type="button" class="product-lightbox-nav product-lightbox-next" id="productLightboxNext" aria-label="Next image">
        <i class="bi bi-chevron-right"></i>
    </button>
    <span class="product-lightbox-counter" id="productLightboxCounter"></span>
</div>
<?php endif; ?>