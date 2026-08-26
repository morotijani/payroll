<?php
class SettingsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Display the Settings page
     */
    public function index() {
        $stmt = $this->pdo->query("SELECT * FROM company_settings LIMIT 1");
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        require_once '../app/Views/settings.php';
    }

    /**
     * Update the company settings and logo
     */
    public function update($data, $files) {
        $name = trim($data['company_name']);
        $email = trim($data['company_email']);
        $phone = trim($data['company_phone']);
        $address = trim($data['company_address']);

        if (empty($name)) {
            $_SESSION['error'] = "Company Name is required.";
            header("Location: index.php?page=settings");
            exit;
        }

        // Handle File Upload
        $logoPath = null;
        if (isset($files['company_logo']) && $files['company_logo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($files['company_logo']['type'], $allowedTypes)) {
                $_SESSION['error'] = "Invalid file type. Only JPG, PNG, GIF, and WEBP are allowed.";
                header("Location: index.php?page=settings");
                exit;
            }
            
            // Get current logo to delete it
            $stmt = $this->pdo->query("SELECT company_logo FROM company_settings WHERE id = 1");
            $currentLogo = $stmt->fetchColumn();
            if ($currentLogo && file_exists('../public/' . $currentLogo)) {
                unlink('../public/' . $currentLogo);
            }

            $ext = pathinfo($files['company_logo']['name'], PATHINFO_EXTENSION);
            $filename = 'logo_' . time() . '.' . $ext;
            $destination = '../public/uploads/logos/' . $filename;
            
            if (move_uploaded_file($files['company_logo']['tmp_name'], $destination)) {
                $logoPath = 'uploads/logos/' . $filename;
            }
        }

        if ($logoPath) {
            $stmt = $this->pdo->prepare("UPDATE company_settings SET company_name = ?, company_logo = ?, company_email = ?, company_phone = ?, company_address = ? WHERE id = 1");
            $stmt->execute([$name, $logoPath, $email, $phone, $address]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE company_settings SET company_name = ?, company_email = ?, company_phone = ?, company_address = ? WHERE id = 1");
            $stmt->execute([$name, $email, $phone, $address]);
        }
        
        $_SESSION['success'] = "Company settings updated successfully.";
        header("Location: index.php?page=settings");
        exit;
    }
}
?>
