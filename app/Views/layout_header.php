<?php
if (isset($success)) { $_SESSION['success'] = $success; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayMaster Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Outfit (Matches the image typography) and Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        :root {
            --bg-color: #F8F6FC;
            --card-bg: #F1EDF9;
            --text-dark: #1A0B2E;
            --text-muted: #6B5C82;
            --primary: #1A0B2E;
            --white: #FFFFFF;
            --border-radius-lg: 24px;
            --border-radius-pill: 50px;
        }
        
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--bg-color); 
            overflow-x: hidden; 
            color: var(--text-dark); 
        }
        
        /* Material Icons alignment */
        .material-symbols-rounded {
            vertical-align: middle;
            margin-bottom: 2px;
            font-size: 20px;
        }
        
        /* Sidebar Styles */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 260px;
            background: var(--white);
            border-right: 1px solid #EBE7F2;
        }
        .sidebar-heading { 
            padding: 2rem 1.5rem; 
            font-size: 1.6rem; 
            font-weight: 800; 
            color: var(--text-dark); 
            border-bottom: 1px solid #EBE7F2; 
        }
        .list-group-item { 
            background: transparent; 
            color: var(--text-muted); 
            font-weight: 500; 
            padding: 1.2rem 1.5rem; 
            transition: 0.3s; 
            font-size: 1rem; 
            border: none;
        }
        .list-group-item:hover { 
            background-color: var(--bg-color); 
            color: var(--text-dark); 
        }
        .list-group-item.active-nav { 
            background-color: var(--card-bg); 
            color: var(--text-dark); 
            font-weight: 600;
            border-right: 4px solid var(--text-dark);
        }
        .list-group-item .material-symbols-rounded { 
            margin-right: 12px; 
            font-size: 22px; 
        }
        
        /* Page Content Styles */
        #page-content-wrapper { padding: 50px; width: 100%; }
        .page-title { 
            color: var(--text-dark); 
            font-weight: 800; 
            margin-bottom: 30px; 
            font-size: 2.5rem; 
            letter-spacing: -0.5px; 
        }
        
        /* Card Styles matching the image */
        .card { 
            background-color: var(--card-bg);
            border: none; 
            border-radius: var(--border-radius-lg); 
            box-shadow: none;
            overflow: hidden; 
            margin-bottom: 25px; 
            padding: 10px;
        }
        .card-header { 
            background-color: transparent; 
            border-bottom: none; 
            padding: 20px 25px 5px 25px; 
            font-weight: 700; 
            font-size: 1.4rem; 
            color: var(--text-dark); 
        }
        
        /* Table Styles inside cards */
        .card-body { padding: 25px; }
        .table { margin-bottom: 0; background: transparent; }
        .table th { 
            font-weight: 600; 
            color: var(--text-muted); 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
            border-bottom: 1px solid rgba(26,11,46,0.1); 
            padding: 15px 10px; 
            background: transparent; 
        }
        .table td { 
            vertical-align: middle; 
            padding: 15px 10px; 
            color: var(--text-dark); 
            border-bottom: 1px solid rgba(26,11,46,0.05); 
            background: transparent;
        }
        
        /* Form & Button Styles */
        .btn { 
            font-weight: 600; 
            padding: 10px 24px; 
            border-radius: var(--border-radius-pill); 
            transition: 0.2s; 
            font-family: 'Outfit', sans-serif;
            border: none;
        }
        .btn-primary { 
            background-color: var(--text-dark); 
            color: var(--white); 
        }
        .btn-primary:hover { 
            background-color: #311654; 
            color: var(--white);
        }
        .btn-light {
            background-color: var(--white);
            color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .btn-light:hover {
            background-color: #F8F6FC;
        }
        .btn-sm { padding: 8px 16px; font-size: 0.9rem; }
        
        .form-control { 
            border-radius: var(--border-radius-pill); 
            padding: 12px 20px; 
            border: none; 
            background-color: var(--white); 
            font-size: 1rem; 
            color: var(--text-dark);
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .form-control:focus { 
            background-color: var(--white); 
            box-shadow: 0 0 0 4px rgba(26, 11, 46, 0.1); 
        }
        .form-label { 
            font-weight: 600; 
            color: var(--text-dark); 
            font-size: 0.9rem; 
            margin-bottom: 8px; 
            margin-left: 10px;
        }
        
        .inner-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <span class="material-symbols-rounded" style="color: var(--text-dark); font-size: 28px;">payments</span> PayMaster
        </div>
        <div class="list-group list-group-flush mt-3">
            <?php $curr = $_GET['page'] ?? 'admin'; ?>
            <a href="index.php?page=admin" class="list-group-item <?= in_array($curr, ['admin','edit']) ? 'active-nav' : '' ?>">
                <span class="material-symbols-rounded">group</span> Employees
            </a>
            <a href="index.php?page=taxes" class="list-group-item <?= $curr == 'taxes' ? 'active-nav' : '' ?>">
                <span class="material-symbols-rounded">balance</span> Tax Bands
            </a>
            <a href="index.php?page=history" class="list-group-item <?= in_array($curr, ['history', 'view_month']) ? 'active-nav' : '' ?>">
                <span class="material-symbols-rounded">history</span> Payroll Runs
            </a>
            <a href="index.php?page=help" class="list-group-item <?= $curr == 'help' ? 'active-nav' : '' ?> mt-4" style="border-top: 1px solid #EBE7F2;">
                <span class="material-symbols-rounded">menu_book</span> Documentation
            </a>
        </div>
    </div>
    
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <!-- Flash Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 16px; background-color: #E2F5EC; color: #0C4A2E;">
                    <span class="material-symbols-rounded">check_circle</span> <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 16px; background-color: #FDE8E8; color: #7F1D1D;">
                    <span class="material-symbols-rounded">error</span> <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
