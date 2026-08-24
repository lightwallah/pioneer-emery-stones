<?php
$isEdit = !empty($step);
$action = $isEdit
    ? $baseUrl . '/admin/manufacturing-process/update/' . $step['id']
    : $baseUrl . '/admin/manufacturing-process/store';
$tEn = $translations['en'] ?? [];
$tHi = $translations['hi'] ?? [];
$iconOptions = [
    'bi-box-seam', 'bi-droplet-half', 'bi-arrows-collapse', 'bi-hourglass-split',
    'bi-disc', 'bi-clipboard-check', 'bi-box', 'bi-send', 'bi-gear', 'bi-tools',
    'bi-lightning', 'bi-shield-check', 'bi-truck', 'bi-building',
];
?>
<div class="admin-topbar">
    <h1 class="admin-page-title"><?= $isEdit ? 'Edit Process Step' : 'Add Process Step' ?></h1>
    <a href="<?= $baseUrl ?>/admin/manufacturing-process" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<form method="POST" action="<?= $action ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="admin-card">
                <div class="admin-card-header">Step Content</div>
                <div class="admin-card-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#psen">English</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pshi">Hindi</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="psen">
                            <div class="mb-3">
                                <label class="form-label">Step Name (EN) *</label>
                                <input type="text" name="label_en" class="form-control" value="<?= htmlspecialchars($tEn['label'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description (EN)</label>
                                <textarea name="description_en" class="form-control" rows="3"><?= htmlspecialchars($tEn['description'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pshi">
                            <div class="mb-3">
                                <label class="form-label">Step Name (HI)</label>
                                <input type="text" name="label_hi" class="form-control" value="<?= htmlspecialchars($tHi['label'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description (HI)</label>
                                <textarea name="description_hi" class="form-control" rows="3"><?= htmlspecialchars($tHi['description'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="admin-card">
                <div class="admin-card-header">Step Settings</div>
                <div class="admin-card-body">
                    <?php if ($isEdit && !empty($step['image'])): ?>
                    <img src="<?= upload_url($step['image']) ?>" class="admin-img-preview w-100 mb-3" alt="">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Step Image <?= $isEdit ? '(leave empty to keep current)' : '(optional)' ?></label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Shown in the preview panel when this step is clicked on the homepage.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image Position</label>
                        <select name="image_position" class="form-select">
                            <?php foreach (['center', 'center top', 'center bottom', '70% center'] as $pos): ?>
                            <option value="<?= $pos ?>" <?= ($step['image_position'] ?? 'center') === $pos ? 'selected' : '' ?>><?= $pos ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Bootstrap Icons class)</label>
                        <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($step['icon'] ?? 'bi-gear') ?>" list="processIconList">
                        <datalist id="processIconList">
                            <?php foreach ($iconOptions as $icon): ?>
                            <option value="<?= $icon ?>"></option>
                            <?php endforeach; ?>
                        </datalist>
                        <div class="form-text">Preview: <i class="bi <?= htmlspecialchars($step['icon'] ?? 'bi-gear') ?>" id="iconPreview"></i></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= (int) ($step['sort_order'] ?? 0) ?>">
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" class="form-check-input" id="psactive" <?= !isset($step) || !empty($step['is_active']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="psactive">Active (show on website)</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg me-1"></i> Save Step</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.querySelector('input[name="icon"]')?.addEventListener('input', function () {
    var el = document.getElementById('iconPreview');
    if (el) el.className = 'bi ' + this.value;
});
</script>
