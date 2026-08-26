<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Global employees</h1>
</div>

<div class="row g-4">
    <!-- Employees List -->
    <div class="col-xl-8 col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                Staff Roster
            </div>
            <div class="card-body table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Employee Details</th>
                            <th>Designation</th>
                            <th>Base Salary</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($employees)): ?>
                            <tr><td colspan="4" class="text-center py-5 text-muted">No employees found in the database.</td></tr>
                        <?php else: ?>
                            <?php foreach ($employees as $emp): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($emp['name']) ?></div>
                                        <div style="color: var(--text-muted); font-size: 0.85rem;">ID: EMP-<?= str_pad($emp['id'], 4, '0', STR_PAD_LEFT) ?></div>
                                    </td>
                                    <td>
                                        <span style="background-color: var(--white); padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 500;">
                                            <?= htmlspecialchars($emp['designation']) ?>
                                        </span>
                                    </td>
                                    <td class="fw-semibold">GHS <?= number_format($emp['basic_income'], 2) ?></td>
                                    <td class="text-end">
                                        <a href="index.php?page=edit&id=<?= $emp['id'] ?>" class="btn btn-sm btn-light text-primary">
                                            <span class="material-symbols-rounded" style="font-size: 16px;">edit</span> Edit
                                        </a>
                                        <a href="index.php?page=payslip&id=<?= $emp['id'] ?>" target="_blank" class="btn btn-sm btn-light text-primary mx-1">
                                            <span class="material-symbols-rounded" style="font-size: 16px;">receipt_long</span> Payslip
                                        </a>
                                        <a href="index.php?page=delete&id=<?= $emp['id'] ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Delete this employee? This action cannot be undone.');">
                                            <span class="material-symbols-rounded" style="font-size: 16px;">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Employee Form -->
    <div class="col-xl-4 col-lg-5">
        <div class="card h-100">
            <div class="card-header text-center" style="font-size: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; padding-top: 30px;">
                ADD NEW HIRE
            </div>
            <div class="card-body px-4">
                <form action="index.php?page=admin" method="POST">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="designation" class="form-control" placeholder="Designation" required>
                    </div>
                    <div class="mb-4">
                        <input type="number" step="0.01" name="basic_income" class="form-control" placeholder="Basic Income (GHS)" required>
                    </div>
                    
                    <div class="inner-card mb-4">
                        <div class="text-center mb-3" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">ALLOWANCES & DEDUCTIONS</div>
                        
                        <div class="mb-3">
                            <input type="number" step="0.01" name="risk_allowance" class="form-control form-control-sm" placeholder="Risk Allowance (GHS)">
                        </div>
                        <div class="mb-3">
                            <input type="number" step="0.01" name="shift_allowance" class="form-control form-control-sm" placeholder="Shift Allowance (GHS)">
                        </div>
                        <div class="mb-3">
                            <input type="number" step="0.01" name="responsibility_allowance" class="form-control form-control-sm" placeholder="Responsibility (GHS)">
                        </div>
                        <div class="mb-0">
                            <input type="number" step="0.01" name="loan_balance" class="form-control form-control-sm" placeholder="Loan Balance (GHS)">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 d-flex justify-content-center align-items-center">
                        Save Employee <span class="material-symbols-rounded ms-2" style="font-size: 18px;">arrow_forward</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
