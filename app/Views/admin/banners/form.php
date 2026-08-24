<?php
$isEdit = !empty($banner);
$action = $isEdit ? $baseUrl . '/admin/banners/update/' . $banner['id'] : $baseUrl . '/admin/banners/store';
$tEn = $translations['en'] ?? [];
$tHi = $translations['hi'] ?? [];
?>
<div class="admin-topbar">
    <h1 class="admin-page-title"><?= $isEdit ? 'Edit Banner' : 'Add Banner' ?></h1>
    <a href="<?= $baseUrl ?>/admin/banners" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="admin-card">
                <div class="admin-card-header">Banner Content</div>
                <div class="admin-card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#ben">English</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#bhi">Hindi</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="ben">
                            <div class="mb-3"><label class="form-label">Title (EN)</label><input type="text" name="title_en" class="form-control" value="<?= htmlspecialchars($tEn['title'] ?? '') ?>"></div>
                            <div class="mb-3"><label class="form-label">Subtitle (EN)</label><textarea name="subtitle_en" class="form-control" rows="2"><?= htmlspecialchars($tEn['subtitle'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Button Text (EN)</label><input type="text" name="button_text_en" class="form-control" value="<?= htmlspecialchars($tEn['button_text'] ?? '') ?>" placeholder="View Products"></div>
                        </div>
                        <div class="tab-pane fade" id="bhi">
                            <div class="mb-3"><label class="form-label">Title (HI)</label><input type="text" name="title_hi" class="form-control" value="<?= htmlspecialchars($tHi['title'] ?? '') ?>"></div>
                            <div class="mb-3"><label class="form-label">Subtitle (HI)</label><textarea name="subtitle_hi" class="form-control" rows="2"><?= htmlspecialchars($tHi['subtitle'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Button Text (HI)</label><input type="text" name="button_text_hi" class="form-control" value="<?= htmlspecialchars($tHi['button_text'] ?? '') ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="admin-card">
                <div class="admin-card-header">Banner Image & Settings</div>
                <div class="admin-card-body">
                    <?php if ($isEdit): ?>
                    <img src="<?= upload_url($banner['image']) ?>" class="admin-img-preview w-100 mb-3" alt="">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Banner Image <?= $isEdit ? '(leave empty to keep current)' : '*' ?></label>
                        <input type="file" name="image" class="form-control" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                    </div>
                    <div class="mb-3"><label class="form-label">Link URL (optional)</label><input type="text" name="link" class="form-control" value="<?= htmlspecialchars($banner['link'] ?? '') ?>" placeholder="/en/products"></div>
                    <div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="<?= (int)($banner['sort_order'] ?? 0) ?>"></div>
                    <div class="form-check mb-3"><input type="checkbox" name="is_active" class="form-check-input" id="bactive" <?= !isset($banner) || !empty($banner['is_active']) ? 'checked' : '' ?>><label class="form-check-label" for="bactive">Active</label></div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-1"></i> Save Banner</button>
                </div>
            </div>
        </div>
    </div>
</form>
