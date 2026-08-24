<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">FAQs</h1>
        <p class="admin-page-subtitle">Frequently asked questions</p>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>ID</th><th>Question</th><th>Order</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php if (empty($faqs)): ?>
                <tr><td colspan="4"><div class="admin-empty"><i class="bi bi-question-circle"></i><p>No FAQs yet.</p></div></td></tr>
                <?php endif; ?>
                <?php foreach ($faqs as $f): ?>
                <tr>
                    <td class="text-muted">#<?= $f['id'] ?></td>
                    <td><?= htmlspecialchars(truncate($f['question'] ?? '', 80)) ?></td>
                    <td><?= $f['sort_order'] ?></td>
                    <td class="text-end">
                        <a href="<?= $baseUrl ?>/admin/faqs/delete/<?= $f['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this FAQ?')"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
