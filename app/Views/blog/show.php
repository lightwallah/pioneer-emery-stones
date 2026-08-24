<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article>
                    <?php if ($blog['category_name']): ?>
                    <span class="badge bg-warning text-dark mb-3"><?= e($blog['category_name']) ?></span>
                    <?php endif; ?>
                    <h1 class="section-title"><?= e($blog['title']) ?></h1>
                    <p class="text-muted mb-4">
                        <i class="bi bi-person"></i> <?= e($blog['author']) ?> &nbsp;
                        <i class="bi bi-calendar"></i> <?= date('F d, Y', strtotime($blog['published_at'])) ?>
                    </p>
                    <?php if ($blog['featured_image']): ?>
                    <img src="<?= upload_url($blog['featured_image']) ?>" class="img-fluid rounded mb-4" alt="<?= e($blog['title']) ?>">
                    <?php endif; ?>
                    <div class="blog-content text-muted">
                        <?= $blog['content'] ?>
                    </div>
                    <?php if (!empty($tags)): ?>
                    <div class="mt-4">
                        <?php foreach ($tags as $tag): ?>
                        <span class="badge bg-light text-dark border me-1">#<?= e($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </article>

                <?php if (!empty($related)): ?>
                <div class="mt-5 pt-4 border-top">
                    <h4>Related Articles</h4>
                    <div class="row g-3">
                        <?php foreach ($related as $rel): ?>
                        <div class="col-md-4">
                            <a href="<?= url($lang, 'blog/' . $rel['slug']) ?>" class="text-decoration-none">
                                <div class="card border-0 shadow-sm p-3">
                                    <h6 class="text-dark mb-0"><?= e($rel['title']) ?></h6>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
