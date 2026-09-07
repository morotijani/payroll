<?php
$files = glob('c:\xampp\htdocs\payroll\app\Views\*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    // Replace index.php?page=view_month&month=... with view_month?month=...
    $content = preg_replace('/index\.php\?page=([a-zA-Z0-9_]+)&/', '$1?', $content);
    // Replace index.php?page=admin with admin
    $content = preg_replace('/index\.php\?page=([a-zA-Z0-9_]+)/', '$1', $content);
    file_put_contents($file, $content);
}
echo "Replaced in " . count($files) . " files.\n";

// Also check Controllers for header("Location: index.php?page=...")
$files = glob('c:\xampp\htdocs\payroll\app\Controllers\*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = preg_replace('/Location:\s*index\.php\?page=([a-zA-Z0-9_]+)&/', 'Location: $1?', $content);
    $content = preg_replace('/Location:\s*index\.php\?page=([a-zA-Z0-9_]+)/', 'Location: $1', $content);
    file_put_contents($file, $content);
}
echo "Replaced in " . count($files) . " controllers.\n";
?>
