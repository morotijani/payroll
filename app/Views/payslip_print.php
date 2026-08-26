<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - <?= htmlspecialchars($employee['name']) ?></title>
    <!-- Assumes this file is loaded via public/index.php -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Print Button (hidden during actual printing) -->
    <div class="actions no-print">
        <button onclick="window.print()">🖨️ Print Payslip (A5)</button>
    </div>

    <!-- The physical boundaries of the Half-A4 / A5 sheet -->
    <div class="payslip-container">
        
        <!-- Header -->
        <div class="header">
            <div class="header-text">
                <h1>ACME Corporation Ltd.</h1>
                <p>Official Digital Payslip</p>
            </div>
            <div class="header-date">
                <!-- Using current month/year for the demo -->
                <p><strong>Pay Period:</strong> <?= date('F Y') ?></p>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="employee-details">
            <table>
                <tr>
                    <th>Employee Name:</th>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <th>Employee ID:</th>
                    <td>EMP-<?= str_pad($employee['id'], 4, '0', STR_PAD_LEFT) ?></td>
                </tr>
                <tr>
                    <th>Designation:</th>
                    <td><?= htmlspecialchars($employee['designation']) ?></td>
                    <th>Department:</th>
                    <td>Executive</td>
                </tr>
            </table>
        </div>

        <!-- Financials -->
        <div class="financials">
            
            <!-- EARNINGS COLUMN -->
            <div class="column earnings">
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
                        <td>Resp. Allowance</td>
                        <td class="amount">GHS <?= number_format($employee['responsibility_allowance'], 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <tr style="border-top: 1px dashed #ccc; font-weight: bold;">
                        <td style="padding-top: 10px;">Gross Earnings</td>
                        <td class="amount" style="padding-top: 10px;">GHS <?= number_format($breakdown['gross_salary'], 2) ?></td>
                    </tr>
                </table>
            </div>

            <!-- DEDUCTIONS COLUMN -->
            <div class="column deductions">
                <h3>Deductions</h3>
                <table class="items">
                    <tr>
                        <td>SSNIT (Tier 1 - 5.5%)</td>
                        <td class="amount">GHS <?= number_format($breakdown['ssnit'], 2) ?></td>
                    </tr>
                    <tr>
                        <td style="color: #666; font-size: 13px;"><em>Chargeable Income</em></td>
                        <td class="amount" style="color: #666; font-size: 13px;"><em>GHS <?= number_format($breakdown['chargeable_income'], 2) ?></em></td>
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

                    <tr style="border-top: 1px dashed #ccc; font-weight: bold;">
                        <td style="padding-top: 10px;">Total Deductions</td>
                        <?php $totalDeductions = $breakdown['ssnit'] + $breakdown['paye'] + $breakdown['loan_deduction']; ?>
                        <td class="amount" style="padding-top: 10px;">GHS <?= number_format($totalDeductions, 2) ?></td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- Informational Section -->
        <div style="margin-bottom: 15px; background-color: #f8f9fa; padding: 10px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 13px; color: #555;">
            <strong>Company Contributions (Not Deducted from Pay):</strong><br>
            Employer SSNIT (13%): <strong>GHS <?= number_format($breakdown['employer_ssnit'], 2) ?></strong><br>
            <em>Total SSNIT Remitted to GRA: GHS <?= number_format($breakdown['total_ssnit'], 2) ?></em>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="loan-balance">
                <?php if ($employee['loan_balance'] > 0): ?>
                    Outstanding Loan Balance: <strong>GHS <?= number_format($employee['loan_balance'], 2) ?></strong>
                <?php else: ?>
                    <em>No outstanding loans.</em>
                <?php endif; ?>
            </div>
            <div class="net-pay">
                Net Take-Home Pay: GHS <?= number_format($breakdown['net_pay'], 2) ?>
            </div>
        </div>

    </div>

</body>
</html>
