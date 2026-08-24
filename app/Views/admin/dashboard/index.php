<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Dashboard</h1>
        <p class="admin-page-subtitle">Welcome back — manage your products, inquiries & website.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= $baseUrl ?>/admin/products/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Product</a>
        <a href="<?= $baseUrl ?>/admin/banners/create" class="btn btn-outline-primary"><i class="bi bi-image me-1"></i> Add Banner</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['label' => 'Products', 'value' => $stats['products'], 'icon' => 'bi-box-seam', 'color' => '#0056b3', 'bg' => '#e8f2fc', 'link' => 'products'],
        ['label' => 'Inquiries', 'value' => $stats['inquiries'], 'icon' => 'bi-envelope', 'color' => '#198754', 'bg' => '#e8f8ef', 'link' => 'inquiries', 'badge' => $stats['unread_inquiries']],
        ['label' => 'Dealers', 'value' => $stats['dealer_inquiries'], 'icon' => 'bi-building', 'color' => '#e67e22', 'bg' => '#fff4e6', 'link' => 'dealer-inquiries', 'badge' => $stats['unread_dealer']],
        ['label' => 'Blogs', 'value' => $stats['blogs'], 'icon' => 'bi-journal-text', 'color' => '#6f42c1', 'bg' => '#f0ebfa', 'link' => 'blogs'],
    ];
    foreach ($cards as $card):
    ?>
    <div class="col-6 col-lg-3">
        <a href="<?= $baseUrl ?>/admin/<?= $card['link'] ?>" class="admin-stat-card" style="--stat-color:<?= $card['color'] ?>;--stat-bg:<?= $card['bg'] ?>">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="admin-stat-label"><?= $card['label'] ?></p>
                    <div class="admin-stat-value" style="color:<?= $card['color'] ?>"><?= $card['value'] ?></div>
                    <?php if (!empty($card['badge'])): ?><span class="badge bg-danger mt-2"><?= $card['badge'] ?> new</span><?php endif; ?>
                </div>
                <div class="admin-stat-icon" style="--stat-color:<?= $card['color'] ?>;--stat-bg:<?= $card['bg'] ?>">
                    <i class="bi <?= $card['icon'] ?>"></i>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="admin-card h-100">
            <div class="admin-card-header"><i class="bi bi-lightning-charge me-2 text-primary"></i> Quick Manage</div>
            <div class="admin-card-body d-grid gap-2">
                <a href="<?= $baseUrl ?>/admin/products" class="btn admin-quick-btn text-start"><i class="bi bi-box-seam me-2"></i> Products & Images</a>
                <a href="<?= $baseUrl ?>/admin/categories" class="btn admin-quick-btn text-start"><i class="bi bi-tags me-2"></i> Categories (Brands)</a>
                <a href="<?= $baseUrl ?>/admin/banners" class="btn admin-quick-btn text-start"><i class="bi bi-images me-2"></i> Homepage Banners</a>
                <a href="<?= $baseUrl ?>/admin/manufacturing-process" class="btn admin-quick-btn text-start"><i class="bi bi-diagram-3 me-2"></i> Manufacturing Process</a>
                <a href="<?= $baseUrl ?>/admin/seo" class="btn admin-quick-btn text-start"><i class="bi bi-search me-2"></i> SEO Settings</a>
                <a href="<?= $baseUrl ?>/admin/settings" class="btn admin-quick-btn text-start"><i class="bi bi-gear me-2"></i> Site Settings & Logo</a>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="admin-card-header"><i class="bi bi-info-circle me-2 text-primary"></i> Quick Tips</div>
            <div class="admin-card-body">
                <ul class="mb-0 ps-3" style="line-height:1.9">
                    <li>Add products with <strong>brand → type → sizes + kg</strong></li>
                    <li>Upload <strong>product images</strong> on edit page</li>
                    <li>Set <strong>hero image & logo</strong> in Settings</li>
                    <li>Update <strong>SEO</strong> for better Google ranking</li>
                    <li>Check <strong>inquiries</strong> daily for new leads</li>
                </ul>
            </div>
        </div>
    </div>
</div>
