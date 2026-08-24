<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Testimonials</h1>
        <p class="admin-page-subtitle">Customer and dealer reviews</p>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Name</th><th>Company</th><th>Type</th><th>Rating</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php if (empty($testimonials)): ?>
                <tr><td colspan="5"><div class="admin-empty"><i class="bi bi-star"></i><p>No testimonials yet.</p></div></td></tr>
                <?php endif; ?>
                <?php foreach ($testimonials as $t): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($t['name']) ?></strong></td>
                    <td><?= htmlspecialchars($t['company'] ?? '—') ?></td>
                    <td><span class="badge bg-<?= $t['type'] === 'dealer' ? 'warning text-dark' : 'primary' ?>"><?= ucfirst($t['type']) ?></span></td>
                    <td><span class="text-warning"><?= str_repeat('★', (int)$t['rating']) ?></span></td>
                    <td class="text-end">
                        <a href="<?= $baseUrl ?>/admin/testimonials/delete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
