<?php require dirname(__DIR__) . '/partials/breadcrumbs.php'; ?>

<section class="py-5">
    <div class="container">
        <h1 class="section-title mb-4"><?= e($t['compare']) ?></h1>

        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                <p class="mb-2">No products selected for comparison. Browse our <a href="<?= url($lang, 'products') ?>">products</a> and click the compare button.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered compare-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Feature</th>
                            <?php foreach ($products as $p): ?>
                            <th>
                                <?= e($p['name']) ?>
                                <form method="POST" action="<?= url($lang, 'compare/remove') ?>" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1"><i class="bi bi-x"></i></button>
                                </form>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><th>Category</th><?php foreach ($products as $p): ?><td><?= e($p['category_name']) ?></td><?php endforeach; ?></tr>
                        <tr><th>SKU</th><?php foreach ($products as $p): ?><td><?= e($p['sku'] ?? '-') ?></td><?php endforeach; ?></tr>
                        <tr><th>Description</th><?php foreach ($products as $p): ?><td class="small"><?= e(truncate($p['short_description'] ?? '', 150)) ?></td><?php endforeach; ?></tr>
                        <tr><th><?= e($t['sizes']) ?></th>
                            <?php foreach ($products as $p): ?>
                            <td>
                                <?php if (!empty($p['sizes'])): ?>
                                    <ul class="list-unstyled small mb-0">
                                        <?php foreach ($p['sizes'] as $s): ?>
                                        <li><?= e($s['size_label']) ?> (<?= e($s['diameter']) ?>)</li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>-<?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr><th><?= e($t['specifications']) ?></th>
                            <?php foreach ($products as $p): ?>
                            <td>
                                <?php if (!empty($p['specs'])): ?>
                                    <ul class="list-unstyled small mb-0">
                                        <?php foreach ($p['specs'] as $s): ?>
                                        <li><strong><?= e($s['spec_key']) ?>:</strong> <?= e($s['spec_value']) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>-<?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <tr><th><?= e($t['benefits']) ?></th><?php foreach ($products as $p): ?><td class="small"><?= nl2br(e($p['benefits'] ?? '-')) ?></td><?php endforeach; ?></tr>
                        <tr><th><?= e($t['applications']) ?></th><?php foreach ($products as $p): ?><td class="small"><?= nl2br(e($p['applications'] ?? '-')) ?></td><?php endforeach; ?></tr>
                        <tr>
                            <th>Action</th>
                            <?php foreach ($products as $p): ?>
                            <td>
                                <a href="<?= whatsapp_link(product_whatsapp_message($p['name'], $lang)) ?>" class="btn btn-success btn-sm" target="_blank"><i class="bi bi-whatsapp"></i> <?= e($t['get_quote']) ?></a>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
