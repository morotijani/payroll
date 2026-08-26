<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS payslips (
        id INT AUTO_INCREMENT PRIMARY KEY,
        employee_id INT NOT NULL,
        employee_name VARCHAR(255) NOT NULL,
        designation VARCHAR(150) NOT NULL,
        payroll_month VARCHAR(20) NOT NULL,
        basic_income DECIMAL(10,2) NOT NULL,
        allowances DECIMAL(10,2) NOT NULL,
        gross_salary DECIMAL(10,2) NOT NULL,
        ssnit DECIMAL(10,2) NOT NULL,
        employer_ssnit DECIMAL(10,2) NOT NULL,
        chargeable_income DECIMAL(10,2) NOT NULL,
        paye DECIMAL(10,2) NOT NULL,
        loan_deduction DECIMAL(10,2) NOT NULL,
        net_pay DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);
    echo "Payslips table created successfully.";
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage();
}
?>
