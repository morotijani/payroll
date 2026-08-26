<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $pdo->exec("ALTER TABLE company_settings ADD COLUMN company_logo VARCHAR(255) NULL AFTER company_name");
    echo "Added company_logo column.\n";
} catch (Exception $e) {
    echo "Error DB: " . $e->getMessage() . "\n";
}

$dir = __DIR__ . '/public/uploads/logos';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
    echo "Created directory: $dir\n";
} else {
    echo "Directory already exists: $dir\n";
}
?>
