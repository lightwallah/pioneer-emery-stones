<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Pioneer Emery Stones</title>

    <link rel="icon" type="image/png" sizes="32x32" href="<?= rtrim($baseUrl, '/') ?>/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= rtrim($baseUrl, '/') ?>/assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= rtrim($baseUrl, '/') ?>/assets/images/apple-touch-icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="<?= rtrim($baseUrl, '/') ?>/assets/css/admin.css" rel="stylesheet">

</head>

<body class="admin-body">

    <div class="admin-overlay" id="adminOverlay"></div>

    <button class="admin-toggle-btn" id="adminToggle" type="button" aria-label="Menu"><i class="bi bi-list fs-5"></i></button>



    <aside class="admin-sidebar" id="adminSidebar">

        <div class="admin-sidebar-brand">

            <img src="<?= rtrim($baseUrl, '/') ?>/assets/images/pioneer-logo.png" alt="Pioneer" class="admin-brand-logo">

            <div>

                <strong>Pioneer Admin</strong>

                <small class="d-block">Emery Stones Panel</small>

            </div>

        </div>

        <nav class="admin-nav">

            <div class="admin-nav-section">Main</div>

            <?php

            $mainMenu = [

                'dashboard' => ['icon' => 'bi-speedometer2', 'label' => 'Dashboard'],

                'products' => ['icon' => 'bi-box-seam', 'label' => 'Products'],

                'categories' => ['icon' => 'bi-tags', 'label' => 'Categories'],

                'banners' => ['icon' => 'bi-images', 'label' => 'Banners'],

                'manufacturing-process' => ['icon' => 'bi-diagram-3', 'label' => 'Manufacturing Process'],

            ];

            foreach ($mainMenu as $path => $item):

                $active = str_contains($_SERVER['REQUEST_URI'], '/admin/' . $path);

            ?>

            <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/<?= $path ?>">

                <i class="bi <?= $item['icon'] ?>"></i><?= $item['label'] ?>

            </a>

            <?php endforeach; ?>



            <div class="admin-nav-section">Content</div>

            <?php

            $contentMenu = [

                'blogs' => ['icon' => 'bi-journal-text', 'label' => 'Blogs'],

                'faqs' => ['icon' => 'bi-question-circle', 'label' => 'FAQs'],

                'testimonials' => ['icon' => 'bi-star', 'label' => 'Testimonials'],

            ];

            foreach ($contentMenu as $path => $item):

                $active = str_contains($_SERVER['REQUEST_URI'], '/admin/' . $path);

            ?>

            <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/<?= $path ?>">

                <i class="bi <?= $item['icon'] ?>"></i><?= $item['label'] ?>

            </a>

            <?php endforeach; ?>



            <div class="admin-nav-section">Inquiries</div>

            <?php

            $inquiryMenu = [

                'inquiries' => ['icon' => 'bi-envelope', 'label' => 'Contact'],

                'dealer-inquiries' => ['icon' => 'bi-building', 'label' => 'Dealers'],

            ];

            foreach ($inquiryMenu as $path => $item):

                $active = str_contains($_SERVER['REQUEST_URI'], '/admin/' . $path);

            ?>

            <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/<?= $path ?>">

                <i class="bi <?= $item['icon'] ?>"></i><?= $item['label'] ?>

            </a>

            <?php endforeach; ?>



            <div class="admin-nav-section">Site</div>

            <?php

            $siteMenu = [

                'seo' => ['icon' => 'bi-search', 'label' => 'SEO'],

                'settings' => ['icon' => 'bi-gear', 'label' => 'Settings'],

            ];

            foreach ($siteMenu as $path => $item):

                $active = str_contains($_SERVER['REQUEST_URI'], '/admin/' . $path);

            ?>

            <a class="nav-link <?= $active ? 'active' : '' ?>" href="<?= $baseUrl ?>/admin/<?= $path ?>">

                <i class="bi <?= $item['icon'] ?>"></i><?= $item['label'] ?>

            </a>

            <?php endforeach; ?>



            <a class="nav-link nav-external" href="<?= $baseUrl ?>/en" target="_blank"><i class="bi bi-globe2"></i> View Website</a>

            <a class="nav-link nav-logout" href="<?= $baseUrl ?>/admin/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>

        </nav>

        <div class="admin-sidebar-footer">

            &copy; <?= date('Y') ?> Pioneer Emery Stones

        </div>

    </aside>



    <div class="admin-main">

        <header class="admin-header">

            <p class="admin-header-title mb-0"><i class="bi bi-shield-check me-1"></i> Manufacturer Control Panel</p>

            <div class="admin-header-actions">

                <a href="<?= $baseUrl ?>/en" class="btn btn-sm btn-outline-primary d-none d-md-inline-flex" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i> View Site</a>

                <div class="admin-user-chip">

                    <div class="admin-user-avatar"><?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?></div>

                    <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator') ?></span>

                </div>

            </div>

        </header>

        <div class="admin-content">

            <?= $content ?>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

    (function () {

        var sidebar = document.getElementById('adminSidebar');

        var overlay = document.getElementById('adminOverlay');

        var toggle = document.getElementById('adminToggle');

        if (!sidebar || !toggle) return;

        function close() { sidebar.classList.remove('show'); overlay.classList.remove('show'); }

        toggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

            overlay.classList.toggle('show');

        });

        overlay.addEventListener('click', close);

        sidebar.querySelectorAll('.nav-link').forEach(function (link) {

            link.addEventListener('click', function () { if (window.innerWidth < 992) close(); });

        });

        document.querySelectorAll('.alert:not(.alert-permanent)').forEach(function (el) {

            setTimeout(function () {

                var bsAlert = bootstrap.Alert.getOrCreateInstance(el);

                if (bsAlert) bsAlert.close();

            }, 5000);

        });

    })();

    </script>

</body>

</html>


