<div class="admin-topbar">
    <div>
        <h1 class="admin-page-title">Dealer Inquiry</h1>
        <p class="admin-page-subtitle">Partnership request details</p>
    </div>
    <a href="<?= $baseUrl ?>/admin/dealer-inquiries" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
</div>

<?php if ($inquiry): ?>
<div class="admin-card">
    <div class="admin-card-body">
        <div class="admin-detail-grid">
            <div class="admin-detail-item"><label>Name</label><span><?= htmlspecialchars($inquiry['name']) ?></span></div>
            <div class="admin-detail-item"><label>Company</label><span><?= htmlspecialchars($inquiry['company_name']) ?></span></div>
            <div class="admin-detail-item"><label>Phone</label><a href="tel:<?= $inquiry['phone'] ?>"><?= htmlspecialchars($inquiry['phone']) ?></a></div>
            <div class="admin-detail-item"><label>Email</label><span><?= htmlspecialchars($inquiry['email']) ?></span></div>
            <div class="admin-detail-item"><label>City</label><span><?= htmlspecialchars($inquiry['city']) ?></span></div>
            <div class="admin-detail-item"><label>State</label><span><?= htmlspecialchars($inquiry['state']) ?></span></div>
            <div class="admin-detail-item"><label>Business Type</label><span><?= htmlspecialchars($inquiry['business_type'] ?? '—') ?></span></div>
            <div class="admin-detail-item"><label>Annual Requirement</label><span><?= htmlspecialchars($inquiry['annual_requirement'] ?? '—') ?></span></div>
        </div>
        <label class="form-label">Message</label>
        <div class="admin-message-box mb-4"><?= nl2br(htmlspecialchars($inquiry['message'] ?? '')) ?></div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="https://wa.me/91<?= preg_replace('/[^0-9]/', '', $inquiry['phone']) ?>" class="btn btn-success" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
            <a href="tel:<?= $inquiry['phone'] ?>" class="btn btn-outline-primary"><i class="bi bi-telephone me-1"></i> Call</a>
        </div>
    </div>
</div>
<?php endif; ?>
