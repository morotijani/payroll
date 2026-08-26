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
}
?>
