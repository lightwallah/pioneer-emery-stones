<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Manufacturing Process</h1>
        <p class="admin-page-subtitle">Edit homepage process steps, images & descriptions</p>
    </div>
    <a href="<?= $baseUrl ?>/admin/manufacturing-process/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Step</a>
</div>

<?php if (!empty($flash)): ?><div class="alert alert-success"><?= htmlspecialchars($flash) ?></div><?php endif; ?>

<div class="admin-card mb-4">
    <div class="admin-card-header">Section Heading (Homepage)</div>
    <div class="admin-card-body">
        <form method="POST" action="<?= $baseUrl ?>/admin/manufacturing-process/section">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#mpen">English</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#mph">Hindi</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="mpen">
                    <div class="mb-3">
                        <label class="form-label">Title (EN)</label>
                        <input type="text" name="title_en" class="form-control" value="<?= htmlspecialchars($section['title_en'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (EN)</label>
                        <textarea name="desc_en" class="form-control" rows="2"><?= htmlspecialchars($section['desc_en'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="tab-pane fade" id="mph">
                    <div class="mb-3">
                        <label class="form-label">Title (HI)</label>
                        <input type="text" name="title_hi" class="form-control" value="<?= htmlspecialchars($section['title_hi'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (HI)</label>
                        <textarea name="desc_hi" class="form-control" rows="2"><?= htmlspecialchars($section['desc_hi'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check-lg me-1"></i> Save Section Heading</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <span>Process Steps</span>
        <span class="badge bg-secondary"><?= count($steps) ?> steps</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:56px">#</th>
                    <th>Step</th>
                    <th>Icon</th>
                    <th>Image</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($steps)): ?>
                <tr>
                    <td colspan="7">
                        <div class="admin-empty">
                            <i class="bi bi-diagram-3"></i>
                            <p>No process steps yet. Run install script or add a step.</p>
                            <a href="<?= $baseUrl ?>/admin/manufacturing-process/create" class="btn btn-sm btn-primary">Add Step</a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
                <?php foreach ($steps as $step): ?>
                <tr>
                    <td><span class="badge bg-primary rounded-pill"><?= (int) $step['sort_order'] + 1 ?></span></td>
                    <td>
                        <strong><?= htmlspecialchars($step['label'] ?? 'Step #' . $step['id']) ?></strong>
                        <?php if (!empty($step['description'])): ?>
                        <div class="small text-muted text-truncate" style="max-width:320px"><?= htmlspecialchars($step['description']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td><i class="bi <?= htmlspecialchars($step['icon'] ?? 'bi-gear') ?> fs-5 text-primary"></i></td>
                    <td>
                        <?php if (!empty($step['image'])): ?>
                        <img src="<?= upload_url($step['image']) ?>" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:8px">
                        <?php else: ?>
                        <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                    <td><?= (int) $step['sort_order'] ?></td>
                    <td><?= !empty($step['is_active']) ? '<span class="text-success">Active</span>' : '<span class="text-secondary">Hidden</span>' ?></td>
                    <td class="text-end">
                        <a href="<?= $baseUrl ?>/admin/manufacturing-process/edit/<?= $step['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                        <a href="<?= $baseUrl ?>/admin/manufacturing-process/delete/<?= $step['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this step?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
