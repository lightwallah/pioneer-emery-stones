<div class="admin-topbar">
    <h1 class="admin-page-title">Products</h1>
    <a href="<?= $baseUrl ?>/admin/products/create" class="btn btn-primary btn-lg"><i class="bi bi-plus-lg me-1"></i> Add Product</a>
</div>

<?php if (!empty($_SESSION['admin_flash'])): ?>
<div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($_SESSION['admin_flash']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['admin_flash']); endif; ?>

<div class="admin-card mb-3">
    <div class="admin-card-body py-3">
        <div class="row g-2 text-center small">
            <div class="col-4 col-md"><strong class="text-primary">Step 1</strong><br>Select Brand</div>
            <div class="col-4 col-md"><strong class="text-primary">Step 2</strong><br>Horizontal / Vertical</div>
            <div class="col-4 col-md"><strong class="text-primary">Step 3</strong><br>Pick sizes + kg</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Brand / Product</th>
                    <th>Stone Type</th>
                    <th>Sizes</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr><td colspan="6" class="text-center text-muted py-5">No products. <a href="<?= $baseUrl ?>/admin/products/create">Add first product</a></td></tr>
                <?php endif; ?>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <?php if (!empty($p['thumb'])): ?>
                        <img src="<?= upload_url($p['thumb']) ?>" class="admin-thumb" alt="">
                        <?php else: ?>
                        <span class="admin-thumb d-inline-flex align-items-center justify-content-center text-muted"><i class="bi bi-image"></i></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($p['name'] ?? $p['slug']) ?></strong>
                        <br><small class="text-muted"><?= htmlspecialchars($p['category_name'] ?? '') ?></small>
                    </td>
                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p['stone_type_label']) ?></span></td>
                    <td><?= (int)($p['size_count'] ?? 0) ?> sizes</td>
                    <td><?= $p['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Off</span>' ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= $baseUrl ?>/admin/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                        <a href="<?= $baseUrl ?>/en/product/<?= $p['slug'] ?>" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="bi bi-eye"></i></a>
                        <a href="<?= $baseUrl ?>/admin/products/delete/<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
