<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <a href="index.php?page=history" class="btn btn-light rounded-pill mb-3 d-inline-flex align-items-center" style="font-size: 0.85rem; padding: 6px 16px;">
            <span class="material-symbols-rounded me-1" style="font-size: 16px;">arrow_back</span> Back to History
        </a>
        <h1 class="page-title mb-0">Locked Payslips: <?= date('F Y', strtotime($month . '-01')) ?></h1>
    </div>
</div>

<div class="card">
    <div class="card-header text-center" style="font-size: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; padding-top: 30px;">
        PAYROLL DETAILS
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Designation</th>
                    <th>Gross Salary</th>
                    <th>PAYE</th>
                    <th>Net Pay</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payslips as $ps): ?>
                <tr>
                    <td>
                        <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($ps['employee_name']) ?></div>
                    </td>
                    <td>
                        <span style="background-color: var(--white); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 500;">
                            <?= htmlspecialchars($ps['designation']) ?>
                        </span>
                    </td>
                    <td class="fw-semibold text-muted">GHS <?= number_format($ps['gross_salary'], 2) ?></td>
                    <td class="fw-semibold" style="color: #c0392b;">GHS <?= number_format($ps['paye'], 2) ?></td>
                    <td class="fw-bold" style="color: #27ae60;">GHS <?= number_format($ps['net_pay'], 2) ?></td>
                    <td class="text-end">
                        <a href="index.php?page=locked_payslip&id=<?= $ps['id'] ?>" target="_blank" class="btn btn-sm btn-light text-primary rounded-pill px-3 d-inline-flex align-items-center">
                            <span class="material-symbols-rounded me-1" style="font-size: 16px;">print</span> Print A5
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
