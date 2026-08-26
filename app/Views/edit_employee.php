<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <a href="index.php?page=admin" class="btn btn-light rounded-pill mb-3 d-inline-flex align-items-center" style="font-size: 0.85rem; padding: 6px 16px;">
            <span class="material-symbols-rounded me-1" style="font-size: 16px;">arrow_back</span> Back to Directory
        </a>
        <h1 class="page-title mb-0">Edit Employee</h1>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card">
            <div class="card-header text-center" style="font-size: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; padding-top: 30px;">
                UPDATE <?= htmlspecialchars($employee['name']) ?>
            </div>
            <div class="card-body px-5 pb-5">
                <form action="index.php?page=update&id=<?= $employee['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($employee['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted ms-2" style="font-size: 0.8rem;">Designation</label>
                        <select name="designation" class="form-select" required>
                            <option value="">Select Designation</option>
                            <?php foreach ($designations as $desig): ?>
                                <option value="<?= htmlspecialchars($desig) ?>" <?= $employee['designation'] === $desig ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($desig) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Basic Income (GHS)</label>
                        <input type="number" step="0.01" name="basic_income" class="form-control" value="<?= htmlspecialchars($employee['basic_income']) ?>" required>
                    </div>
                    
                    <div class="inner-card mb-4">
                        <div class="text-center mb-3" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">ALLOWANCES & DEDUCTIONS</div>
                        
                        <div class="mb-3">
                            <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Risk Allowance</label>
                            <input type="number" step="0.01" name="risk_allowance" class="form-control" value="<?= htmlspecialchars($employee['risk_allowance']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Shift Allowance</label>
                            <input type="number" step="0.01" name="shift_allowance" class="form-control" value="<?= htmlspecialchars($employee['shift_allowance']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Responsibility Allowance</label>
                            <input type="number" step="0.01" name="responsibility_allowance" class="form-control" value="<?= htmlspecialchars($employee['responsibility_allowance']) ?>">
                        </div>
                        <div class="mb-0">
                            <label class="form-label ms-2 text-muted" style="font-size: 0.8rem;">Loan Balance</label>
                            <input type="number" step="0.01" name="loan_balance" class="form-control" value="<?= htmlspecialchars($employee['loan_balance']) ?>">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 d-flex justify-content-center align-items-center">
                        Save Changes <span class="material-symbols-rounded ms-2" style="font-size: 18px;">arrow_forward</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
