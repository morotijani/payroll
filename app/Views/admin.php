<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payroll Admin Dashboard</title>
    <!-- Using a lightweight CSS framework for a quick, clean admin UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 30px; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px; }
    </style>
</head>
<body>
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>ACME Payroll Admin</h2>
        <a href="index.php?page=admin" class="btn btn-outline-secondary">Refresh</a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Add Employee Form -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <strong>➕ Add New Employee</strong>
                </div>
                <div class="card-body">
                    <form action="index.php?page=admin" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Designation</label>
                            <input type="text" name="designation" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Basic Income (GHS)</label>
                            <input type="number" step="0.01" name="basic_income" class="form-control" required>
                        </div>
                        
                        <hr>
                        <h6 class="text-muted">Allowances & Loans</h6>
                        
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 14px;">Risk Allowance</label>
                            <input type="number" step="0.01" name="risk_allowance" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 14px;">Shift Allowance</label>
                            <input type="number" step="0.01" name="shift_allowance" class="form-control form-control-sm">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 14px;">Responsibility Allowance</label>
                            <input type="number" step="0.01" name="responsibility_allowance" class="form-control form-control-sm">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 14px;">Loan Balance (Outstanding)</label>
                            <input type="number" step="0.01" name="loan_balance" class="form-control form-control-sm">
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Save Employee</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Employees List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <strong>👥 Employee Directory</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Basic (GHS)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($employees)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-3">No employees found. Add one on the left.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($employees as $emp): ?>
                                    <tr>
                                        <td><?= $emp['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($emp['name']) ?></strong></td>
                                        <td><?= htmlspecialchars($emp['designation']) ?></td>
                                        <td><?= number_format($emp['basic_income'], 2) ?></td>
                                        <td>
                                            <!-- Link to generate and print their payslip -->
                                            <a href="index.php?page=payslip&id=<?= $emp['id'] ?>" target="_blank" class="btn btn-sm btn-success">
                                                📄 View Payslip
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
