<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Dealer Inquiries</h1>
        <p class="admin-page-subtitle">Dealer partnership requests</p>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>Date</th><th>Name</th><th>Company</th><th>Phone</th><th>City</th><th>State</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php if (empty($inquiries)): ?>
                <tr><td colspan="8"><div class="admin-empty"><i class="bi bi-building"></i><p>No dealer inquiries yet.</p></div></td></tr>
                <?php endif; ?>
                <?php foreach ($inquiries as $inq): ?>
                <tr class="<?= !$inq['is_read'] ? 'row-unread' : '' ?>">
                    <td class="text-nowrap small"><?= date('M d, Y', strtotime($inq['created_at'])) ?></td>
                    <td><strong><?= htmlspecialchars($inq['name']) ?></strong></td>
                    <td><?= htmlspecialchars($inq['company_name']) ?></td>
                    <td><?= htmlspecialchars($inq['phone']) ?></td>
                    <td><?= htmlspecialchars($inq['city']) ?></td>
                    <td><?= htmlspecialchars($inq['state']) ?></td>
                    <td><?= $inq['is_read'] ? '<span class="badge bg-light text-dark border">Read</span>' : '<span class="badge bg-danger">New</span>' ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= $baseUrl ?>/admin/dealer-inquiries/view/<?= $inq['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye me-1"></i>View</a>
                        <a href="<?= $baseUrl ?>/admin/dealer-inquiries/delete/<?= $inq['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
