<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h1 class="page-title mb-0">Payroll History</h1>
    
    <form action="index.php?page=run_payroll" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to run payroll for the current month? This will lock the payslips into history.');">
        <button type="submit" class="btn btn-primary px-4 py-3 d-flex align-items-center shadow-sm">
            <span class="material-symbols-rounded me-2">play_circle</span> Run Payroll for <?= date('F Y') ?>
        </button>
    </form>
</div>

<div class="card">
    <div class="card-header text-center" style="font-size: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; padding-top: 30px;">
        HISTORICAL RUNS
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Payroll Month</th>
                    <th>Employees</th>
                    <th>Total PAYE</th>
                    <th>Total Net Payout</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($history)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <span class="material-symbols-rounded d-block mb-2" style="font-size: 40px; color: var(--card-bg);">history</span>
                            No payroll runs yet.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($history as $run): ?>
                    <tr>
                        <td>
                            <div class="fw-bold text-dark fs-5"><?= date('F Y', strtotime($run['payroll_month'] . '-01')) ?></div>
                        </td>
                        <td>
                            <span style="background-color: var(--white); padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; color: var(--text-dark);">
                                <?= $run['emp_count'] ?> Processed
                            </span>
                        </td>
                        <td class="fw-semibold text-muted">GHS <?= number_format($run['total_paye'], 2) ?></td>
                        <td class="fw-bold" style="color: #27ae60;">GHS <?= number_format($run['total_net'], 2) ?></td>
                        <td class="text-end">
                            <a href="index.php?page=view_month&month=<?= $run['payroll_month'] ?>" class="btn btn-sm btn-light text-primary rounded-pill px-4 d-inline-flex align-items-center">
                                View Details <span class="material-symbols-rounded ms-1" style="font-size: 18px;">arrow_forward</span>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'layout_footer.php'; ?>
