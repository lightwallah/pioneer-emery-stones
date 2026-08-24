<div class="admin-topbar">
    <h1 class="admin-page-title">Categories (Brands)</h1>
    <a href="<?= $baseUrl ?>/admin/categories/create" class="btn btn-primary btn-lg"><i class="bi bi-plus-lg me-1"></i> Add Category</a>
</div>

<?php if (!empty($flash)):
    $flashClass = stripos($flash, 'Cannot delete') !== false ? 'alert-warning' : 'alert-success';
?>
<div class="alert <?= $flashClass ?> alert-dismissible fade show"><?= htmlspecialchars($flash) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Brand Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                <tr><td colspan="7" class="text-center text-muted py-5">No categories. <a href="<?= $baseUrl ?>/admin/categories/create">Add first category</a></td></tr>
                <?php endif; ?>
                <?php foreach ($categories as $c): ?>
                <tr>
                    <td>
                        <?php if (!empty($c['image'])): ?>
                        <img src="<?= upload_url($c['image']) ?>" class="admin-thumb" alt="">
                        <?php else: ?>
                        <span class="admin-thumb d-inline-flex align-items-center justify-content-center text-muted"><i class="bi bi-tag"></i></span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($c['name'] ?? $c['slug']) ?></strong></td>
                    <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
                    <td><?= (int)($c['product_count'] ?? 0) ?></td>
                    <td><?= (int)$c['sort_order'] ?></td>
                    <td><?= $c['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Off</span>' ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= $baseUrl ?>/admin/categories/edit/<?= $c['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                        <a href="<?= $baseUrl ?>/admin/categories/delete/<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
