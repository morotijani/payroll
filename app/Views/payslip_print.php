<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - <?= htmlspecialchars($employee['name']) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <?php global $globalSettings; ?>
    <link rel="icon" href="<?= !empty($globalSettings['company_logo']) ? htmlspecialchars($globalSettings['company_logo']) : 'images/default_logo.png' ?>" type="image/png">
</head>
<body>

    <div class="actions no-print">
        <button onclick="window.print()">
            <span class="material-symbols-rounded">print</span> Print Payslip
        </button>
    </div>

    <div class="payslip-container">
        
        <!-- Header -->
        <div class="header">
            <div>
                <h1 style="display: flex; align-items: center; gap: 12px;">
                    <?php if (!empty($globalSettings['company_logo'])): ?>
                        <img src="<?= htmlspecialchars($globalSettings['company_logo']) ?>" alt="Logo" style="height: 40px; border-radius: 4px;">
                    <?php else: ?>
                        <img src="images/default_logo.png" alt="Logo" style="height: 40px; border-radius: 4px;">
                    <?php endif; ?>
                    <?= htmlspecialchars($globalSettings['company_name'] ?? 'PayMaster') ?>
                </h1>
                <p>Official Digital Payslip</p>
                <div style="font-size: 13px; color: var(--text-muted); margin-top: 5px;">
                    <?php if(!empty($globalSettings['company_address'])) echo htmlspecialchars($globalSettings['company_address']) . '<br>'; ?>
                    <?php if(!empty($globalSettings['company_phone'])) echo htmlspecialchars($globalSettings['company_phone']) . ' | '; ?>
                    <?php if(!empty($globalSettings['company_email'])) echo htmlspecialchars($globalSettings['company_email']); ?>
                </div>
            </div>
            <div style="text-align: right;">
                <p><strong>Pay Period:</strong> <?= isset($payPeriodOverride) ? $payPeriodOverride : date('F Y') ?></p>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="employee-details">
            <table>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Designation</th>
                </tr>
                <tr>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td>EMP-<?= str_pad($employee['id'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td><?= htmlspecialchars($employee['designation']) ?></td>
                </tr>
            </table>
        </div>

        <!-- Financials -->
        <div class="financials">
            
            <!-- EARNINGS COLUMN -->
            <div class="column">
                <h3>Earnings</h3>
                <table class="items">
                    <tr>
                        <td>Basic Income</td>
                        <td class="amount">GHS <?= number_format($breakdown['basic_income'], 2) ?></td>
                    </tr>
                    <?php if ($employee['risk_allowance'] > 0): ?>
                    <tr>
                        <td>Risk Allowance</td>
                        <td class="amount">GHS <?= number_format($employee['risk_allowance'], 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($employee['shift_allowance'] > 0): ?>
                    <tr>
                        <td>Shift Allowance</td>
                        <td class="amount">GHS <?= number_format($employee['shift_allowance'], 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($employee['responsibility_allowance'] > 0): ?>
                    <tr>
                        <td>Responsibility Allow.</td>
                        <td class="amount">GHS <?= number_format($employee['responsibility_allowance'], 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr class="total-row">
                        <td>Gross Earnings</td>
                        <td class="amount">GHS <?= number_format($breakdown['gross_salary'], 2) ?></td>
                    </tr>
                </table>
            </div>

            <!-- DEDUCTIONS COLUMN -->
            <div class="column">
                <h3>Deductions</h3>
                <table class="items">
                    <tr>
                        <td>SSNIT (Tier 1 - 5.5%)</td>
                        <td class="amount">GHS <?= number_format($breakdown['ssnit'], 2) ?></td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-muted); font-size: 13px;"><em>Chargeable Income</em></td>
                        <td class="amount" style="color: var(--text-muted); font-size: 13px;"><em>GHS <?= number_format($breakdown['chargeable_income'], 2) ?></em></td>
                    </tr>
                    <tr>
                        <td>Income Tax (PAYE)</td>
                        <td class="amount">GHS <?= number_format($breakdown['paye'], 2) ?></td>
                    </tr>
                    <?php if ($breakdown['loan_deduction'] > 0): ?>
                    <tr>
                        <td>Loan Repayment</td>
                        <td class="amount">GHS <?= number_format($breakdown['loan_deduction'], 2) ?></td>
                    </tr>
                    <?php endif; ?>

                    <tr class="total-row">
                        <td>Total Deductions</td>
                        <?php $totalDeductions = $breakdown['ssnit'] + $breakdown['paye'] + $breakdown['loan_deduction']; ?>
                        <td class="amount">GHS <?= number_format($totalDeductions, 2) ?></td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- Informational Section -->
        <div class="company-contributions">
            <div>
                <span class="material-symbols-rounded" style="color: var(--text-muted); margin-right: 5px;">info</span>
                <strong>Company Contributions</strong> (Not Deducted from Pay)
            </div>
            <div style="text-align: right;">
                Employer SSNIT (13%): <strong>GHS <?= number_format($breakdown['employer_ssnit'], 2) ?></strong>
                <br>
                <em style="font-size: 11px;">Total Remitted to GRA: GHS <?= number_format($breakdown['total_ssnit'], 2) ?></em>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="loan-balance">
                <?php if ($employee['loan_balance'] > 0): ?>
                    Outstanding Loan Balance:<br>
                    <strong>GHS <?= number_format($employee['loan_balance'], 2) ?></strong>
                <?php else: ?>
                    <span style="color: #bbb;">No outstanding loans.</span>
                <?php endif; ?>
            </div>
            <div class="net-pay-box">
                <div class="net-pay-label">Net Take-Home Pay</div>
                <div class="net-pay-amount">GHS <?= number_format($breakdown['net_pay'], 2) ?></div>
            </div>
        </div>

    </div>

</body>
</html>
