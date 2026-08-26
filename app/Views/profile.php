<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="page-title mb-0">Admin Profile</h1>
</div>

<div class="row g-4">
    <!-- Update Profile -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">person</span> Profile Details
            </div>
            <div class="card-body">
                <form action="index.php?page=update_profile" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" disabled style="background-color: #EBE7F2; cursor: not-allowed;">
                        <small class="text-muted ms-2 mt-1 d-block">Username cannot be changed.</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($admin['full_name']) ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary d-flex align-items-center px-4 py-2">
                        Update Profile <span class="material-symbols-rounded ms-2">save</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">lock</span> Change Password
            </div>
            <div class="card-body">
                <form action="index.php?page=change_password" method="POST">
                    <div class="mb-3">
                        <input type="password" name="old_password" class="form-control" placeholder="Current Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="new_password" class="form-control" placeholder="New Password" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary d-flex align-items-center px-4 py-2" style="background-color: #27ae60;">
                        Change Password <span class="material-symbols-rounded ms-2">key</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
