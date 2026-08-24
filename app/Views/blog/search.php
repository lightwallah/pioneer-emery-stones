<section class="py-5">
    <div class="container">
        <h1 class="section-title mb-4">Search Results<?= $query ? ': "' . e($query) . '"' : '' ?></h1>
        <?php if (empty($blogs)): ?>
            <p class="text-muted"><?= e($t['no_results']) ?></p>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4">
                        <h5><a href="<?= url($lang, 'blog/' . $blog['slug']) ?>" class="text-decoration-none"><?= e($blog['title']) ?></a></h5>
                        <p class="text-muted small mb-0"><?= e(truncate($blog['excerpt'] ?? '', 150)) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <a href="<?= url($lang, 'blog') ?>" class="btn btn-outline-primary mt-4">Back to Blog</a>
    </div>
</section>
