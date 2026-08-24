<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Blog Posts</h1>
        <p class="admin-page-subtitle">Manage articles and news</p>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>ID</th><th>Title</th><th>Slug</th><th>Published</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                <?php if (empty($blogs)): ?>
                <tr><td colspan="5"><div class="admin-empty"><i class="bi bi-journal-text"></i><p>No blog posts yet.</p></div></td></tr>
                <?php endif; ?>
                <?php foreach ($blogs as $b): ?>
                <tr>
                    <td class="text-muted">#<?= $b['id'] ?></td>
                    <td><strong><?= htmlspecialchars($b['title'] ?? '') ?></strong></td>
                    <td><code><?= htmlspecialchars($b['slug']) ?></code></td>
                    <td><?= $b['is_published'] ? date('M d, Y', strtotime($b['published_at'])) : '<span class="badge bg-secondary">Draft</span>' ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= $baseUrl ?>/en/blog/<?= $b['slug'] ?>" class="btn btn-sm btn-outline-primary" target="_blank"><i class="bi bi-eye"></i></a>
                        <a href="<?= $baseUrl ?>/admin/blogs/delete/<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
