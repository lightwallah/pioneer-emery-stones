<div class="admin-topbar">
    <h1 class="admin-page-title">SEO Management</h1>
</div>

<?php if ($saved): ?><div class="alert alert-success">SEO settings saved!</div><?php endif; ?>

<?php
$pages = [
    'home' => 'Homepage',
    'about' => 'About Us',
    'products' => 'Products Listing',
    'contact' => 'Contact',
    'faq' => 'FAQ',
    'dealer-inquiry' => 'Dealer Inquiry',
    'track-delivery' => 'Track Delivery',
];
foreach ($pages as $pageKey => $pageLabel):
?>
<div class="admin-card mb-4">
    <div class="admin-card-header"><?= $pageLabel ?> — SEO</div>
    <div class="admin-card-body">
        <form method="POST">
            <input type="hidden" name="page_key" value="<?= $pageKey ?>">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#seo-<?= $pageKey ?>-en">English</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seo-<?= $pageKey ?>-hi">Hindi</a></li>
            </ul>
            <div class="tab-content">
                <?php foreach (['en', 'hi'] as $lang): $seo = $seoByPage[$pageKey][$lang] ?? []; ?>
                <div class="tab-pane fade <?= $lang === 'en' ? 'show active' : '' ?>" id="seo-<?= $pageKey ?>-<?= $lang ?>">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Meta Title</label><input type="text" name="meta_title_<?= $lang ?>" class="form-control" value="<?= htmlspecialchars($seo['meta_title'] ?? '') ?>"></div>
                        <div class="col-12"><label class="form-label">Meta Description</label><textarea name="meta_description_<?= $lang ?>" class="form-control" rows="2"><?= htmlspecialchars($seo['meta_description'] ?? '') ?></textarea></div>
                        <div class="col-md-6"><label class="form-label">Keywords</label><input type="text" name="meta_keywords_<?= $lang ?>" class="form-control" value="<?= htmlspecialchars($seo['meta_keywords'] ?? '') ?>"></div>
                        <div class="col-md-6"><label class="form-label">OG Title</label><input type="text" name="og_title_<?= $lang ?>" class="form-control" value="<?= htmlspecialchars($seo['og_title'] ?? '') ?>"></div>
                        <div class="col-12"><label class="form-label">OG Description</label><textarea name="og_description_<?= $lang ?>" class="form-control" rows="2"><?= htmlspecialchars($seo['og_description'] ?? '') ?></textarea></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check-lg me-1"></i> Save <?= $pageLabel ?> SEO</button>
        </form>
    </div>
</div>
<?php endforeach; ?>
