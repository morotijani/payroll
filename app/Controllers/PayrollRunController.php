<?php
require_once '../app/Controllers/PayrollCalculator.php';

class PayrollRunController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Display historical payroll runs
     */
    public function history() {
        // Get all unique payroll months processed so far
        $stmt = $this->pdo->query("SELECT payroll_month, COUNT(*) as emp_count, SUM(net_pay) as total_net, SUM(paye) as total_paye 
                                   FROM payslips 
                                   GROUP BY payroll_month 
                                   ORDER BY payroll_month DESC");
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/Views/payroll_history.php';
    }

    /**
     * Run the payroll for the current month
     */
    public function run() {
        $currentMonth = date('Y-m'); // e.g., '2026-08'
        
        // 1. Check if payroll was already run this month
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM payslips WHERE payroll_month = ?");
        $checkStmt->execute([$currentMonth]);
        if ($checkStmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Payroll for " . date('F Y') . " has already been processed!";
            header("Location: index.php?page=history");
            exit;
        }

        // 2. Fetch all employees
        $empStmt = $this->pdo->query("SELECT * FROM employees");
        $employees = $empStmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($employees)) {
            $_SESSION['error'] = "No employees found to process.";
            header("Location: index.php?page=admin");
            exit;
        }

        // 3. Fetch tax bands
        $bandStmt = $this->pdo->query("SELECT limit_amount, rate_percentage FROM tax_bands ORDER BY id ASC");
        $taxBands = $bandStmt->fetchAll(PDO::FETCH_ASSOC);

        // 4. Loop through and save payslips
        $insertSql = "INSERT INTO payslips 
                      (employee_id, employee_name, designation, payroll_month, basic_income, allowances, gross_salary, 
                       ssnit, employer_ssnit, chargeable_income, paye, loan_deduction, net_pay) 
                      VALUES 
                      (:emp_id, :name, :desig, :month, :basic, :allowances, :gross, 
                       :ssnit, :emp_ssnit, :chargeable, :paye, :loan, :net)";
        $insertStmt = $this->pdo->prepare($insertSql);

        $processedCount = 0;
        foreach ($employees as $emp) {
            $totalAllowances = $emp['risk_allowance'] + $emp['shift_allowance'] + $emp['responsibility_allowance'];
            $calculator = new PayrollCalculator(
                $emp['basic_income'], 
                $totalAllowances, 
                $taxBands, 
                $emp['loan_balance']
            );
            $bd = $calculator->getFullBreakdown();

            $insertStmt->execute([
                ':emp_id' => $emp['id'],
                ':name' => $emp['name'],
                ':desig' => $emp['designation'],
                ':month' => $currentMonth,
                ':basic' => $bd['basic_income'],
                ':allowances' => $bd['allowances'],
                ':gross' => $bd['gross_salary'],
                ':ssnit' => $bd['ssnit'],
                ':emp_ssnit' => $bd['employer_ssnit'],
                ':chargeable' => $bd['chargeable_income'],
                ':paye' => $bd['paye'],
                ':loan' => $bd['loan_deduction'],
                ':net' => $bd['net_pay']
            ]);
            $processedCount++;
        }

        $_SESSION['success'] = "Successfully processed payroll for $processedCount employees for " . date('F Y') . "!";
        header("Location: index.php?page=history");
        exit;
    }

    /**
     * View a locked payslip from history
     */
    public function viewLockedPayslip($payslipId) {
        $stmt = $this->pdo->prepare("SELECT * FROM payslips WHERE id = ?");
        $stmt->execute([$payslipId]);
        $locked = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$locked) {
            die("Locked payslip not found.");
        }

        // We will map the locked data to mimic the dynamic structure so we can reuse the payslip_print.php view!
        $employee = [
            'name' => $locked['employee_name'],
            'designation' => $locked['designation'],
            'id' => $locked['employee_id'],
            'risk_allowance' => 0, // We bundled it in history for simplicity, so we'll just show 'Total Allowances' if needed. Or we can just use the locked breakdown.
            'shift_allowance' => 0,
            'responsibility_allowance' => $locked['allowances'], // Cheat to display it on the view
            'loan_balance' => 0 // Already deducted
        ];

        $breakdown = [
            'basic_income' => $locked['basic_income'],
            'allowances' => $locked['allowances'],
            'gross_salary' => $locked['gross_salary'],
            'ssnit' => $locked['ssnit'],
            'employer_ssnit' => $locked['employer_ssnit'],
            'total_ssnit' => $locked['ssnit'] + $locked['employer_ssnit'],
            'chargeable_income' => $locked['chargeable_income'],
            'paye' => $locked['paye'],
            'loan_deduction' => $locked['loan_deduction'],
            'net_pay' => $locked['net_pay']
        ];
        
        // Override the pay period date for the view
        $payPeriodOverride = date('F Y', strtotime($locked['payroll_month'] . '-01'));

        require_once '../app/Views/payslip_print.php';
    }
    
    /**
     * View all payslips for a specific month
     */
    public function viewMonth($month) {
        $stmt = $this->pdo->prepare("SELECT * FROM payslips WHERE payroll_month = ?");
        $stmt->execute([$month]);
        $payslips = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once '../app/Views/payroll_month_details.php';
    }
}
?>
