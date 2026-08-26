<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function loginPage() {
        // If already logged in, redirect to admin
        if (isset($_SESSION['admin_id'])) {
            header("Location: index.php?page=admin");
            exit;
        }
        require_once '../app/Views/login.php';
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['success'] = "Welcome back, " . htmlspecialchars($admin['full_name']) . "!";
            header("Location: index.php?page=admin");
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        session_start();
        $_SESSION['success'] = "You have been logged out successfully.";
        header("Location: index.php?page=login");
        exit;
    }

    public function profilePage() {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        require_once '../app/Views/profile.php';
    }

    public function updateProfile($data) {
        $name = trim($data['full_name']);
        if (empty($name)) {
            $_SESSION['error'] = "Full name cannot be empty.";
        } else {
            $stmt = $this->pdo->prepare("UPDATE admins SET full_name = ? WHERE id = ?");
            $stmt->execute([$name, $_SESSION['admin_id']]);
            $_SESSION['admin_name'] = $name; // Update session name
            $_SESSION['success'] = "Profile updated successfully.";
        }
        header("Location: index.php?page=profile");
        exit;
    }

    public function changePassword($data) {
        $old = $data['old_password'];
        $new = $data['new_password'];
        $confirm = $data['confirm_password'];

        $stmt = $this->pdo->prepare("SELECT password_hash FROM admins WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $hash = $stmt->fetchColumn();

        if (!password_verify($old, $hash)) {
            $_SESSION['error'] = "Incorrect current password.";
        } elseif ($new !== $confirm) {
            $_SESSION['error'] = "New passwords do not match.";
        } elseif (strlen($new) < 6) {
            $_SESSION['error'] = "New password must be at least 6 characters.";
        } else {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            $update = $this->pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
            $update->execute([$newHash, $_SESSION['admin_id']]);
            $_SESSION['success'] = "Password changed successfully.";
        }
        header("Location: index.php?page=profile");
        exit;
    }
}
?>
