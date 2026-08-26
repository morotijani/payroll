<?php
require_once 'app/Controllers/PayrollCalculator.php';

// Simulate fetching GRA tax bands from the database
$taxBands = [
    ['limit_amount' => 490.00,  'rate_percentage' => 0.0],
    ['limit_amount' => 110.00,  'rate_percentage' => 5.0],
    ['limit_amount' => 130.00,  'rate_percentage' => 10.0],
    ['limit_amount' => 3166.67, 'rate_percentage' => 17.5], // Exact GRA band
    ['limit_amount' => 16000.00,'rate_percentage' => 25.0],
    ['limit_amount' => null,    'rate_percentage' => 30.0], // Exceeding
];

// Based on the user's CEO example
$basicIncome = 10000;
$allowances = 5000; // Total of risk, shift, responsibility

$calculator = new PayrollCalculator($basicIncome, $allowances, $taxBands);

$breakdown = $calculator->getFullBreakdown();

echo "--- PAYROLL CALCULATION TEST ---\n";
echo "Gross Salary:      " . $breakdown['gross_salary'] . "\n";
echo "SSNIT (5.5%):      " . $breakdown['ssnit'] . "\n";
echo "Chargeable Income: " . $breakdown['chargeable_income'] . "\n";
echo "PAYE Tax:          " . $breakdown['paye'] . "\n";
echo "Net Pay:           " . $breakdown['net_pay'] . "\n";
?>
