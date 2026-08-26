<?php
/**
 * Main Entry Point and Simple Router
 */
session_start();

$page = isset($_GET['page']) ? $_GET['page'] : 'admin';

try {
    // Shared Database Connection
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}

// ---------------------------------------------------------
// ROUTE: ADMIN DASHBOARD
// ---------------------------------------------------------
if ($page === 'admin') {
    require_once '../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->store($_POST);
    } else {
        $controller->index();
    }
} 
// ---------------------------------------------------------
// ROUTE: PAYSLIP VIEW
// ---------------------------------------------------------
elseif ($page === 'payslip') {
    require_once '../app/Controllers/PayrollCalculator.php';
    
    $empId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$empId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        die("Employee not found.");
    }

    $stmt = $pdo->query("SELECT limit_amount, rate_percentage FROM tax_bands ORDER BY id ASC");
    $taxBands = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalAllowances = $employee['risk_allowance'] + $employee['shift_allowance'] + $employee['responsibility_allowance'];
    
    $calculator = new PayrollCalculator(
        $employee['basic_income'], 
        $totalAllowances, 
        $taxBands, 
        $employee['loan_balance']
    );
    $breakdown = $calculator->getFullBreakdown();

    require_once '../app/Views/payslip_print.php';
} 
// ---------------------------------------------------------
// ROUTE: EDIT EMPLOYEE VIEW
// ---------------------------------------------------------
elseif ($page === 'edit') {
    require_once '../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->edit(isset($_GET['id']) ? (int)$_GET['id'] : 0);
}
// ---------------------------------------------------------
// ROUTE: UPDATE EMPLOYEE (POST)
// ---------------------------------------------------------
elseif ($page === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->update(isset($_GET['id']) ? (int)$_GET['id'] : 0, $_POST);
}
// ---------------------------------------------------------
// ROUTE: DELETE EMPLOYEE
// ---------------------------------------------------------
elseif ($page === 'delete') {
    require_once '../app/Controllers/AdminController.php';
    $controller = new AdminController($pdo);
    $controller->destroy(isset($_GET['id']) ? (int)$_GET['id'] : 0);
}
// ---------------------------------------------------------
// ROUTE: TAX BANDS DASHBOARD
// ---------------------------------------------------------
elseif ($page === 'taxes') {
    require_once '../app/Controllers/TaxController.php';
    $controller = new TaxController($pdo);
    $controller->index();
}
// ---------------------------------------------------------
// ROUTE: UPDATE TAX BANDS (POST)
// ---------------------------------------------------------
elseif ($page === 'update_taxes' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../app/Controllers/TaxController.php';
    $controller = new TaxController($pdo);
    $controller->updateAll($_POST);
}
// ---------------------------------------------------------
// ROUTE: PAYROLL HISTORY DASHBOARD
// ---------------------------------------------------------
elseif ($page === 'history') {
    require_once '../app/Controllers/PayrollRunController.php';
    $controller = new PayrollRunController($pdo);
    $controller->history();
}
// ---------------------------------------------------------
// ROUTE: RUN PAYROLL (POST)
// ---------------------------------------------------------
elseif ($page === 'run_payroll' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../app/Controllers/PayrollRunController.php';
    $controller = new PayrollRunController($pdo);
    $controller->run();
}
// ---------------------------------------------------------
// ROUTE: VIEW LOCKED MONTH DETAILS
// ---------------------------------------------------------
elseif ($page === 'view_month' && isset($_GET['month'])) {
    require_once '../app/Controllers/PayrollRunController.php';
    $controller = new PayrollRunController($pdo);
    $controller->viewMonth($_GET['month']);
}
// ---------------------------------------------------------
// ROUTE: VIEW LOCKED PAYSLIP (A5 PRINT)
// ---------------------------------------------------------
elseif ($page === 'locked_payslip' && isset($_GET['id'])) {
    require_once '../app/Controllers/PayrollRunController.php';
    $controller = new PayrollRunController($pdo);
    $controller->viewLockedPayslip((int)$_GET['id']);
}
// ---------------------------------------------------------
// 404
// ---------------------------------------------------------
else {
    echo "404 Page Not Found";
}
?>
