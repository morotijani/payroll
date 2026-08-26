<?php require 'layout_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h1 class="page-title mb-0">Documentation & Help</h1>
        <p class="text-muted mt-2">Learn how PayMaster calculates, manages, and locks your payroll data.</p>
    </div>
</div>

<div class="row g-4">
    
    <!-- Mathematical Formulas -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">calculate</span> The Mathematics
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">PayMaster uses a strict algorithm that complies with the Ghana Revenue Authority (GRA) and SSNIT standards. Here is how your money is calculated:</p>
                
                <ul class="list-group list-group-flush" style="font-size: 0.95rem;">
                    <li class="list-group-item px-0 pb-3" style="border-bottom: 1px dashed var(--border-color);">
                        <strong class="text-dark d-block mb-1">Gross Salary</strong>
                        <span class="text-muted"><code>Basic Income + All Allowances</code><br>This is the total earnings before any deductions.</span>
                    </li>
                    <li class="list-group-item px-0 py-3" style="border-bottom: 1px dashed var(--border-color);">
                        <strong class="text-dark d-block mb-1">Employee SSNIT (Tier 1)</strong>
                        <span class="text-muted"><code>5.5% of Basic Income</code><br>Deducted from the employee's pay.</span>
                    </li>
                    <li class="list-group-item px-0 py-3" style="border-bottom: 1px dashed var(--border-color);">
                        <strong class="text-dark d-block mb-1">Chargeable Income</strong>
                        <span class="text-muted"><code>Gross Salary - Employee SSNIT</code><br>This is the exact amount that is passed through the GRA Tax Brackets to calculate Income Tax.</span>
                    </li>
                    <li class="list-group-item px-0 py-3" style="border-bottom: 1px dashed var(--border-color);">
                        <strong class="text-dark d-block mb-1">Income Tax (PAYE)</strong>
                        <span class="text-muted"><code>Calculated progressively based on Chargeable Income</code><br>See the "Tax Bands" section for more details on the progressive loop.</span>
                    </li>
                    <li class="list-group-item px-0 py-3" style="border-bottom: 1px dashed var(--border-color);">
                        <strong class="text-dark d-block mb-1">Employer SSNIT (Tier 1)</strong>
                        <span class="text-muted"><code>13% of Basic Income</code><br>Paid entirely by the company. It does not affect the employee's Net Pay.</span>
                    </li>
                    <li class="list-group-item px-0 pt-3 border-0">
                        <strong class="text-success d-block mb-1">Net Take-Home Pay</strong>
                        <span class="text-muted"><code>Gross Salary - Employee SSNIT - PAYE - Loan Repayments</code></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- The Progressive Tax Loop -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">account_tree</span> Progressive Tax (GRA)
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Unlike a flat tax, the GRA uses a <strong>Progressive Tax System</strong>. This means the Chargeable Income is sliced into "bands".</p>
                
                <div class="inner-card mb-4">
                    <strong class="text-dark d-block mb-2">How the Loop Works:</strong>
                    <ol class="text-muted m-0 ps-3" style="font-size: 0.9rem; line-height: 1.6;">
                        <li>The system looks at the first band (e.g., First GHS 490).</li>
                        <li>If the employee makes more than 490, it taxes that 490 at 0% and subtracts it from their Chargeable Income.</li>
                        <li>It moves to the next band (e.g., Next GHS 110 at 5%) and repeats.</li>
                        <li>If the remaining income is <em>less</em> than a band's limit, it taxes whatever is left and stops immediately.</li>
                        <li>The final band has "No Limit" (Exceeding), catching all remaining income.</li>
                    </ol>
                </div>
                
                <p class="text-muted m-0" style="font-size: 0.9rem;">
                    <strong>Why this is better than Excel:</strong> Excel relies on deeply nested IF statements that easily break if someone accidentally modifies a cell. PayMaster uses a dynamic PHP `foreach` loop that automatically adapts if you change the bands in the Tax Configuration page!
                </p>
            </div>
        </div>
    </div>

    <!-- Managing the System (Tutorials) -->
    <div class="col-12 mt-3 mb-2">
        <h3 class="page-title mb-0" style="font-size: 1.5rem;">How to Use the Dashboard</h3>
    </div>

    <!-- 1. Employees Admin -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">group</span> 1. Employee Directory
            </div>
            <div class="card-body">
                <p class="text-muted" style="font-size: 0.9rem;">The <strong>Employees</strong> page is your active roster. This is where you add new hires and manage existing staff.</p>
                <ul class="text-muted ps-3 mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                    <li class="mb-2"><strong>Add New Hire:</strong> Fill out the Base Salary and any applicable allowances (Risk, Shift, Responsibility). If the employee has a loan, enter the remaining balance here.</li>
                    <li class="mb-2"><strong>Edit & Delete:</strong> When an employee gets a raise, click Edit. Changes here will immediately reflect on their <em>future</em> payslips.</li>
                    <li><strong>Preview Payslip:</strong> The "Payslip" button generates a live, on-the-fly preview of what their payslip looks like <em>right now</em>.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2. Tax Configuration -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">balance</span> 2. Tax Configuration
            </div>
            <div class="card-body">
                <p class="text-muted" style="font-size: 0.9rem;">The <strong>Tax Bands</strong> page controls the mathematical engine of the system. You only need to touch this if the Government changes the tax laws.</p>
                <ul class="text-muted ps-3 mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                    <li class="mb-2"><strong>Limit Amount:</strong> This is the <em>width</em> of the bracket (e.g., GHS 110), not the cumulative total.</li>
                    <li class="mb-2"><strong>Max Bracket:</strong> The final row in the table is strictly for "Exceeding" income. <strong>Leave the Limit Amount blank</strong> for this row so the system knows to tax all remaining income at this percentage.</li>
                    <li><strong>Real-time Updates:</strong> Saving changes here instantly updates the live preview of all payslips.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 3. Payroll History -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">history</span> 3. Running Payroll
            </div>
            <div class="card-body">
                <p class="text-muted" style="font-size: 0.9rem;">The <strong>Payroll Runs</strong> page is where you finalize the month's accounting.</p>
                <ul class="text-muted ps-3 mb-0" style="font-size: 0.9rem; line-height: 1.6;">
                    <li class="mb-2"><strong>The "Run Payroll" Button:</strong> Clicking this takes a permanent "snapshot" of every employee's salary and tax calculation at that exact moment.</li>
                    <li class="mb-2"><strong>Locked History:</strong> These snapshots are saved to the database. If an employee gets a raise next month, their old payslips from previous months will <strong>never change</strong>.</li>
                    <li><strong>View Details:</strong> Click "View Details" on any historical run to reprint an official, locked A5 payslip from the past.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- System Architecture -->
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header d-flex align-items-center">
                <span class="material-symbols-rounded me-2 text-primary">architecture</span> System Architecture
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="inner-card h-100 border text-center">
                            <span class="material-symbols-rounded d-block mb-3" style="font-size: 40px; color: var(--text-dark);">database</span>
                            <strong class="d-block mb-2">MySQL Database</strong>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Separates active data (`employees`) from historical locked records (`payslips`) ensuring past payrolls never change.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inner-card h-100 border text-center">
                            <span class="material-symbols-rounded d-block mb-3" style="font-size: 40px; color: var(--text-dark);">code</span>
                            <strong class="d-block mb-2">PHP MVC Controllers</strong>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">`PayrollCalculator.php` handles all math securely on the server side, making it impossible for clients to manipulate numbers via the browser.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inner-card h-100 border text-center">
                            <span class="material-symbols-rounded d-block mb-3" style="font-size: 40px; color: var(--text-dark);">web</span>
                            <strong class="d-block mb-2">HTML/CSS Views</strong>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">Modern SaaS frontend utilizing the `Outfit` font, Google Material Symbols, and strictly configured `@media print` rules for perfect A5 payslips.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require 'layout_footer.php'; ?>
