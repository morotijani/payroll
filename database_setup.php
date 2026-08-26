<?php
/**
 * Database Setup Script for Payroll System
 * Run this script once to create the database, tables, and seed the initial tax bands.
 */

$host = '127.0.0.1'; // Standard XAMPP host
$username = 'root';  // Standard XAMPP user
$password = '';      // Standard XAMPP password (blank by default)

try {
    // 1. Connect to MySQL server (without selecting a specific database yet)
    $pdo = new PDO("mysql:host=$host", $username, $password);
    
    // Set PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Create the Database if it doesn't exist
    $dbName = 'payroll_db';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbName' created or already exists.<br>";

    // 3. Switch to the newly created database
    $pdo->exec("USE `$dbName`");

    // 4. Create the `employees` table
    $createEmployeesTable = "
        CREATE TABLE IF NOT EXISTS employees (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            designation VARCHAR(150) NOT NULL,
            basic_income DECIMAL(10,2) DEFAULT 0.00,
            risk_allowance DECIMAL(10,2) DEFAULT 0.00,
            shift_allowance DECIMAL(10,2) DEFAULT 0.00,
            responsibility_allowance DECIMAL(10,2) DEFAULT 0.00,
            loan_balance DECIMAL(10,2) DEFAULT 0.00,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $pdo->exec($createEmployeesTable);
    echo "Table 'employees' created successfully.<br>";

    // 5. Create the `tax_bands` table
    $createTaxBandsTable = "
        CREATE TABLE IF NOT EXISTS tax_bands (
            id INT AUTO_INCREMENT PRIMARY KEY,
            limit_amount DECIMAL(15,2) NULL COMMENT 'The width of the tax band. NULL means infinity/excess.',
            rate_percentage DECIMAL(5,2) NOT NULL
        )
    ";
    $pdo->exec($createTaxBandsTable);
    echo "Table 'tax_bands' created successfully.<br>";

    // 6. Clear existing tax bands (useful if you run this script multiple times)
    $pdo->exec("TRUNCATE TABLE tax_bands");

    // 7. Insert the GRA Tax Bands 
    // We use NULL for the final band to represent "exceeding" / infinity
    $insertTaxBands = "
        INSERT INTO tax_bands (limit_amount, rate_percentage) VALUES
        (490.00, 0.00),      -- First 490
        (110.00, 5.00),      -- Next 110
        (130.00, 10.00),     -- Next 130
        (3000.00, 17.50),    -- Next 3,000
        (16270.00, 25.00),   -- Next 16,270
        (NULL, 30.00)        -- Exceeding 20,000 (NULL represents the rest)
    ";
    $pdo->exec($insertTaxBands);
    echo "GRA Tax bands seeded successfully.<br>";

    // 8. Optional: Insert a sample employee based on the CEO example you provided earlier
    $pdo->exec("TRUNCATE TABLE employees");
    $insertSampleEmployee = "
        INSERT INTO employees (name, designation, basic_income, risk_allowance, shift_allowance, responsibility_allowance, loan_balance) 
        VALUES ('John Doe', 'CEO', 10000.00, 2000.00, 500.00, 2500.00, 0.00)
    ";
    $pdo->exec($insertSampleEmployee);
    echo "Sample CEO employee inserted successfully.<br>";

    echo "<br><strong>All database setup steps completed successfully!</strong>";

} catch (PDOException $e) {
    die("<strong style='color:red;'>Database Setup Failed:</strong> " . $e->getMessage());
}
?>
