<?php
require_once 'app/Controllers/PayrollCalculator.php';

$taxBands = [
    ['limit_amount' => 490.00,  'rate_percentage' => 0.0],
    ['limit_amount' => 110.00,  'rate_percentage' => 5.0],
    ['limit_amount' => 130.00,  'rate_percentage' => 10.0],
    ['limit_amount' => 3166.67, 'rate_percentage' => 17.5],
    ['limit_amount' => 16000.00,'rate_percentage' => 25.0],
    ['limit_amount' => null,    'rate_percentage' => 30.0],
];

$rows = [
    ['name' => 'Row 1 (CEO)',       'basic' => 10000, 'allow' => 5000, 'excel_paye' => 3211.00],
    ['name' => 'Row 2 (Director)',  'basic' => 7000,  'allow' => 3000, 'excel_paye' => 2002.00],
    ['name' => 'Row 6 (Isaac)',     'basic' => 6000,  'allow' => 2000, 'excel_paye' => 1598.00],
    ['name' => 'Row 9 (Sakina)',    'basic' => 2000,  'allow' => 1000, 'excel_paye' => 395.50],
    ['name' => 'Row 11 (Richard)',  'basic' => 2000,  'allow' => 2000, 'excel_paye' => 571.50],
    ['name' => 'Row 12 (Kwaku)',    'basic' => 1500,  'allow' => 1000, 'excel_paye' => 313.80]
];

echo str_pad("Employee", 20) . " | " . str_pad("Chargeable", 10) . " | " . str_pad("Code PAYE", 10) . " | " . str_pad("Excel PAYE", 10) . " | " . "Diff\n";
echo str_repeat("-", 70) . "\n";

foreach ($rows as $r) {
    $c = new PayrollCalculator($r['basic'], $r['allow'], $taxBands);
    $chargeable = $c->getChargeableIncome();
    $code_paye = $c->getPAYE();
    $diff = $code_paye - $r['excel_paye'];
    
    echo str_pad($r['name'], 20) . " | " . 
         str_pad($chargeable, 10) . " | " . 
         str_pad(number_format($code_paye, 2, '.', ''), 10) . " | " . 
         str_pad(number_format($r['excel_paye'], 2, '.', ''), 10) . " | " . 
         number_format($diff, 2, '.', '') . "\n";
}
?>
