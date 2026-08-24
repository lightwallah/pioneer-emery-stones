<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="section-title mb-0"><?= e($t['blog']) ?></h1>
            <form action="<?= url($lang, 'search') ?>" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="q" class="form-control form-control-sm" placeholder="<?= e($t['search_blog']) ?>">
                <button type="submit" class="btn btn-primary btn-sm ms-2"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="row g-4">
            <?php foreach ($blogs as $blog): ?>
            <div class="col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100">
                    <?php if ($blog['featured_image']): ?>
                    <img src="<?= upload_url($blog['featured_image']) ?>" class="card-img-top" alt="<?= e($blog['title']) ?>" loading="lazy">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <?php if ($blog['category_name']): ?>
                        <span class="badge bg-warning text-dark mb-2 align-self-start"><?= e($blog['category_name']) ?></span>
                        <?php endif; ?>
                        <h5 class="card-title"><a href="<?= url($lang, 'blog/' . $blog['slug']) ?>" class="text-decoration-none text-dark"><?= e($blog['title']) ?></a></h5>
                        <p class="text-muted small flex-grow-1"><?= e(truncate($blog['excerpt'] ?? '', 120)) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted"><?= date('M d, Y', strtotime($blog['published_at'])) ?></small>
                            <a href="<?= url($lang, 'blog/' . $blog['slug']) ?>" class="btn btn-outline-primary btn-sm"><?= e($t['read_more']) ?></a>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
