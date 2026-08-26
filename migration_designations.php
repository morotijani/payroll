<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS designations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE
    )";
    $pdo->exec($sql);
    
    // Seed default designations if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM designations");
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT IGNORE INTO designations (name) VALUES (?)");
        $defaults = ['CEO', 'Managing Director', 'Software Engineer', 'HR Executive', 'Accountant', 'Sales Representative'];
        foreach ($defaults as $def) {
            $insert->execute([$def]);
        }
        echo "Designations table created and seeded.";
    } else {
        echo "Designations table exists and is already seeded.";
    }
} catch (PDOException $e) {
    echo "Failed: " . $e->getMessage();
}
?>
