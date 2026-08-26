<?php
/**
 * Entry point for the Payroll Application (MVC Router Simulation)
 * For demonstration purposes, this will automatically fetch our test CEO 
 * and render their payslip directly on load.
 */

// 1. Include the Calculator logic (Controller)
require_once '../app/Controllers/PayrollCalculator.php';

try {
    // 2. Connect to the Database
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Fetch the Employee (Our test CEO: John Doe)
    $stmt = $pdo->query("SELECT * FROM employees LIMIT 1");
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        die("No employees found in the database. Did you run database_setup.php?");
    }

    // 4. Fetch the GRA Tax Bands
    $stmt = $pdo->query("SELECT limit_amount, rate_percentage FROM tax_bands ORDER BY id ASC");
    $taxBands = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$taxBands) {
        die("No tax bands found in the database.");
    }

    // 5. Aggregate Allowances and calculate the Breakdown
    $totalAllowances = $employee['risk_allowance'] + $employee['shift_allowance'] + $employee['responsibility_allowance'];
    
    // For this demo, let's assume a sample loan deduction if there is a loan balance
    $monthlyLoanDeduction = 0.00;
    if ($employee['loan_balance'] > 0) {
        $monthlyLoanDeduction = 500.00; // Hardcoded deduction for demo purposes
    }

    // Instantiate our Controller Logic
    $calculator = new PayrollCalculator(
        $employee['basic_income'], 
        $totalAllowances, 
        $taxBands, 
        $monthlyLoanDeduction
    );
    
    $breakdown = $calculator->getFullBreakdown();

    // 6. Load the View (pass the $employee and $breakdown variables to it)
    require_once '../app/Views/payslip_print.php';

} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}
?>
