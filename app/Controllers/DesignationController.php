<?php
class DesignationController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $stmt = $this->pdo->query("SELECT * FROM designations ORDER BY name ASC");
        $designations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once '../app/Views/designations.php';
    }

    public function add($data) {
        $name = trim($data['name']);
        if (empty($name)) {
            $_SESSION['error'] = "Designation name cannot be empty.";
        } else {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO designations (name) VALUES (?)");
                $stmt->execute([$name]);
                $_SESSION['success'] = "Designation added successfully.";
            } catch (PDOException $e) {
                // Handle unique constraint violation
                if ($e->getCode() == 23000) {
                    $_SESSION['error'] = "This designation already exists.";
                } else {
                    $_SESSION['error'] = "Failed to add designation.";
                }
            }
        }
        header("Location: index.php?page=designations");
        exit;
    }

    public function update($data) {
        $id = $data['id'];
        $name = trim($data['name']);
        
        if (empty($name)) {
            $_SESSION['error'] = "Designation name cannot be empty.";
        } else {
            try {
                $stmt = $this->pdo->prepare("UPDATE designations SET name = ? WHERE id = ?");
                $stmt->execute([$name, $id]);
                $_SESSION['success'] = "Designation updated successfully.";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $_SESSION['error'] = "This designation already exists.";
                } else {
                    $_SESSION['error'] = "Failed to update designation.";
                }
            }
        }
        header("Location: index.php?page=designations");
        exit;
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM designations WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = "Designation deleted successfully.";
        header("Location: index.php?page=designations");
        exit;
    }
}
?>
