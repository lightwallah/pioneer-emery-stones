<?php if (!empty($breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <?php foreach ($breadcrumbs as $i => $crumb): ?>
                <?php if ($i < count($breadcrumbs) - 1 && !empty($crumb['url'])): ?>
                    <li class="breadcrumb-item"><a href="<?= e($crumb['url']) ?>"><?= e($crumb['name']) ?></a></li>
                <?php else: ?>
                    <li class="breadcrumb-item active"><?= e($crumb['name']) ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
<?php endif; ?>
