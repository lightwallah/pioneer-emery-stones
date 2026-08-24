<?php
$specTables = require dirname(__DIR__, 3) . '/config/specifications.php';
?>
<section class="spec-section py-5" id="specifications">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <span class="section-label"><?= e($t['spec_section_label'] ?? 'Technical Data') ?></span>
            <h2 class="section-title mb-2"><?= e($t['spec_section_title']) ?></h2>
            <p class="text-muted col-lg-8 mx-auto mb-0"><?= e($t['spec_section_desc']) ?></p>
        </div>

        <div class="row g-4">
            <?php foreach ($specTables as $table): ?>
            <div class="col-lg-6">
                <div class="spec-card h-100">
                    <div class="spec-card-header">
                        <h3 class="spec-card-title"><?= e($t[$table['title_key']] ?? $table['title_key']) ?></h3>
                    </div>
                    <p class="table-scroll-hint d-md-none"><i class="bi bi-arrow-left-right"></i> <?= e($t['scroll_sizes'] ?? 'Swipe table →') ?></p>
                    <div class="table-responsive table-scroll-wrap">
                        <table class="table spec-table mb-0">
                            <thead>
                                <tr>
                                    <th><?= e($t['spec_col_sl']) ?></th>
                                    <th><?= e($t['spec_col_diameter']) ?></th>
                                    <th><?= e($t['spec_col_bore']) ?></th>
                                    <th><?= e($t['spec_col_thickness']) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($table['rows'] as $row): ?>
                                <tr>
                                    <td><?= (int) $row['sl'] ?></td>
                                    <td><?= e($row['diameter']) ?></td>
                                    <td><?= e($row['bore']) ?></td>
                                    <td><?= e($row['thickness']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
