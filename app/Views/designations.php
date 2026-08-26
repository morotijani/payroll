<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="page-title mb-0">Manage Designations</h1>
</div>

<div class="row g-4">
    <!-- List Designations -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">badge</span> Job Titles
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">DESIGNATION NAME</th>
                                <th class="text-end pe-4">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($designations as $designation): ?>
                                <tr>
                                    <td class="ps-4" style="vertical-align: middle;">
                                        <strong><?= htmlspecialchars($designation['name']) ?></strong>
                                    </td>
                                    <td class="text-end pe-4" style="vertical-align: middle;">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light text-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $designation['id'] ?>">
                                                <span class="material-symbols-rounded">edit</span>
                                            </button>
                                            <a href="index.php?page=delete_designation&id=<?= $designation['id'] ?>" class="btn btn-light text-danger" onclick="return confirm('Are you sure you want to delete this designation?');">
                                                <span class="material-symbols-rounded">delete</span>
                                            </a>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade text-start" id="editModal<?= $designation['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(26,11,46,0.1);">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title" style="font-weight: 700; color: var(--text-dark);">Edit Designation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <form action="index.php?page=update_designation" method="POST">
                                                            <input type="hidden" name="id" value="<?= $designation['id'] ?>">
                                                            <div class="mb-4">
                                                                <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Designation Name</label>
                                                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($designation['name']) ?>" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center py-3">
                                                                Update Designation <span class="material-symbols-rounded ms-2" style="font-size: 18px;">save</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($designations)): ?>
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">No designations found. Add one to populate the dropdown.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Designation Form -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">add_circle</span> Add New
            </div>
            <div class="card-body px-4 pb-4">
                <form action="index.php?page=add_designation" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Senior Developer" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center align-items-center py-3">
                        Save Designation <span class="material-symbols-rounded ms-2" style="font-size: 18px;">save</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
