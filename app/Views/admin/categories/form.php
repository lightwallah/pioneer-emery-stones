<?php
$isEdit = !empty($category);
$action = $isEdit ? $baseUrl . '/admin/categories/update/' . $category['id'] : $baseUrl . '/admin/categories/store';
$tEn = $translations['en'] ?? [];
$tHi = $translations['hi'] ?? [];
?>
<div class="admin-topbar">
    <h1 class="admin-page-title"><?= $isEdit ? 'Edit Category' : 'Add Category' ?></h1>
    <a href="<?= $baseUrl ?>/admin/categories" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="admin-card">
                <div class="admin-card-header">Category Name & Description</div>
                <div class="admin-card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#cen">English</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#chi">Hindi</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cseo">SEO</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="cen">
                            <div class="mb-3"><label class="form-label">Name (EN) *</label><input type="text" name="name_en" class="form-control" value="<?= htmlspecialchars($tEn['name'] ?? '') ?>" required placeholder="Natraj Emery Stones"></div>
                            <div class="mb-3"><label class="form-label">Description (EN)</label><textarea name="description_en" class="form-control" rows="3"><?= htmlspecialchars($tEn['description'] ?? '') ?></textarea></div>
                        </div>
                        <div class="tab-pane fade" id="chi">
                            <div class="mb-3"><label class="form-label">Name (HI)</label><input type="text" name="name_hi" class="form-control" value="<?= htmlspecialchars($tHi['name'] ?? '') ?>"></div>
                            <div class="mb-3"><label class="form-label">Description (HI)</label><textarea name="description_hi" class="form-control" rows="3"><?= htmlspecialchars($tHi['description'] ?? '') ?></textarea></div>
                        </div>
                        <div class="tab-pane fade" id="cseo">
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
        </div>
        <div class="col-lg-5">
            <div class="admin-card">
                <div class="admin-card-header">Settings</div>
                <div class="admin-card-body">
                    <?php if ($isEdit && !empty($category['image'])): ?>
                    <img src="<?= upload_url($category['image']) ?>" class="admin-img-preview w-100 mb-3" alt="">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                        <small class="text-muted">Optional brand logo or tile image.</small>
                    </div>
                    <div class="mb-3"><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($category['slug'] ?? '') ?>" placeholder="auto from name"></div>
                    <div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= (int)($category['sort_order'] ?? 0) ?>"></div>
                    <div class="form-check mb-3"><input type="checkbox" name="is_active" class="form-check-input" id="cactive" <?= !isset($category) || !empty($category['is_active']) ? 'checked' : '' ?>><label class="form-check-label" for="cactive">Active</label></div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="bi bi-check-lg me-1"></i> <?= $isEdit ? 'Save Category' : 'Create Category' ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
