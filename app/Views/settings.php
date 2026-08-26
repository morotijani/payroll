<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="page-title mb-0">Company Settings</h1>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">business</span> Company Profile
            </div>
            <div class="card-body px-5 pb-5">
                
                <div class="alert mb-4" style="background-color: var(--bg-color); border-radius: 16px; border: none; color: var(--text-dark);">
                    <span class="material-symbols-rounded" style="color: var(--text-muted); margin-right: 10px;">info</span>
                    These details will appear on the official generated payslips.
                </div>

                <form action="index.php?page=update_settings" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-4 d-flex align-items-center">
                        <?php if (!empty($settings['company_logo'])): ?>
                            <img src="<?= htmlspecialchars($settings['company_logo']) ?>" alt="Logo" style="height: 50px; border-radius: 8px; margin-right: 15px; border: 1px solid var(--border-color);">
                        <?php else: ?>
                            <img src="images/default_logo.png" alt="Logo" style="height: 50px; border-radius: 8px; margin-right: 15px; border: 1px solid var(--border-color);">
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Company Logo (Optional)</label>
                            <input type="file" name="company_logo" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($settings['company_name']) ?>" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Official Email</label>
                            <input type="email" name="company_email" class="form-control" value="<?= htmlspecialchars($settings['company_email']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Phone Number</label>
                            <input type="text" name="company_phone" class="form-control" value="<?= htmlspecialchars($settings['company_phone']) ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Physical Address</label>
                        <textarea name="company_address" class="form-control" rows="3" style="border-radius: 16px; resize: none;"><?= htmlspecialchars($settings['company_address']) ?></textarea>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 d-inline-flex justify-content-center align-items-center">
                            Save Settings <span class="material-symbols-rounded ms-2" style="font-size: 18px;">save</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
