<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PayMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <?php global $globalSettings; ?>
    <link rel="icon" href="<?= !empty($globalSettings['company_logo']) ? htmlspecialchars($globalSettings['company_logo']) : 'images/default_logo.png' ?>" type="image/png">
    <style>
        :root {
            --bg-color: #F8F6FC;
            --text-dark: #1A0B2E;
            --white: #FFFFFF;
            --border-radius-lg: 24px;
            --border-radius-pill: 50px;
        }
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--bg-color); 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
        }
        .login-card {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 50px 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 40px rgba(26,11,46,0.05);
            text-align: center;
        }
        .form-control { 
            border-radius: var(--border-radius-pill); 
            padding: 15px 25px; 
            border: 1px solid #EBE7F2; 
            background-color: #F8F6FC; 
            font-size: 1rem; 
        }
        .form-control:focus { 
            background-color: var(--white); 
            box-shadow: 0 0 0 4px rgba(26, 11, 46, 0.1); 
            border-color: var(--text-dark);
        }
        .btn-primary { 
            background-color: var(--text-dark); 
            color: var(--white); 
            border: none;
            border-radius: var(--border-radius-pill);
            padding: 15px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: 0.2s;
        }
        .btn-primary:hover { 
            background-color: #311654; 
        }
        .material-symbols-rounded {
            vertical-align: middle;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 576px) {
            .login-card { 
                padding: 30px 20px; 
                width: 90%; 
            }
            body { align-items: flex-start; padding-top: 50px; }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="mb-4">
        <?php if (!empty($globalSettings['company_logo'])): ?>
            <img src="<?= htmlspecialchars($globalSettings['company_logo']) ?>" alt="Logo" style="height: 60px; border-radius: 8px;">
        <?php else: ?>
            <img src="images/default_logo.png" alt="Logo" style="height: 60px; border-radius: 8px;">
        <?php endif; ?>
        <h2 style="font-weight: 800; margin-top: 15px; letter-spacing: -0.5px;"><?= htmlspecialchars($globalSettings['company_name'] ?? 'PayMaster') ?></h2>
        <p style="color: #6B5C82; font-weight: 500;">Sign in to manage payroll</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="border-radius: 16px; background-color: #FDE8E8; color: #7F1D1D; border: none; font-size: 0.9rem;">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="border-radius: 16px; background-color: #E2F5EC; color: #0C4A2E; border: none; font-size: 0.9rem;">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=do_login" method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-4">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center">
            Sign In <span class="material-symbols-rounded ms-2">login</span>
        </button>
    </form>
</div>

<!-- jQuery for global fade out -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Find any alert on the page, wait 10 seconds, then fade it out slowly
        $('.alert').delay(10000).fadeOut('slow');
    });
</script>
</body>
</html>
