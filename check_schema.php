<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=payroll_db', 'root', '');
    $stmt = $pdo->query('SHOW CREATE TABLE employees');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['Create Table'];
} catch(Exception $e) { echo $e->getMessage(); }
?>
