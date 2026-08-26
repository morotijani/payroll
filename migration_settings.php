<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS company_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        company_name VARCHAR(255) NOT NULL,
        company_email VARCHAR(255),
        company_phone VARCHAR(50),
        company_address TEXT
    )";
    $pdo->exec($sql);
    
    // Seed default settings if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM company_settings");
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT INTO company_settings (company_name, company_email, company_phone, company_address) VALUES (?, ?, ?, ?)");
        $insert->execute(['PayMaster Inc.', 'hello@paymaster.com', '+233 54 000 0000', 'Accra, Ghana']);
        echo "Company settings table created and seeded.";
    } else {
        echo "Company settings table exists and is already seeded.";
    }
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage();
}
?>
