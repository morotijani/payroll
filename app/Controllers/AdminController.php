<?php

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Display the Admin Dashboard with list of employees
     */
    public function index() {
        // Fetch all employees
        $stmt = $this->pdo->query("SELECT * FROM employees ORDER BY id DESC");
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fetch all designations
        $desigStmt = $this->pdo->query("SELECT name FROM designations ORDER BY name ASC");
        $designations = $desigStmt->fetchAll(PDO::FETCH_COLUMN);
        
        // Grab any success messages from the session
        $success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
        unset($_SESSION['success']);
        
        // Load the view
        require_once '../app/Views/admin.php';
    }

    /**
     * Handle the POST request to save a new employee
     */
    public function store($data) {
        $sql = "INSERT INTO employees 
                (name, designation, basic_income, risk_allowance, shift_allowance, responsibility_allowance, loan_balance) 
                VALUES (:name, :designation, :basic_income, :risk, :shift, :resp, :loan)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':designation' => $data['designation'],
            ':basic_income' => !empty($data['basic_income']) ? $data['basic_income'] : 0,
            ':risk' => !empty($data['risk_allowance']) ? $data['risk_allowance'] : 0,
            ':shift' => !empty($data['shift_allowance']) ? $data['shift_allowance'] : 0,
            ':resp' => !empty($data['responsibility_allowance']) ? $data['responsibility_allowance'] : 0,
            ':loan' => !empty($data['loan_balance']) ? $data['loan_balance'] : 0
        ]);

        // Flash message for successful addition
        $_SESSION['success'] = "Employee '{$data['name']}' was added successfully!";
        
        // Redirect back to admin dashboard
        header("Location: index.php?page=admin");
        exit;
    }

    /**
     * Load the Edit Employee form
     */
    public function edit($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            die("Employee not found.");
        }
        
        $desigStmt = $this->pdo->query("SELECT name FROM designations ORDER BY name ASC");
        $designations = $desigStmt->fetchAll(PDO::FETCH_COLUMN);

        require_once '../app/Views/edit_employee.php';
    }

    /**
     * Handle the POST request to update an existing employee
     */
    public function update($id, $data) {
        $sql = "UPDATE employees SET 
                name = :name, 
                designation = :designation, 
                basic_income = :basic, 
                risk_allowance = :risk, 
                shift_allowance = :shift, 
                responsibility_allowance = :resp, 
                loan_balance = :loan 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':designation' => $data['designation'],
            ':basic' => !empty($data['basic_income']) ? $data['basic_income'] : 0,
            ':risk' => !empty($data['risk_allowance']) ? $data['risk_allowance'] : 0,
            ':shift' => !empty($data['shift_allowance']) ? $data['shift_allowance'] : 0,
            ':resp' => !empty($data['responsibility_allowance']) ? $data['responsibility_allowance'] : 0,
            ':loan' => !empty($data['loan_balance']) ? $data['loan_balance'] : 0,
            ':id' => $id
        ]);

        $_SESSION['success'] = "Employee '{$data['name']}' updated successfully!";
        header("Location: index.php?page=admin");
        exit;
    }

    /**
     * Delete an employee
     */
    public function destroy($id) {
        $stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Employee deleted successfully!";
        header("Location: index.php?page=admin");
        exit;
    }

    /**
     * Load the Help & Documentation page
     */
    public function help() {
        require_once '../app/Views/help.php';
    }
}
?>
