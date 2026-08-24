<div class="admin-topbar">
    <h1 class="admin-page-title">Homepage Banners</h1>
    <a href="<?= $baseUrl ?>/admin/banners/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Banner</a>
</div>

<?php if (!empty($flash)): ?><div class="alert alert-success"><?= htmlspecialchars($flash) ?></div><?php endif; ?>

<div class="row g-4">
    <?php if (empty($banners)): ?>
    <div class="col-12">
        <div class="admin-card admin-card-body text-center text-muted py-5">
            <i class="bi bi-images display-4 d-block mb-3 opacity-50"></i>
            <p>No banners yet. Add a banner image for the homepage slider.</p>
            <a href="<?= $baseUrl ?>/admin/banners/create" class="btn btn-primary">Add Banner</a>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($banners as $b): ?>
    <div class="col-md-6 col-lg-4">
        <div class="admin-card h-100">
            <img src="<?= upload_url($b['image']) ?>" class="w-100" style="height:160px;object-fit:cover;border-radius:12px 12px 0 0" alt="">
            <div class="admin-card-body">
                <h6 class="mb-1"><?= htmlspecialchars($b['title'] ?? 'Banner #' . $b['id']) ?></h6>
                <p class="small text-muted mb-2">Order: <?= (int)$b['sort_order'] ?> · <?= $b['is_active'] ? '<span class="text-success">Active</span>' : '<span class="text-secondary">Inactive</span>' ?></p>
                <div class="d-flex gap-2">
                    <a href="<?= $baseUrl ?>/admin/banners/edit/<?= $b['id'] ?>" class="btn btn-sm btn-primary flex-grow-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="<?= $baseUrl ?>/admin/banners/delete/<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete banner?')"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
