<?php
$isEdit = !empty($product);
$action = $isEdit ? $baseUrl . '/admin/products/update/' . $product['id'] : $baseUrl . '/admin/products/store';
$tEn = $translations['en'] ?? [];
$tHi = $translations['hi'] ?? [];
$currentType = $product['stone_type'] ?? '';
$currentOrientation = '';
if ($currentType && isset($stoneTypes[$currentType])) {
    $currentOrientation = $stoneTypes[$currentType]['orientation'];
}
?>
<div class="admin-topbar">
    <h1 class="admin-page-title"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h1>
    <a href="<?= $baseUrl ?>/admin/products" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<?php if (!empty($flash)):
    $flashClass = (stripos($flash, 'failed') !== false || stripos($flash, 'not writable') !== false) ? 'alert-danger' : 'alert-success';
?>
<div class="alert <?= $flashClass ?> alert-dismissible fade show"><?= htmlspecialchars($flash) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data" id="productForm">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <!-- Step 1: Brand & Stone Type -->
    <div class="admin-card mb-4">
        <div class="admin-card-header"><span class="badge bg-primary me-2">1</span> Select Brand & Stone Type</div>
        <div class="admin-card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-tag me-1"></i> Brand Name *</label>
                    <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                        <option value="">— Select brand —</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name'] ?? $cat['slug']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-muted">Nataraj, Surabhi, Ravi, Savaliya…</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-arrows-angle-expand me-1"></i> Horizontal / Vertical *</label>
                    <select id="stone_orientation" class="form-select form-select-lg" required>
                        <option value="">— Select —</option>
                        <option value="horizontal" <?= $currentOrientation === 'horizontal' ? 'selected' : '' ?>>Horizontal</option>
                        <option value="vertical" <?= $currentOrientation === 'vertical' ? 'selected' : '' ?>>Vertical</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><i class="bi bi-list-ul me-1"></i> Stone Type *</label>
                    <select name="stone_type" id="stone_type" class="form-select form-select-lg" data-selected="<?= htmlspecialchars($currentType) ?>" required>
                        <option value="">— Select type first —</option>
                    </select>
                    <small class="text-muted">Janta, Taper, Danish, Rajkot…</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 2: Size list with kg -->
    <div class="admin-card mb-4 d-none" id="specSizePanel">
        <div class="admin-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><span class="badge bg-primary me-2">2</span> Select Sizes & Add Weight (kg)</span>
            <div class="form-check mb-0">
                <input type="checkbox" class="form-check-input" id="selectAllSizes">
                <label class="form-check-label small" for="selectAllSizes">Select all sizes</label>
            </div>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 admin-spec-picker">
                    <thead class="table-light">
                        <tr>
                            <th width="50">Use</th>
                            <th>SL. NO.</th>
                            <th>Diameter (inch)</th>
                            <th>Bore (mm)</th>
                            <th>Thickness (mm)</th>
                            <th width="140">Weight (kg)</th>
                        </tr>
                    </thead>
                    <tbody id="specSizeBody"></tbody>
                </table>
            </div>
            <p class="small text-muted p-3 mb-0">Tick the sizes you sell, then enter weight in <strong>kg</strong> for each.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card mb-4">
                <div class="admin-card-header"><span class="badge bg-primary me-2">3</span> Product Name & Description</div>
                <div class="admin-card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-en">English</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-hi">Hindi</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-seo">SEO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-en">
                            <div class="mb-3"><label class="form-label">Name (EN) *</label><input type="text" name="name_en" class="form-control" value="<?= htmlspecialchars($tEn['name'] ?? '') ?>" required></div>
                            <div class="mb-3"><label class="form-label">Short Description</label><textarea name="short_description_en" class="form-control" rows="2"><?= htmlspecialchars($tEn['short_description'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Full Description</label><textarea name="description_en" class="form-control" rows="3"><?= htmlspecialchars($tEn['description'] ?? '') ?></textarea></div>
                        </div>
                        <div class="tab-pane fade" id="tab-hi">
                            <div class="mb-3"><label class="form-label">Name (HI)</label><input type="text" name="name_hi" class="form-control" value="<?= htmlspecialchars($tHi['name'] ?? '') ?>"></div>
                            <div class="mb-3"><label class="form-label">Short Description (HI)</label><textarea name="short_description_hi" class="form-control" rows="2"><?= htmlspecialchars($tHi['short_description'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Full Description (HI)</label><textarea name="description_hi" class="form-control" rows="3"><?= htmlspecialchars($tHi['description'] ?? '') ?></textarea></div>
                        </div>
                        <div class="tab-pane fade" id="tab-seo">
                            <?php foreach (['en' => 'English', 'hi' => 'Hindi'] as $lang => $label): $t = $translations[$lang] ?? []; ?>
                            <h6 class="text-primary"><?= $label ?> SEO</h6>
                            <div class="mb-3"><label class="form-label">Meta Title</label><input type="text" name="meta_title_<?= $lang ?>" class="form-control" value="<?= htmlspecialchars($t['meta_title'] ?? '') ?>"></div>
                            <div class="mb-3"><label class="form-label">Meta Description</label><textarea name="meta_description_<?= $lang ?>" class="form-control" rows="2"><?= htmlspecialchars($t['meta_description'] ?? '') ?></textarea></div>
                            <?php if ($lang === 'en'): ?><hr><?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!$isEdit): ?>
            <div class="admin-card">
                <div class="admin-card-header"><i class="bi bi-images me-1"></i> Product Images</div>
                <div class="admin-card-body">
                    <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif" multiple>
                    <small class="text-muted d-block mt-2">JPG, PNG, WEBP or GIF. You can add more images after creating the product.</small>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="admin-card sticky-top" style="top:1rem">
                <div class="admin-card-header">Publish</div>
                <div class="admin-card-body">
                    <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product['slug'] ?? '') ?>" placeholder="auto"></div>
                    <div class="mb-3"><label class="form-label">SKU</label><input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($product['sku'] ?? '') ?>"></div>
                    <div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= (int)($product['sort_order'] ?? 0) ?>"></div>
                    <div class="form-check mb-2"><input type="checkbox" name="is_featured" class="form-check-input" id="featured" <?= !empty($product['is_featured']) ? 'checked' : '' ?>><label class="form-check-label" for="featured">Featured</label></div>
                    <div class="form-check mb-3"><input type="checkbox" name="is_active" class="form-check-input" id="active" <?= !isset($product) || !empty($product['is_active']) ? 'checked' : '' ?>><label class="form-check-label" for="active">Active</label></div>
                    <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Save Product' : 'Create Product' ?></button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if ($isEdit): ?>
<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header"><i class="bi bi-images me-1"></i> Product Images</div>
            <div class="admin-card-body">
                <form method="POST" action="<?= $action ?>" enctype="multipart/form-data" class="border rounded p-3 mb-3 bg-light">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <input type="hidden" name="upload_images_only" value="1">
                    <label class="form-label fw-semibold mb-2"><i class="bi bi-cloud-upload me-1"></i> Upload Images (JPG, PNG, WEBP)</label>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif" multiple required style="max-width:320px">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-1"></i> Upload Now</button>
                    </div>
                    <small class="text-muted d-block mt-2">Uploads instantly — no need to click Save Product.</small>
                </form>

                <?php if (!empty($images)): ?>
                <div class="admin-img-grid">
                    <?php foreach ($images as $img): ?>
                    <div class="admin-img-item <?= $img['is_primary'] ? 'primary' : '' ?>">
                        <img src="<?= upload_url($img['image_path']) ?>" alt="Product image">
                        <?php if ($img['is_primary']): ?><span class="badge bg-primary mt-1">Primary</span><?php endif; ?>
                        <div class="d-flex gap-1 mt-2 justify-content-center">
                            <?php if (!$img['is_primary']): ?>
                            <form method="POST" action="<?= $action ?>" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                                <button type="submit" name="primary_image_id" value="<?= $img['id'] ?>" class="btn btn-sm btn-outline-primary" title="Set as primary"><i class="bi bi-star"></i></button>
                            </form>
                            <?php endif; ?>
                            <form method="POST" action="<?= $action ?>" class="d-inline" onsubmit="return confirm('Delete this image?')">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                                <button type="submit" name="delete_image_id" value="<?= $img['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No images yet. Use the upload box above.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
window.PRODUCT_FORM_CONFIG = {
    stoneTypes: <?= json_encode($stoneTypes, JSON_UNESCAPED_UNICODE) ?>,
    existingSizes: <?= json_encode($sizes ?? [], JSON_UNESCAPED_UNICODE) ?>
};
</script>
<script src="<?= rtrim($baseUrl, '/') ?>/assets/js/admin-product.js"></script>
