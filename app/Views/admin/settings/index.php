<div class="admin-topbar">
    <h1 class="admin-page-title">Site Settings</h1>
</div>

<?php if ($saved): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($saved) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#set-general">General</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#set-contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#set-images">Images</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#set-tracking">Tracking</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#set-integrations">Integrations</a></li>
                </ul>
            </div>
            <div class="admin-card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="settings">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="set-general">
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Site Name</label><input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">Years Experience</label><input type="text" name="years_experience" class="form-control" value="<?= htmlspecialchars($settings['years_experience'] ?? '30') ?>"></div>
                                <div class="col-md-6"><label class="form-label">GST Number</label><input type="text" name="gst_number" class="form-control" value="<?= htmlspecialchars($settings['gst_number'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($settings['contact_person'] ?? '') ?>"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="set-contact">
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Phone (Primary)</label><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">Phone (Secondary)</label><input type="text" name="phone_secondary" class="form-control" value="<?= htmlspecialchars($settings['phone_secondary'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($settings['email'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">WhatsApp (country code, no +)</label><input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>"></div>
                                <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($settings['address'] ?? '') ?></textarea></div>
                                <div class="col-md-6"><label class="form-label">Facebook URL</label><input type="text" name="facebook_url" class="form-control" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>"></div>
                                <div class="col-md-6"><label class="form-label">Instagram URL</label><input type="text" name="instagram_url" class="form-control" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="set-images">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Site Logo</label>
                                    <?php if (!empty($settings['site_logo'])): ?>
                                    <img src="<?= upload_url($settings['site_logo']) ?>" class="admin-img-preview d-block mb-2" alt="">
                                    <?php endif; ?>
                                    <input type="file" name="site_logo" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Hero / Flyer Image</label>
                                    <?php if (!empty($settings['hero_image'])): ?>
                                    <img src="<?= upload_url($settings['hero_image']) ?>" class="admin-img-preview d-block mb-2" alt="">
                                    <?php endif; ?>
                                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Shown on homepage hero section</small>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="set-tracking">
                            <label class="form-label">Track Delivery Portal URL</label>
                            <input type="text" name="track_delivery_url" class="form-control" value="<?= htmlspecialchars($settings['track_delivery_url'] ?? '') ?>" placeholder="https://courier.com/track?awb={id}">
                            <small class="text-muted">Use <code>{id}</code> for docket number placeholder</small>
                        </div>
                        <div class="tab-pane fade" id="set-integrations">
                            <div class="mb-3"><label class="form-label">Google Map Embed</label><textarea name="google_map_embed" class="form-control" rows="3"><?= htmlspecialchars($settings['google_map_embed'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Google Analytics</label><textarea name="google_analytics" class="form-control" rows="3"><?= htmlspecialchars($settings['google_analytics'] ?? '') ?></textarea></div>
                            <div class="mb-3"><label class="form-label">Google Search Console</label><textarea name="google_search_console" class="form-control" rows="2"><?= htmlspecialchars($settings['google_search_console'] ?? '') ?></textarea></div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-1"></i> Save All Settings</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">Change Password</div>
            <div class="admin-card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="password">
                    <div class="mb-3"><label class="form-label">New Password</label><input type="password" name="new_password" class="form-control" minlength="6" required></div>
                    <div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="confirm_password" class="form-control" required></div>
                    <button type="submit" class="btn btn-warning w-100">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
