<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pioneer Emery Stones</title>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= rtrim($baseUrl, '/') ?>/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= rtrim($baseUrl, '/') ?>/assets/images/favicon-16x16.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= rtrim($baseUrl, '/') ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="admin-login-page">
        <div class="admin-login-card">
            <div class="admin-login-header">
                <img src="<?= rtrim($baseUrl, '/') ?>/assets/images/pioneer-logo.png" alt="Pioneer Emery Stones" class="admin-login-logo">
                <h1>Pioneer Admin</h1>
                <p>Emery Stones Management Panel</p>
            </div>
            <div class="admin-login-body">
                <?php if (!empty($error)): ?>
                <div class="alert alert-danger mb-4"><i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="username" class="form-control border-start-0 ps-0" required autofocus placeholder="Enter username">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0" required placeholder="Enter password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="bi bi-box-arrow-in-right me-1"></i> Sign In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
