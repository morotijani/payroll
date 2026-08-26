<?php
class TaxController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Display the Tax Bands settings page
     */
    public function index() {
        $stmt = $this->pdo->query("SELECT * FROM tax_bands ORDER BY id ASC");
        $taxBands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
        unset($_SESSION['success']);
        
        require_once '../app/Views/tax_bands.php';
    }

    /**
     * Update all tax bands via POST
     */
    public function updateAll($data) {
        $sql = "UPDATE tax_bands SET limit_amount = :limit, rate_percentage = :rate WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        if (isset($data['rates']) && is_array($data['rates'])) {
            foreach ($data['rates'] as $id => $rate) {
                // If limit is left blank, we treat it as NULL (meaning "Exceeding" or "The rest")
                $limit = isset($data['limits'][$id]) && $data['limits'][$id] !== '' ? $data['limits'][$id] : null;
                
                $stmt->execute([
                    ':limit' => $limit,
                    ':rate'  => $rate,
                    ':id'    => $id
                ]);
            }
        }

        $_SESSION['success'] = "Tax bands updated successfully! Future payslips will now use these new rates.";
        header("Location: index.php?page=taxes");
        exit;
    }
}
?>
